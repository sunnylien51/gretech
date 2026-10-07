<?php

use Illuminate\Container\Container;
use TightenCo\Jigsaw\Events\EventBus;
use TightenCo\Jigsaw\Jigsaw;
use Symfony\Component\Finder\Finder;

/** @var Container $container */
/** @var EventBus $events */

/*
 * Live Server 若以專案根目錄當伺服器根（網址含 /build_production/...），
 * HTML 裡的 /static、/images 會指到錯誤位置。建置後改成依頁面深度的相對路徑，
 * Netlify（publish = build_production）與子資料夾預覽都能用。
 */
$events->afterBuild(function (Jigsaw $jigsaw) {
    $root = realpath($jigsaw->getDestinationPath());
    if ($root === false) {
        return;
    }

    $finder = (new Finder())
        ->files()
        ->name('*.html')
        ->in($root);

    foreach ($finder as $file) {
        $dir = $file->getPath();
        $relDir = trim(str_replace('\\', '/', substr($dir, strlen($root))), '/');
        $depth = $relDir === '' ? 0 : substr_count($relDir, '/') + 1;
        $prefix = $depth === 0 ? './' : str_repeat('../', $depth);

        $html = $file->getContents();
        $updated = preg_replace_callback(
            '/\b(href|src)=([\'"])\/(?!\/)([^\'"]*)\2/i',
            function (array $m) use ($prefix, $html) {
                // 保留 canonical 用站內絕對路徑（SEO）
                $quote = $m[2];
                $attr = $m[1];
                $path = $m[3];
                $full = $m[0];

                $pos = strpos($html, $full);
                if ($pos !== false) {
                    $window = substr($html, max(0, $pos - 80), 80);
                    if (stripos($window, 'rel="canonical"') !== false || stripos($window, "rel='canonical'") !== false) {
                        return $full;
                    }
                }

                return $attr . '=' . $quote . $prefix . $path . $quote;
            },
            $html
        );

        if (is_string($updated) && $updated !== $html) {
            file_put_contents($file->getPathname(), $updated);
        }
    }
});
