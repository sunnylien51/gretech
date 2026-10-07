import { spawn } from 'node:child_process';
import { existsSync, readFileSync, rmSync, statSync } from 'node:fs';
import path from 'node:path';
import jigsaw from '@tighten/jigsaw-vite-plugin';
import { defineConfig } from 'vite';

const root = process.cwd();
const hotFile = path.join(root, 'source', 'hot');
const localBuildDir = path.join(root, 'build_local');

const mimeTypes = {
    '.html': 'text/html; charset=utf-8',
    '.css': 'text/css; charset=utf-8',
    '.js': 'text/javascript; charset=utf-8',
    '.json': 'application/json; charset=utf-8',
    '.svg': 'image/svg+xml',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.webp': 'image/webp',
    '.avif': 'image/avif',
    '.ico': 'image/x-icon',
    '.mp4': 'video/mp4',
    '.webm': 'video/webm',
    '.woff': 'font/woff',
    '.woff2': 'font/woff2',
    '.pdf': 'application/pdf',
    '.txt': 'text/plain; charset=utf-8',
    '.xml': 'application/xml; charset=utf-8',
};

// 專案路徑含空白（windows D），官方外掛用絕對路徑呼叫 Jigsaw 會失敗，所以一律用相對路徑自己跑。
function runJigsaw(env) {
    return new Promise((resolve, reject) => {
        const child = spawn('php', ['vendor/bin/jigsaw', 'build', env], {
            cwd: root,
            stdio: 'inherit',
        });

        child.on('error', reject);
        child.on('exit', (code) => {
            if (code) {
                reject(new Error(`Jigsaw build ${env} exited with code ${code}`));
                return;
            }

            resolve();
        });
    });
}

function resolveLocalFile(url) {
    const pathname = decodeURIComponent(url.split('?')[0]);
    const filePath = path.join(localBuildDir, pathname);

    if (!filePath.startsWith(localBuildDir)) {
        return null;
    }

    if (existsSync(filePath) && statSync(filePath).isFile()) {
        return filePath;
    }

    const indexPath = path.join(filePath, 'index.html');
    if (existsSync(indexPath)) {
        return indexPath;
    }

    return null;
}

function jigsawDev() {
    return {
        name: 'jigsaw-dev',
        apply: 'serve',
        configureServer(server) {
            let building = false;
            let queued = false;
            let timer = null;
            let opened = false;

            const rebuild = async () => {
                if (building) {
                    queued = true;
                    return;
                }

                building = true;
                const start = performance.now();

                try {
                    await runJigsaw('local');
                    server.config.logger.info(`jigsaw 重建完成 ${Math.round(performance.now() - start)}ms`, { timestamp: true });
                    server.ws.send({ type: 'full-reload', path: '*' });

                    if (!opened) {
                        opened = true;
                        server.openBrowser();
                    }
                } catch (error) {
                    server.config.logger.error(error.message, { timestamp: true });
                } finally {
                    building = false;

                    if (queued) {
                        queued = false;
                        rebuild();
                    }
                }
            };

            const scheduleRebuild = () => {
                clearTimeout(timer);
                timer = setTimeout(rebuild, 150);
            };

            const shouldRebuild = (file) => {
                const relative = path.relative(root, file).split(path.sep).join('/');

                if (['config.php', 'config.local.php', 'bootstrap.php'].includes(relative)) {
                    return true;
                }

                // collection remote items 會寫入 source/_*/_tmp，忽略以免無限重建／整頁跳刷新
                if (relative.includes('/_tmp/') || relative.endsWith('/_tmp')) {
                    return false;
                }

                return relative.startsWith('source/')
                    && !relative.startsWith('source/_assets/')
                    && !relative.startsWith('source/static/')
                    && relative !== 'source/hot';
            };

            const onFileEvent = (file) => {
                if (shouldRebuild(file)) {
                    scheduleRebuild();
                }
            };

            server.watcher.on('add', onFileEvent);
            server.watcher.on('change', onFileEvent);
            server.watcher.on('unlink', onFileEvent);

            // hot 檔要在伺服器啟動後才寫入，首次建置要等它出現，HTML 才會指向 dev server。
            server.httpServer?.once('listening', () => {
                const waitForHotFile = (tries = 0) => {
                    if (existsSync(hotFile) || tries > 50) {
                        rebuild();
                        return;
                    }

                    setTimeout(() => waitForHotFile(tries + 1), 100);
                };

                waitForHotFile();
            });

            server.middlewares.use((req, res, next) => {
                if (req.method !== 'GET' && req.method !== 'HEAD') {
                    next();
                    return;
                }

                const pathname = req.url.split('?')[0];
                if (!pathname.endsWith('/') && !path.extname(pathname) && resolveLocalFile(`${pathname}/`)) {
                    res.statusCode = 301;
                    res.setHeader('Location', `${pathname}/`);
                    res.end();
                    return;
                }

                const filePath = resolveLocalFile(req.url);
                if (!filePath) {
                    next();
                    return;
                }

                const extension = path.extname(filePath).toLowerCase();
                let body = readFileSync(filePath);

                // hot 檔可能寫成 [::1]，和瀏覽器網址不同源；改成相對路徑，用哪個網址開都吃得到。
                if (extension === '.html' && existsSync(hotFile)) {
                    const devServerUrl = readFileSync(hotFile, 'utf8').trim();
                    body = body.toString().replaceAll(`${devServerUrl}/`, '/');
                }

                res.setHeader('Content-Type', mimeTypes[extension] ?? 'application/octet-stream');
                res.setHeader('Cache-Control', 'no-store');
                res.end(req.method === 'HEAD' ? undefined : body);
            });
        },
    };
}

function jigsawProduction() {
    return {
        name: 'jigsaw-production',
        apply: 'build',
        async closeBundle() {
            // dev server 異常關閉時 hot 檔會殘留，正式版的 CSS/JS 就會指向 localhost:5173。
            rmSync(hotFile, { force: true });
            await runJigsaw('production');
        },
    };
}

function officialJigsawPlugin() {
    return jigsaw({
        input: [
            'source/_assets/js/main.js',
            'source/_assets/css/main.css',
        ],
        refresh: false,
        outDir: 'source/static',
        buildDirectory: 'static',
    }).map((plugin) => {
        if (plugin.name !== 'jigsaw') {
            return plugin;
        }

        const { configureServer, closeBundle, ...rest } = plugin;
        return rest;
    });
}

export default defineConfig({
    build: {
        assetsDir: '',
    },
    server: {
        watch: {
            ignored: [
                '**/build_*/**',
                '**/cache/**',
                '**/vendor/**',
                '**/source/**/_tmp/**',
            ],
        },
    },
    plugins: [
        officialJigsawPlugin(),
        jigsawDev(),
        jigsawProduction(),
    ],
});
