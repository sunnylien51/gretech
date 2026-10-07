@php
    $footer = $page->footer ?? [];
@endphp

<footer class="relative mt-auto w-full">
    <div class="relative overflow-hidden bg-gray5 md:h-72 lg:h-80">
        <img
            src="{{ $page->baseUrl }}/images/bg_contact.jpg"
            alt=""
            class="absolute inset-0 h-full w-full object-cover opacity-50"
            aria-hidden="true"
        >
        <div class="relative z-10 flex h-full flex-col md:flex-row md:items-stretch">
            <a href="{{ $page->baseUrl }}/careers/" class="footer-cta flex flex-1 flex-col items-center justify-center px-6 py-16 text-center md:h-full md:px-10 md:py-0 lg:px-14" data-aos="fade-up">
                <div class="footer-cta-inner">
                    <div class="footer-cta-copy">
                        <h2 class="text-ch3 text-white">人才招募</h2>
                        <p class="text-cb2 text-gray1">歡迎優秀人才加入，與我們一同成長。</p>
                    </div>
                    <div class="footer-cta-action">
                        <div>
                            <span class="btn-on-dark">
                                <i data-lucide="arrow-right" class="btn-on-dark-icon"></i>
                                <span>Read more</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            <div class="relative z-10 mx-6 h-px bg-white/20 md:mx-0 md:h-40 md:w-px md:self-center lg:h-48" data-aos="fade" data-aos-delay="100"></div>
            <a href="{{ $page->baseUrl }}/contact/" class="footer-cta flex flex-1 flex-col items-center justify-center px-6 py-16 text-center md:h-full md:px-10 md:py-0 lg:px-14" data-aos="fade-up" data-aos-delay="150">
                <div class="footer-cta-inner">
                    <div class="footer-cta-copy">
                        <h2 class="text-ch3 text-white">聯絡我們</h2>
                        <p class="text-cb2 text-gray1">如有任何需求，歡迎隨時與我們聯繫。</p>
                    </div>
                    <div class="footer-cta-action">
                        <div>
                            <span class="btn-on-dark">
                                <i data-lucide="arrow-right" class="btn-on-dark-icon"></i>
                                <span>Read more</span>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="bg-gray5">
        <div class="layout-grid flex flex-col items-start gap-8 py-10 lg:flex-row lg:items-center lg:justify-between lg:gap-9 lg:py-14" data-aos="fade-up">
            <div class="flex w-full max-w-xs flex-col items-start gap-3 lg:w-72">
                <a href="{{ $page->baseUrl }}/" class="shrink-0">
                    <img src="{{ $page->baseUrl }}/images/logo.svg" alt="{{ $page->siteName }}" class="footer-logo h-9 w-auto">
                </a>
                <div class="flex items-center gap-4 text-cb3 text-gray3">
                    <a href="{{ $page->baseUrl }}/privacy/" class="footer-meta-link">隱私權政策</a>
                    <span aria-hidden="true">|</span>
                    <a href="{{ $page->baseUrl }}/terms/" class="footer-meta-link">服務條款</a>
                </div>
            </div>

            <div class="flex flex-1 flex-col items-start gap-0.5 text-cb3 text-gray3">
                <p>{{ $footer['address'] ?? '' }}</p>
                <p class="flex flex-col items-start gap-0.5 md:flex-row md:items-center md:gap-0">
                    <a href="mailto:{{ $footer['email'] ?? '' }}" class="footer-meta-link">E-mail：{{ $footer['email'] ?? '' }}</a>
                    <span class="hidden px-1 md:inline" aria-hidden="true">　</span>
                    <a href="tel:{{ $footer['phoneTel'] ?? '' }}" class="footer-meta-link">TEL：{{ $footer['phone'] ?? '' }}</a>
                </p>
                <p>Copyright © {{ date('Y') }} {{ $footer['copyrightName'] ?? $page->siteName }} All rights reserved.</p>
            </div>
        </div>
    </div>

    <button id="back-to-top" class="fixed right-4 bottom-4 z-50 flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-main1 text-white shadow-lg transition-all duration-300 hover:bg-main2 hover:scale-110 active:scale-95 lg:right-6 lg:bottom-6 lg:h-14 lg:w-14" aria-label="返回頁首">
        <i data-lucide="chevron-up" class="h-5 w-5"></i>
    </button>
</footer>
