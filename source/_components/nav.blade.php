@php
    $navItems = [
        ['label' => '關於我們', 'path' => '/about'],
        ['label' => '產品介紹', 'path' => '/products'],
        ['label' => '應用領域', 'path' => '/applications'],
        ['label' => '人力招募', 'path' => '/careers'],
        ['label' => '聯絡我們', 'path' => '/contact'],
    ];
@endphp

<header id="main-header" class="relative sticky top-0 z-[100] w-full">
    <nav id="main-nav" class="layout-grid relative items-center justify-between gap-4 py-4 md:py-5" aria-label="主選單">
        <div class="flex min-w-0 items-center gap-8 lg:gap-14">
            <a href="{{ $page->baseUrl }}/" class="relative z-50 shrink-0">
                <img src="{{ $page->baseUrl }}/images/logo.svg" alt="{{ $page->siteName }}" class="h-9 w-auto">
            </a>

            <ul
                id="nav-menu"
                class="nav-menu fixed inset-0 z-40 flex-col gap-1 overflow-y-auto bg-white px-6 pt-24 pb-8 lg:static lg:inset-auto lg:z-auto lg:flex-row lg:items-center lg:gap-6 lg:overflow-visible lg:bg-transparent lg:p-0"
            >
                @foreach ($navItems as $item)
                    <li class="w-full lg:w-auto">
                        <a
                            href="{{ $page->baseUrl }}{{ $item['path'] }}/"
                            class="nav-link text-cb2 relative flex w-full items-center rounded-[8px] px-4 py-3 text-gray5 lg:w-20 lg:justify-center lg:rounded-none lg:px-0 lg:py-1 {{ $page->isActive($item['path']) }}"
                        >{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="relative z-50 flex shrink-0 items-center gap-2">
            <div class="relative" id="lang-switch">
                <button
                    type="button"
                    id="lang-btn"
                    class="lang-btn inline-flex w-20 cursor-pointer items-center justify-between rounded-full border border-gray5 py-2 pl-4 pr-2.5 text-gray5 opacity-80"
                    aria-expanded="false"
                    aria-haspopup="listbox"
                    aria-controls="lang-menu"
                >
                    <span id="lang-label" class="text-eb3">TW</span>
                    <i data-lucide="chevron-down" class="lang-chevron h-4 w-4"></i>
                </button>
                <ul
                    id="lang-menu"
                    class="lang-menu absolute right-0 top-[calc(100%+0.5rem)] z-50 flex min-w-full flex-col gap-1 overflow-hidden rounded-[12px] border border-gray1 bg-white p-1 shadow-[0_8px_24px_rgba(12,11,18,0.08)]"
                    role="listbox"
                    aria-label="語言"
                >
                    <li>
                        <button type="button" class="lang-option text-eb3 is-active flex w-full cursor-pointer items-center justify-center rounded-[10px] px-3 py-2 text-gray5" role="option" aria-selected="true" data-lang="TW">TW</button>
                    </li>
                    <li>
                        <button type="button" class="lang-option text-eb3 flex w-full cursor-pointer items-center justify-center rounded-[10px] px-3 py-2 text-gray5" role="option" aria-selected="false" data-lang="EN">EN</button>
                    </li>
                </ul>
            </div>

            <button
                type="button"
                id="mobile-menu-btn"
                class="nav-icon-btn inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full text-gray5 lg:hidden"
                aria-label="開啟選單"
                aria-expanded="false"
                aria-controls="nav-menu"
            >
                <i data-lucide="menu" class="nav-icon-menu h-6 w-6"></i>
                <i data-lucide="x" class="nav-icon-close h-6 w-6"></i>
            </button>
        </div>
    </nav>
</header>
