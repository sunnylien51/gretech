<?php

function gretech_product_slug(string $l2Id, string $name, int $n, array &$used): string
{
    $fromName = strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $fromName = trim($fromName, '-');
    $base = ($fromName !== '' && strlen($fromName) >= 2)
        ? $l2Id . '-' . $fromName
        : $l2Id . '-' . $n;

    $slug = $base;
    $suffix = 2;
    while (isset($used[$slug])) {
        $slug = $base . '-' . $suffix;
        $suffix++;
    }
    $used[$slug] = true;

    return $slug;
}

function gretech_enrich_product_catalog(array $catalog): array
{
    $used = [];
    $enriched = [];

    foreach ($catalog as $l1) {
        $categories = [];

        foreach ($l1['categories'] ?? [] as $l2) {
            $products = [];
            $n = 0;

            foreach ($l2['products'] ?? [] as $product) {
                $n++;
                $title = trim((string) ($product['title'] ?? $product['name'] ?? ''));
                $image = trim((string) ($product['image'] ?? ''));
                $intro = trim((string) ($product['intro'] ?? ''));

                if ($intro === '') {
                    $intro = $title . '。歡迎聯繫我們了解規格、應用與供貨細節。';
                }

                $showOnHome = array_key_exists('showOnHome', $product)
                    ? (bool) $product['showOnHome']
                    : ($image !== '');

                $homeOrder = array_key_exists('homeOrder', $product)
                    ? (int) $product['homeOrder']
                    : null;

                $products[] = [
                    'title' => $title,
                    'image' => $image,
                    'intro' => $intro,
                    'showOnHome' => $showOnHome,
                    'homeOrder' => $homeOrder,
                    'slug' => gretech_product_slug($l2['id'], $title, $n, $used),
                    'l1_id' => $l1['id'],
                    'l1_name' => $l1['name'],
                    'l2_id' => $l2['id'],
                    'l2_name' => $l2['name'],
                ];
            }

            $categories[] = [
                'id' => $l2['id'],
                'name' => $l2['name'],
                'products' => $products,
            ];
        }

        $enriched[] = [
            'id' => $l1['id'],
            'name' => $l1['name'],
            'categories' => $categories,
        ];
    }

    return $enriched;
}

function gretech_product_collection_items($catalog): array
{
    $items = [];

    foreach ($catalog as $l1) {
        foreach ($l1['categories'] ?? [] as $l2) {
            foreach ($l2['products'] ?? [] as $product) {
                $items[] = [
                    'filename' => $product['slug'] ?? '',
                    'title' => $product['title'] ?? '',
                    'description' => $product['intro'] ?? '',
                    'image' => $product['image'] ?? '',
                    'intro' => $product['intro'] ?? '',
                    'showOnHome' => (bool) ($product['showOnHome'] ?? false),
                    'homeOrder' => $product['homeOrder'] ?? null,
                    'l1_id' => $product['l1_id'] ?? '',
                    'l1_name' => $product['l1_name'] ?? '',
                    'l2_id' => $product['l2_id'] ?? '',
                    'l2_name' => $product['l2_name'] ?? '',
                    'content' => '',
                ];
            }
        }
    }

    return $items;
}

function gretech_as_array($value): array
{
    if (is_array($value)) {
        return $value;
    }

    if (is_object($value)) {
        return json_decode(json_encode($value), true) ?? [];
    }

    return [];
}

/** 首頁產品區塊：與產品目錄連動（上架於首頁 + 有圖，最多 $limit 筆；可設 homeOrder 調整順序） */
function gretech_home_products($catalog, int $limit = 12): array
{
    $items = [];
    $catalogIndex = 0;

    foreach (gretech_product_collection_items(gretech_as_array($catalog)) as $product) {
        $catalogIndex++;

        if (!(bool) ($product['showOnHome'] ?? false)) {
            continue;
        }

        $image = trim((string) ($product['image'] ?? ''));
        if ($image === '') {
            continue;
        }

        $intro = trim((string) ($product['intro'] ?? $product['description'] ?? ''));
        $parts = preg_split("/\n\s*\n/", $intro) ?: [];
        $description = trim((string) ($parts[0] ?? $intro));
        $description = trim(preg_replace('/\s+/u', ' ', $description) ?? $description);
        $title = (string) ($product['title'] ?? '');

        $l1Name = trim((string) ($product['l1_name'] ?? ''));
        $l2Name = trim((string) ($product['l2_name'] ?? ''));
        $hierarchy = trim($l1Name . ($l1Name !== '' && $l2Name !== '' ? '｜' : '') . $l2Name);

        $homeOrder = $product['homeOrder'] ?? null;

        $items[] = [
            'title' => $title,
            'subtitle' => $hierarchy,
            'description' => $description,
            'image' => $image,
            'thumb' => $image,
            'label' => $title,
            '_homeOrder' => is_int($homeOrder) || is_numeric($homeOrder) ? (int) $homeOrder : PHP_INT_MAX,
            '_catalogIndex' => $catalogIndex,
        ];
    }

    usort($items, static function (array $a, array $b): int {
        $order = ($a['_homeOrder'] ?? PHP_INT_MAX) <=> ($b['_homeOrder'] ?? PHP_INT_MAX);
        if ($order !== 0) {
            return $order;
        }

        return ($a['_catalogIndex'] ?? 0) <=> ($b['_catalogIndex'] ?? 0);
    });

    $items = array_slice($items, 0, max(0, $limit));

    return array_map(static function (array $item): array {
        unset($item['_homeOrder'], $item['_catalogIndex']);

        return $item;
    }, $items);
}

function gretech_application_slug(array $app, int $n, array &$used): string
{
    $explicit = trim((string) ($app['slug'] ?? ''));
    if ($explicit !== '') {
        $base = $explicit;
    } else {
        $image = trim((string) ($app['image'] ?? ''));
        $fromImage = pathinfo(basename($image), PATHINFO_FILENAME);
        $base = ($fromImage !== '' && $fromImage !== '.') ? $fromImage : ('application-' . $n);
    }

    $base = strtolower((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $base));
    $base = trim($base, '-');
    if ($base === '') {
        $base = 'application-' . $n;
    }

    $slug = $base;
    $suffix = 2;
    while (isset($used[$slug])) {
        $slug = $base . '-' . $suffix;
        $suffix++;
    }
    $used[$slug] = true;

    return $slug;
}

function gretech_enrich_applications(array $applications): array
{
    $used = [];
    $enriched = [];
    $n = 0;

    foreach ($applications as $app) {
        $n++;
        $title = trim((string) ($app['title'] ?? ''));
        $intro = trim((string) ($app['intro'] ?? ''));
        if ($intro === '' && $title !== '') {
            $intro = $title . '。歡迎聯繫我們了解應用與相關方案。';
        }

        $image = trim((string) ($app['image'] ?? ''));
        $showOnHome = array_key_exists('showOnHome', $app)
            ? (bool) $app['showOnHome']
            : true;

        $tags = [];
        foreach (gretech_as_array($app['tags'] ?? []) as $tag) {
            $tag = trim((string) $tag);
            if ($tag !== '') {
                $tags[] = $tag;
            }
        }

        $enriched[] = [
            'category' => (string) ($app['category'] ?? ''),
            'title' => $title,
            'intro' => $intro,
            'body' => trim((string) ($app['body'] ?? '')),
            'tags' => $tags,
            'image' => $image,
            'showOnHome' => $showOnHome,
            'slug' => gretech_application_slug($app, $n, $used),
        ];
    }

    return $enriched;
}

function gretech_application_collection_items($applications): array
{
    $items = [];

    foreach (gretech_as_array($applications) as $app) {
        $slug = (string) ($app['slug'] ?? '');

        $items[] = [
            'filename' => $slug,
            'slug' => $slug,
            'title' => $app['title'] ?? '',
            'description' => $app['intro'] ?? '',
            'intro' => $app['intro'] ?? '',
            'body' => $app['body'] ?? '',
            'tags' => $app['tags'] ?? [],
            'image' => $app['image'] ?? '',
            'category' => $app['category'] ?? '',
            'showOnHome' => (bool) ($app['showOnHome'] ?? true),
            'content' => '',
        ];
    }

    return $items;
}

/** 首頁應用區塊：與應用領域連動（上架於首頁，最多 $limit 筆） */
function gretech_home_applications($applications, int $limit = 10): array
{
    $items = [];

    foreach (gretech_as_array($applications) as $app) {
        if (!(bool) ($app['showOnHome'] ?? true)) {
            continue;
        }

        $items[] = $app;

        if (count($items) >= $limit) {
            break;
        }
    }

    return $items;
}

$config = [
    'production' => false,
    'baseUrl' => '',
    'siteName' => '公司名稱',
    'siteDescription' => '公司描述',
    'description' => '公司描述',
    'language' => 'zh-Hant',
    'collections' => [],

    'heroSlides' => [
        [
            'image' => '/images/main1.webp',
            'enTitle' => 'Always make better',
            'zhText' => '為客戶打造快速、穩定且具效率的整合服務，成為 PCB 與先進 IC 封裝產業最值得信賴的關鍵長期夥伴。',
        ],
        [
            'image' => '/images/main2.webp',
            'enTitle' => 'Always make better',
            'zhText' => '為客戶打造快速、穩定且具效率的整合服務，成為 PCB 與先進 IC 封裝產業最值得信賴的關鍵長期夥伴。',
        ],
        [
            'image' => '/images/main3.webp',
            'enTitle' => 'Always make better',
            'zhText' => '為客戶打造快速、穩定且具效率的整合服務，成為 PCB 與先進 IC 封裝產業最值得信賴的關鍵長期夥伴。',
        ],
    ],

    'footer' => [
        'address' => '桃園市中壢區龍東路597號',
        'email' => 'gre.tech@msa.hinet.net',
        'phone' => '03-4668559',
        'phoneTel' => '034668559',
        'fax' => '03-4668565',
        'copyrightName' => '佢朋國際',
        /* Google 地圖嵌入連結（分享 → 嵌入地圖 → 複製 iframe 的 src） */
        'mapUrl' => 'https://www.google.com/maps?q=' . rawurlencode('桃園市中壢區龍東路597號') . '&z=16&output=embed',
    ],

    /* 首頁－關於我們（之後後台可編修） */
    'homeAbout' => [
        'image' => '/images/about1.jpg',
        'title' => "專注 PCB 產業，\n串聯產品、技術與製程需求",
        'body' => "佢朋專注於 PCB 及 IC 產業，提供設備、原物料、耗材、零組件及技術服務，致力於為客戶打造快速、穩定且具效率的整合服務。透過與國內外專業供應商的長期合作，我們持續掌握產業技術與市場趨勢，積極導入新產品與新技術，協助客戶提升設備效率、優化製程、降低生產成本，並確保關鍵產品與零組件的穩定供應。\n從產品供應到技術整合，佢朋致力於成為 PCB 產業值得信賴的長期合作夥伴。",
        'stats' => [
            [
                'value' => '50',
                'unit' => '位',
                'label' => '擁有專業經驗的團隊成員',
            ],
            [
                'value' => '2.18',
                'unit' => '億',
                'label' => '實收資本額',
            ],
            [
                'value' => '3',
                'unit' => '個',
                'label' => '營運核心據點',
            ],
        ],
    ],

    /* 首頁連動：最多呈現筆數 */
    'homeProductsLimit' => 12,
    'homeApplicationsLimit' => 10,

    /* 首頁輪播／產品應用頁共用（應用可設 showOnHome 上下架於首頁） */
    'applicationCategories' => [
        'PCB製程',
        'PCB製程材料與耗材',
        '工業設備與製程應用',
    ],

    'applications' => [
        [
            'category' => 'PCB製程',
            'title' => '研磨與去毛刺',
            'intro' => '穩定去除毛邊與表面不平整，提升後續製程品質。',
            'image' => '/images/app1.jpg',
            'showOnHome' => true,
        ],
        [
            'category' => 'PCB製程',
            'title' => '水洗與清潔',
            'intro' => '有效清除殘留物與污染，維持板面潔淨與可靠度。',
            'image' => '/images/app2.jpg',
        ],
        [
            'category' => 'PCB製程',
            'title' => '表面處理',
            'intro' => '優化板面狀態，支援後續鍍覆、塗佈與接合製程。',
            'image' => '/images/app3.jpg',
        ],
        [
            'category' => 'PCB製程',
            'title' => '製程保護',
            'intro' => '於關鍵製程提供保護方案，降低損傷與不良風險。',
            'image' => '/images/app4.jpg',
        ],
        [
            'category' => 'PCB製程',
            'title' => '塞孔與填孔',
            'intro' => '對應各種孔徑與結構需求，提升填孔均勻與穩定度。',
            'image' => '/images/app5.jpg',
        ],
        [
            'category' => 'PCB製程',
            'title' => '焊接與噴錫',
            'intro' => '支援焊接與表面塗層製程，確保連接品質與可靠度。',
            'body' => "提供應用於 PCB 製程的焊接與噴錫相關材料與耗材，協助提升焊接品質、錫層均勻性及製程穩定性。\n\n適用於 PCB 製造、電子零組件及相關電路板加工製程，滿足不同生產需求。",
            'tags' => ['PCB 焊接', '噴錫製程', '電路板表面處理', '電子零組件加工'],
            'image' => '/images/app6.jpg',
        ],
        [
            'category' => 'PCB製程材料與耗材',
            'title' => '研磨耗材',
            'intro' => '提供穩定研磨耗材，協助維持產線效率與成品品質。',
            'image' => '/images/app7.jpg',
        ],
        [
            'category' => 'PCB製程材料與耗材',
            'title' => '清潔與過濾耗材',
            'intro' => '支援清潔與過濾需求，維持製程環境與藥水穩定。',
            'image' => '/images/app8.jpg',
        ],
        [
            'category' => 'PCB製程材料與耗材',
            'title' => '製程膠帶與保護材料',
            'intro' => '提供膠帶與保護材料，協助遮蔽、固定與表面防護。',
            'image' => '/images/app9.jpg',
        ],
        [
            'category' => '工業設備與製程應用',
            'title' => '空氣輸送與乾燥',
            'intro' => '優化輸送與乾燥流程，提升產線銜接效率與穩定性。',
            'image' => '/images/app10.jpg',
        ],
    ],

    /* 產品介紹頁：第一層 → 第二層 → 產品列表（欄位：title / image / intro） */
    'productCatalog' => [
        [
            'id' => 'materials',
            'name' => '材料&耗材',
            'categories' => [
                [
                    'id' => 'solder',
                    'name' => '焊接錫材',
                    'products' => [
                        ['title' => '有鉛系列｜錫棒63/37'],
                        ['title' => '無鉛系列｜錫棒306005(SnAg)'],
                        ['title' => '無鉛系列｜NS錫棒(SnNi)'],
                    ],
                ],
                [
                    'id' => 'tape',
                    'name' => '工業膠帶',
                    'products' => [
                        ['title' => '3M｜600膠帶', 'image' => '/images/product4.png'],
                        ['title' => '3M｜681膠帶'],
                        ['title' => '3M｜616膠帶'],
                        ['title' => '3M｜665膠帶'],
                        ['title' => '3M｜244膠帶'],
                        ['title' => '四維｜VP3WHA保護膠帶'],
                        ['title' => '四維｜CM8G噴錫保護膠帶'],
                    ],
                ],
                [
                    'id' => 'nonwoven-wheel',
                    'name' => '不織布研磨輪',
                    'products' => [
                        ['title' => '3M｜PCFB系列刷輪'],
                        ['title' => '工業級｜刷輪#320、#600、#800、#1000', 'image' => '/images/product7.png'],
                    ],
                ],
                [
                    'id' => 'nylon-wheel',
                    'name' => '尼龍刷輪',
                    'products' => [
                        ['title' => '工業級｜尼龍刷輪#320、#600、#800、#1000'],
                    ],
                ],
                [
                    'id' => 'ceramic-wheel',
                    'name' => '陶瓷刷輪',
                    'products' => [
                        ['title' => '日本Alpah-Japan｜#320、#600、#800'],
                    ],
                ],
                [
                    'id' => 'abrasive',
                    'name' => '研磨材料',
                    'products' => [
                        ['title' => '3M｜水砂734（80、120、180、240、400、600、800、1200）', 'image' => '/images/product3.png'],
                        ['title' => '3M｜水砂401Q（2000、2500、3000）'],
                        ['title' => '工業級｜乾砂180、400、600'],
                    ],
                ],
                [
                    'id' => 'filter',
                    'name' => '過濾/水處理',
                    'products' => [
                        ['title' => '工業濾心｜PP式（10"、20"、30"）'],
                        ['title' => '工業濾心｜線繞式（10"、20"、30"）'],
                        ['title' => '吸水海綿輪｜PVA'],
                        ['title' => '吸水海綿輪｜PU'],
                    ],
                ],
            ],
        ],
        [
            'id' => 'process-equipment',
            'name' => '製程設備',
            'categories' => [
                [
                    'id' => 'surface',
                    'name' => '表面處理',
                    'products' => [
                        ['title' => '義大利PolaeMassa｜單軸EVO3000', 'image' => '/images/product2.png'],
                        ['title' => '義大利PolaeMassa｜十軸PEM 650', 'image' => '/images/product5.png'],
                        ['title' => '義大利PolaeMassa｜八軸PEM 650 DS'],
                    ],
                ],
                [
                    'id' => 'plugging',
                    'name' => '塞孔/填孔',
                    'products' => [
                        [
                            'title' => '德國SINGULUS/MASS｜真空塞孔機VCP M+',
                            'image' => '/images/product6.png',
                            'homeOrder' => 1,
                            'intro' => "專為 PCB 製造中的 Through-Hole（通孔）及 Blind Via（盲孔）填孔製程所設計，可使用導電或非導電膏材進行高精度真空填孔。設備透過完整真空腔體對 PCB 進行抽真空，使孔洞內的空氣與水氣有效排出，再進行塞孔膏填充，有助於降低氣泡與填充不完整的風險，提升 Via Filling 的一致性與製程穩定性。其中 VCP 系統採用完整真空腔體（Full Vacuum Chamber），可讓整片 PCB 在受控真空環境下進行處理，並支援 Through-Hole 與 Blind Via 的雙面填充。\n\n依不同生產需求，提供彈性的真空塞孔設備配置：\n\n1塞孔+1刮刀→真空塞孔＋表面膏材刮除的一體化製程\n2塞孔+1刮刀→多次塞孔／較高填孔要求／較高產能需求\n1塞孔→基本真空塞孔需求",
                        ],
                    ],
                ],
                [
                    'id' => 'edge-protect',
                    'name' => '貼邊保護',
                    'products' => [
                        ['title' => 'PCB自動貼邊機｜雙邊/四邊-貼邊機'],
                    ],
                ],
                [
                    'id' => 'analysis',
                    'name' => '分析監控',
                    'products' => [
                        ['title' => '即時藥水分析｜即時藥液分析儀MC-L3Q，MC-MT', 'image' => '/images/product1.png'],
                    ],
                ],
                [
                    'id' => 'washing',
                    'name' => '清洗/水洗',
                    'products' => [
                        ['title' => 'PCB水洗設備｜DEBURR水洗線'],
                        ['title' => 'PCB水洗設備｜成型最終水洗線'],
                        ['title' => 'PCB水洗設備｜成檢最終水洗線'],
                        ['title' => 'PCB水洗設備｜刷磨水洗線'],
                        ['title' => 'PCB水洗設備｜除膠渣後處理水洗線'],
                        ['title' => 'PCB水洗設備｜PTH後處理水洗線'],
                    ],
                ],
            ],
        ],
        [
            'id' => 'industrial',
            'name' => '工業設備',
            'categories' => [
                [
                    'id' => 'air-dry',
                    'name' => '水洗/乾燥',
                    'products' => [
                        ['title' => '空氣懸浮風機｜空氣懸浮風機CIM-7.5'],
                    ],
                ],
            ],
        ],
    ],

    /* 內頁 Banner（後台僅可換圖；標題文案固定於各頁 HTML） */
    'pageBanners' => [
        'default' => [
            'image' => '/images/banner_default.jpg',
        ],
        'about' => [
            'image' => '/images/banner_about.jpg',
        ],
        'products' => [
            'image' => '/images/banner_products.webp',
        ],
        'applications' => [
            'image' => '/images/banner_app.webp',
        ],
        'careers' => [
            'image' => '/images/banner_careers.webp',
        ],
        'contact' => [
            'image' => '/images/banner_contact.webp',
        ],
        'privacy' => [
            'image' => '/images/banner_privacy.jpg',
        ],
        'terms' => [
            'image' => '/images/banner_privacy.jpg',
        ],
    ],

    /* 人力招募－職缺（後台可新增／刪除／排序） */
    'jobs' => [
        [
            'id' => 'sales',
            'title' => '業務專員',
            'location' => '桃園／青埔',
            'type' => '全職',
            'summary' => '負責客戶開發與維護，串聯產品與技術需求。',
            'duties' => "開發並維護 PCB／IC 相關產業客戶\n掌握客戶需求，協調產品、交期與技術支援\n定期拜訪客戶並回報市場資訊\n協助報價、訂單追蹤與售後服務",
            'requirements' => "專科以上學歷，理工或商學相關科系佳\n具業務或產業相關經驗者優先\n溝通協調佳，抗壓性強\n能配合出差",
        ],
        [
            'id' => 'warehouse',
            'title' => '倉儲管理人員',
            'location' => '桃園／觀音',
            'type' => '全職',
            'summary' => '負責進出口倉儲管理與庫存控管。',
            'duties' => "進出貨作業與庫存盤點\n維護倉儲環境與貨品安全\n配合物流與文件作業\n系統登打與異常回報",
            'requirements' => "高中職以上學歷\n具倉儲或物流經驗者優先\n細心負責，可配合體力負荷\n熟悉電腦文書作業",
        ],
        [
            'id' => 'accounting',
            'title' => '會計助理',
            'location' => '桃園／中壢',
            'type' => '全職',
            'summary' => '協助日常帳務、報表與行政相關作業。',
            'duties' => "日常帳務處理與憑證整理\n協助月結、對帳與報表製作\n配合稅務與行政相關作業\n其他主管交辦事項",
            'requirements' => "專科以上學歷，會計、財稅相關科系優先\n熟悉 Excel 等文書軟體\n細心、負責，具備數字敏感度\n具相關經驗者佳",
        ],
    ],

    /* 關於我們頁－公司沿革（可新增／刪除／排序） */
    'companyHistory' => [
        ['year' => '2002', 'text' => '成立佢朋股份有限公司，開始販售PCB產業相關產品。'],
        ['year' => '2005', 'text' => '與日商NIHON SUPERIOR正式簽訂代理銷售合約，成為台灣地區最大無鉛噴錫之原料錫棒供應商。代理德國MASS、美國All4-PCB、義大利POLA&MASSA設備。'],
        ['year' => '2007', 'text' => '成為台灣3M公司之正式經銷商，經銷3M的刷輪、膠帶、砂紙產品。'],
        ['year' => '2009', 'text' => '成立藥水部門，製造販售PCB、SMT製程所需藥水。'],
        ['year' => '2014', 'text' => '代理銷售日商ALPHA-JAPAN陶瓷刷輪產品。'],
        ['year' => '2016', 'text' => '轉投資佢岳環保科技股份有限公司，主要業務為回收電子廢棄物(濾心)中心。'],
        ['year' => '2017', 'text' => '取得ISO 9001認證。'],
        ['year' => '2019', 'text' => '整併各公司營運單位，將生產及行政總部設立於觀音、業務部門設立在青埔、財務單位設立於中壢。'],
        ['year' => '2023', 'text' => '代理銷售新加坡兆晶-即時液體成分監測儀。'],
    ],

    'isActive' => function ($page, $path) {
        $current = trim($page->getPath(), '/');
        $target = trim($path, '/');

        if ($target === '') {
            return $current === '' ? 'active' : '';
        }

        return ($current === $target || str_starts_with($current . '/', $target . '/'))
            ? 'active'
            : '';
    },
];

$config['productCatalog'] = gretech_enrich_product_catalog($config['productCatalog']);
$config['applications'] = gretech_enrich_applications($config['applications'] ?? []);

$config['collections'] = [
    'products' => [
        'path' => 'products/{filename}',
        'extends' => '_layouts.product-detail',
        'items' => function ($config) {
            return gretech_product_collection_items($config['productCatalog'] ?? []);
        },
    ],
    'applications' => [
        'path' => 'applications/{filename}',
        'extends' => '_layouts.application-detail',
        'items' => function ($config) {
            return gretech_application_collection_items($config['applications'] ?? []);
        },
    ],
];

return $config;
