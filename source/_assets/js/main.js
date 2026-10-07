document.addEventListener('DOMContentLoaded', function () {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            offset: 80,
            once: true,
        });
    }

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox]', {});
    }

    // 內頁 banner：等背景圖就緒再播進場，避免載入卡頓時動畫已跑完
    document.querySelectorAll('.page-banner').forEach((banner) => {
        const img = banner.querySelector('.page-banner-image');
        let done = false;

        const reveal = () => {
            if (done) {
                return;
            }
            done = true;
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    banner.classList.add('is-ready');
                });
            });
        };

        if (!img) {
            reveal();
            return;
        }

        if (img.complete && img.naturalWidth > 0) {
            reveal();
        } else {
            img.addEventListener('load', reveal, { once: true });
            img.addEventListener('error', reveal, { once: true });
            setTimeout(reveal, 1800);
        }
    });
});

if (typeof Lenis !== 'undefined') {
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        direction: 'vertical',
        gestureDirection: 'vertical',
        smooth: true,
        mouseMultiplier: 1,
        smoothTouch: false,
        touchMultiplier: 2,
        infinite: false,
    });

    window.lenis = lenis;

    if (typeof AOS !== 'undefined') {
        lenis.on('scroll', () => {
            AOS.refresh();
        });
    }

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);
}

const mainHeader = document.getElementById('main-header');
const mainNav = document.getElementById('main-nav');

function updateHeaderOnScroll() {
    if (!mainHeader) {
        return;
    }

    mainHeader.classList.toggle('is-scrolled', window.scrollY > 8);
}

window.addEventListener('scroll', updateHeaderOnScroll, { passive: true });
updateHeaderOnScroll();

const backToTopBtn = document.getElementById('back-to-top');
if (backToTopBtn) {
    backToTopBtn.addEventListener('click', function () {
        if (window.lenis) {
            window.lenis.scrollTo(0);
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
}

const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const navMenu = document.getElementById('nav-menu');
const langBtn = document.getElementById('lang-btn');
const langMenu = document.getElementById('lang-menu');
const langLabel = document.getElementById('lang-label');
const desktopNavQuery = window.matchMedia('(min-width: 1200px)');

function setPageScrollLocked(locked) {
    document.body.classList.toggle('overflow-hidden', locked);

    if (!window.lenis) {
        return;
    }

    if (locked) {
        window.lenis.stop();
    } else {
        window.lenis.start();
    }
}

function closeMobileMenu() {
    if (!navMenu) {
        return;
    }

    navMenu.classList.remove('is-open');

    if (mainHeader) {
        mainHeader.classList.remove('is-menu-open');
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.classList.remove('is-open');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.setAttribute('aria-label', '開啟選單');
    }

    setPageScrollLocked(false);
}

function openMobileMenu() {
    if (!navMenu || desktopNavQuery.matches) {
        return;
    }

    setLangOpen(false);
    navMenu.classList.add('is-open');

    if (mainHeader) {
        mainHeader.classList.add('is-menu-open');
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.classList.add('is-open');
        mobileMenuBtn.setAttribute('aria-expanded', 'true');
        mobileMenuBtn.setAttribute('aria-label', '關閉選單');
    }

    setPageScrollLocked(true);
}

function toggleMobileMenu() {
    const isOpen = navMenu && navMenu.classList.contains('is-open');
    if (isOpen) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
}

function setLangOpen(open) {
    if (!langBtn || !langMenu) {
        return;
    }

    langBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    langMenu.classList.toggle('is-open', open);
}

if (mobileMenuBtn && navMenu) {
    mobileMenuBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        toggleMobileMenu();
    });

    navMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', function () {
            if (!desktopNavQuery.matches) {
                closeMobileMenu();
            }
        });
    });
}

if (langBtn && langMenu) {
    langBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        const isOpen = langBtn.getAttribute('aria-expanded') === 'true';
        if (!isOpen) {
            closeMobileMenu();
        }
        setLangOpen(!isOpen);
    });

    langMenu.querySelectorAll('.lang-option').forEach((option) => {
        option.addEventListener('click', function () {
            langMenu.querySelectorAll('.lang-option').forEach((item) => {
                item.classList.remove('is-active');
                item.setAttribute('aria-selected', 'false');
            });
            option.classList.add('is-active');
            option.setAttribute('aria-selected', 'true');

            if (langLabel) {
                langLabel.textContent = option.dataset.lang;
            }

            setLangOpen(false);
        });
    });
}

document.addEventListener('click', function (event) {
    if (!event.target.closest('#lang-switch')) {
        setLangOpen(false);
    }

    if (!desktopNavQuery.matches && navMenu && navMenu.classList.contains('is-open')) {
        const insideMenu = event.target.closest('#nav-menu') || event.target.closest('#mobile-menu-btn');
        if (!insideMenu) {
            closeMobileMenu();
        }
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') {
        return;
    }

    setLangOpen(false);
    closeMobileMenu();
});

let resizeTimer;
window.addEventListener('resize', () => {
    if (mainHeader) {
        mainHeader.classList.add('resize-animation-stopper');
    }

    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (mainHeader) {
            mainHeader.classList.remove('resize-animation-stopper');
        }
    }, 400);

    if (desktopNavQuery.matches) {
        closeMobileMenu();
    }
});

const heroSwiperEl = document.getElementById('hero-swiper');
if (heroSwiperEl && typeof Swiper !== 'undefined') {
    const heroCurrent = heroSwiperEl.querySelector('[data-hero-current]');
    const heroTotal = heroSwiperEl.querySelector('[data-hero-total]');
    const heroProgress = heroSwiperEl.querySelector('[data-hero-progress]');
    const heroSlideCount = Number(heroSwiperEl.dataset.slides) || heroSwiperEl.querySelectorAll('.swiper-slide').length;

    function updateHeroPager(swiper) {
        const current = swiper.realIndex + 1;
        const total = heroSlideCount;

        if (heroCurrent) {
            heroCurrent.textContent = String(current);
        }
        if (heroTotal) {
            heroTotal.textContent = String(total);
        }
        if (heroProgress) {
            heroProgress.style.width = `${(current / total) * 100}%`;
        }
    }

    function playHeroCopyAnimation(swiper) {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        heroSwiperEl.querySelectorAll('.hero-copy').forEach((copy) => {
            copy.classList.remove('is-animate');
        });

        if (reduceMotion) {
            return;
        }

        const activeSlide = swiper.slides[swiper.activeIndex];
        const activeCopy = activeSlide?.querySelector('.hero-copy');
        if (!activeCopy) {
            return;
        }

        void activeCopy.offsetWidth;
        activeCopy.classList.add('is-animate');
    }

    const heroSwiper = new Swiper(heroSwiperEl, {
        loop: true,
        speed: 1000,
        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        navigation: {
            prevEl: heroSwiperEl.querySelector('[data-hero-prev]'),
            nextEl: heroSwiperEl.querySelector('[data-hero-next]'),
        },
        on: {
            init(swiper) {
                updateHeroPager(swiper);
                playHeroCopyAnimation(swiper);
            },
            slideChange(swiper) {
                updateHeroPager(swiper);
            },
            slideChangeTransitionStart(swiper) {
                playHeroCopyAnimation(swiper);
            },
        },
    });

    window.heroSwiper = heroSwiper;
}

/* 首頁應用區域：單卡軌道 + overflow 鄰卡 + scale 中間（對齊 oneretinaclinic） */
const appsSwiperEl = document.getElementById('apps-swiper');
if (appsSwiperEl && typeof Swiper !== 'undefined') {
    const updateAppsSideClasses = (swiper) => {
        swiper.slides.forEach((slide, index) => {
            slide.classList.toggle('apps-slide-left', index < swiper.activeIndex);
            slide.classList.toggle('apps-slide-right', index > swiper.activeIndex);
        });
    };

    const appsSection = appsSwiperEl.closest('.apps-section');
    const appsPrevBtn = appsSection?.querySelector('[data-apps-prev]');
    const appsNextBtn = appsSection?.querySelector('[data-apps-next]');
    const appsPaginationEl = appsSection?.querySelector('[data-apps-pagination]');

    const appsSwiper = new Swiper(appsSwiperEl, {
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        /* 只要左右各露出一點；过大 + loopAddBlankSlides 會補出空白頁 */
        loopAdditionalSlides: 3,
        loopAddBlankSlides: false,
        /* 與 CSS --apps-duration (0.75s) 對齊，縮放／滑動同拍 */
        speed: 750,
        grabCursor: true,
        threshold: 5,
        resistanceRatio: 0.85,
        navigation: {
            prevEl: appsPrevBtn,
            nextEl: appsNextBtn,
        },
        pagination: {
            el: appsPaginationEl,
            clickable: true,
            bulletClass: 'apps-dot',
            bulletActiveClass: 'is-active',
        },
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        on: {
            init(swiper) {
                updateAppsSideClasses(swiper);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            },
            slideChange(swiper) {
                updateAppsSideClasses(swiper);
            },
            setTranslate(swiper) {
                updateAppsSideClasses(swiper);
            },
            /*
             * 注意：不要再用 is-loop-fixing 關掉 slide transition。
             * beforeLoopFix 若沒對應清掉，class 會卡住，放大變成 transition:none 瞬間跳。
             */
            loopFix(swiper) {
                updateAppsSideClasses(swiper);
            },
        },
    });

    window.appsSwiper = appsSwiper;
}

/* 人力招募：職缺展開＋卡內應徵表單＋送出確認燈箱 */
const jobList = document.getElementById('job-list');
const applyFormPark = document.getElementById('apply-form-park');
const applyForm = document.getElementById('apply-form');
const applyJobInput = document.getElementById('apply-job');
const applyJobDisplay = document.getElementById('apply-job-display');
const applySuccessModal = document.getElementById('apply-success-modal');
const JOB_PANEL_MS = 480;
let applySuccessLastFocus = null;
let applySuccessScrollY = null;
let jobAnimLock = false;

function updateApplyButtonState(card, isApplyOpen) {
    const btn = card.querySelector('.job-apply-btn');
    const label = card.querySelector('.job-apply-btn-label');

    if (btn) {
        btn.setAttribute('aria-expanded', isApplyOpen ? 'true' : 'false');
    }

    if (label) {
        label.textContent = isApplyOpen ? '收合表單' : '應徵此職缺';
    }
}

function waitForPanelTransition(panel, fallbackMs = JOB_PANEL_MS) {
    return new Promise((resolve) => {
        if (!panel) {
            resolve();
            return;
        }

        let settled = false;
        const finish = () => {
            if (settled) {
                return;
            }
            settled = true;
            panel.removeEventListener('transitionend', onEnd);
            resolve();
        };

        const onEnd = (event) => {
            if (event.target !== panel || event.propertyName !== 'grid-template-rows') {
                return;
            }
            finish();
        };

        panel.addEventListener('transitionend', onEnd);
        window.setTimeout(finish, fallbackMs);
    });
}

function parkApplyForm({ animate = true } = {}) {
    return new Promise((resolve) => {
        if (!jobList || !applyForm) {
            resolve();
            return;
        }

        const openCards = Array.from(jobList.querySelectorAll('.job-card.is-apply-open'));
        if (!openCards.length) {
            if (applyFormPark) {
                applyFormPark.appendChild(applyForm);
            }
            resolve();
            return;
        }

        const panel = openCards[0].querySelector('.job-apply-panel');

        openCards.forEach((card) => {
            card.classList.remove('is-apply-open');
            updateApplyButtonState(card, false);
        });

        const finish = () => {
            if (applyFormPark) {
                applyFormPark.appendChild(applyForm);
            }
            resolve();
        };

        if (!animate) {
            finish();
            return;
        }

        waitForPanelTransition(panel).then(finish);
    });
}

function restoreApplyScrollPosition() {
    if (applySuccessScrollY === null) {
        return;
    }

    const y = applySuccessScrollY;
    applySuccessScrollY = null;

    if (window.lenis) {
        window.lenis.scrollTo(y, { immediate: true });
    } else {
        window.scrollTo(0, y);
    }
}

function closeOtherJobCards(exceptCard) {
    if (!jobList) {
        return;
    }

    jobList.querySelectorAll('.job-card.is-open').forEach((openCard) => {
        if (openCard === exceptCard) {
            return;
        }
        openCard.classList.remove('is-open', 'is-apply-open');
        const openToggle = openCard.querySelector('.job-card-toggle');
        if (openToggle) {
            openToggle.setAttribute('aria-expanded', 'false');
        }
        updateApplyButtonState(openCard, false);
    });
}

async function openApplyFormInCard(card, title) {
    if (!card || !applyForm || jobAnimLock) {
        return;
    }

    const slot = card.querySelector('.job-apply-slot');
    const panel = card.querySelector('.job-apply-panel');
    if (!slot || !panel) {
        return;
    }

    jobAnimLock = true;

    try {
        await parkApplyForm();
        closeOtherJobCards(card);

        if (!card.classList.contains('is-open')) {
            card.classList.add('is-open');
            const toggle = card.querySelector('.job-card-toggle');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'true');
            }
            await waitForPanelTransition(card.querySelector('.job-card-detail'));
        }

        if (applyJobInput) {
            applyJobInput.value = title || '';
        }

        if (applyJobDisplay) {
            applyJobDisplay.textContent = title || '';
        }

        slot.appendChild(applyForm);

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // 先插入內容再展開，下一幀才加 class 才播得出動畫
        void panel.offsetHeight;
        await new Promise((resolve) => window.requestAnimationFrame(resolve));
        card.classList.add('is-apply-open');
        updateApplyButtonState(card, true);

        await waitForPanelTransition(panel);

        const nameInput = applyForm.querySelector('#apply-name');
        if (nameInput) {
            nameInput.focus({ preventScroll: true });
        }

        if (window.lenis) {
            window.lenis.scrollTo(applyForm, { offset: -100 });
        } else {
            applyForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    } finally {
        jobAnimLock = false;
    }
}

function openApplySuccessModal() {
    if (!applySuccessModal) {
        return;
    }

    applySuccessLastFocus = document.activeElement;
    applySuccessModal.hidden = false;
    setPageScrollLocked(true);

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const closeBtn = applySuccessModal.querySelector('[data-success-close]');
    if (closeBtn) {
        closeBtn.focus();
    }
}

function closeApplySuccessModal() {
    if (!applySuccessModal || applySuccessModal.hidden) {
        return;
    }

    applySuccessModal.hidden = true;
    setPageScrollLocked(false);
    restoreApplyScrollPosition();

    if (applySuccessLastFocus && typeof applySuccessLastFocus.focus === 'function') {
        applySuccessLastFocus.focus();
    }
}

if (jobList) {
    jobList.querySelectorAll('.job-card').forEach((card) => {
        const toggle = card.querySelector('.job-card-toggle');

        if (!toggle) {
            return;
        }

        toggle.addEventListener('click', async () => {
            if (jobAnimLock) {
                return;
            }

            const willOpen = !card.classList.contains('is-open');
            jobAnimLock = true;

            try {
                if (willOpen) {
                    await parkApplyForm();
                    closeOtherJobCards(card);
                    card.classList.add('is-open');
                    toggle.setAttribute('aria-expanded', 'true');
                    await waitForPanelTransition(card.querySelector('.job-card-detail'));
                } else {
                    await parkApplyForm();
                    card.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    await waitForPanelTransition(card.querySelector('.job-card-detail'));
                }
            } finally {
                jobAnimLock = false;
            }
        });
    });

    jobList.querySelectorAll('.job-apply-btn').forEach((btn) => {
        btn.addEventListener('click', async () => {
            if (jobAnimLock) {
                return;
            }

            const card = btn.closest('.job-card');
            if (!card) {
                return;
            }

            if (card.classList.contains('is-apply-open')) {
                jobAnimLock = true;
                try {
                    await parkApplyForm();
                } finally {
                    jobAnimLock = false;
                }
                return;
            }

            await openApplyFormInCard(card, btn.dataset.jobTitle || card.dataset.jobTitle || '');
        });
    });
}

if (applyForm) {
    applyForm.addEventListener('click', async (event) => {
        if (!event.target.closest('[data-apply-cancel]') || jobAnimLock) {
            return;
        }

        jobAnimLock = true;
        try {
            await parkApplyForm();
        } finally {
            jobAnimLock = false;
        }
    });

    applyForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!applyForm.checkValidity()) {
            applyForm.reportValidity();
            return;
        }

        // 先記位置、開確認燈箱鎖捲動，再收合表單，避免高度變短造成頁面跳动
        applySuccessScrollY = window.scrollY || window.pageYOffset || 0;
        openApplySuccessModal();

        applyForm.reset();
        if (applyJobInput) {
            applyJobInput.value = '';
        }
        if (applyJobDisplay) {
            applyJobDisplay.textContent = '';
        }

        jobAnimLock = true;
        try {
            await parkApplyForm({ animate: false });
        } finally {
            jobAnimLock = false;
        }
    });
}

if (applySuccessModal) {
    applySuccessModal.querySelectorAll('[data-success-close]').forEach((el) => {
        el.addEventListener('click', () => {
            closeApplySuccessModal();
        });
    });
}

/* 聯絡我們：表單送出＋成功確認燈箱 */
const contactForm = document.getElementById('contact-form');
const contactSuccessModal = document.getElementById('contact-success-modal');
let contactSuccessLastFocus = null;

function openContactSuccessModal() {
    if (!contactSuccessModal) {
        return;
    }

    contactSuccessLastFocus = document.activeElement;
    contactSuccessModal.hidden = false;
    setPageScrollLocked(true);

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const closeBtn = contactSuccessModal.querySelector('[data-contact-success-close]');
    if (closeBtn) {
        closeBtn.focus();
    }
}

function closeContactSuccessModal() {
    if (!contactSuccessModal || contactSuccessModal.hidden) {
        return;
    }

    contactSuccessModal.hidden = true;
    setPageScrollLocked(false);

    if (contactSuccessLastFocus && typeof contactSuccessLastFocus.focus === 'function') {
        contactSuccessLastFocus.focus();
    }
}

if (contactForm) {
    contactForm.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!contactForm.checkValidity()) {
            contactForm.reportValidity();
            return;
        }

        openContactSuccessModal();
        contactForm.reset();
    });
}

if (contactSuccessModal) {
    contactSuccessModal.querySelectorAll('[data-contact-success-close]').forEach((el) => {
        el.addEventListener('click', () => {
            closeContactSuccessModal();
        });
    });
}

document.addEventListener('keydown', async function (event) {
    if (event.key !== 'Escape') {
        return;
    }

    if (applySuccessModal && !applySuccessModal.hidden) {
        closeApplySuccessModal();
        return;
    }

    if (contactSuccessModal && !contactSuccessModal.hidden) {
        closeContactSuccessModal();
        return;
    }

    if (jobAnimLock) {
        return;
    }

    if (jobList && jobList.querySelector('.job-card.is-apply-open')) {
        jobAnimLock = true;
        try {
            await parkApplyForm();
        } finally {
            jobAnimLock = false;
        }
    }
});

/* 首頁產品介紹切換 */
const homeProductsSection = document.getElementById('home-products');
const homeProductsDataEl = document.getElementById('home-products-data');

if (homeProductsSection && homeProductsDataEl) {
    let homeProducts = [];

    try {
        homeProducts = JSON.parse(homeProductsDataEl.textContent || '[]');
    } catch (error) {
        homeProducts = [];
    }

    if (homeProducts.length) {
        let productIndex = 0;
        let productBusy = false;

        const titleEl = homeProductsSection.querySelector('[data-product-title]');
        const subtitleEl = homeProductsSection.querySelector('[data-product-subtitle]');
        const descEl = homeProductsSection.querySelector('[data-product-desc]');
        const imageEl = homeProductsSection.querySelector('[data-product-image]');
        const currentEl = homeProductsSection.querySelector('[data-product-current]');
        const prevBtn = homeProductsSection.querySelector('[data-product-prev]');
        const nextBtn = homeProductsSection.querySelector('[data-product-next]');
        const thumbsSwiperEl = homeProductsSection.querySelector('[data-product-thumbs-swiper]');
        const thumbButtons = Array.from(homeProductsSection.querySelectorAll('[data-product-thumb]'));

        let thumbsSwiper = null;
        if (thumbsSwiperEl && typeof Swiper !== 'undefined') {
            thumbsSwiper = new Swiper(thumbsSwiperEl, {
                slidesPerView: 2.4,
                spaceBetween: 12,
                slidesPerGroup: 1,
                grabCursor: true,
                speed: 420,
                watchOverflow: true,
                resistanceRatio: 0.75,
                breakpoints: {
                    800: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                    1200: {
                        slidesPerView: 6,
                        spaceBetween: 24,
                    },
                },
            });
        }

        function padIndex(value) {
            return String(value).padStart(2, '0');
        }

        function syncThumbsToProduct(index) {
            if (!thumbsSwiper) {
                return;
            }
            thumbsSwiper.slideTo(index);
        }

        function setProduct(index) {
            if (productBusy || !homeProducts.length) {
                return;
            }

            const nextIndex = (index + homeProducts.length) % homeProducts.length;
            if (nextIndex === productIndex && titleEl?.textContent === homeProducts[nextIndex].title) {
                syncThumbsToProduct(nextIndex);
                return;
            }

            productBusy = true;
            const product = homeProducts[nextIndex];
            const copyEls = [titleEl, subtitleEl, descEl, imageEl].filter(Boolean);

            copyEls.forEach((el) => el.classList.add('product-copy-leave'));

            window.setTimeout(() => {
                if (titleEl) {
                    titleEl.textContent = product.title;
                }
                if (subtitleEl) {
                    subtitleEl.textContent = product.subtitle;
                }
                if (descEl) {
                    descEl.textContent = product.description;
                }
                if (imageEl) {
                    imageEl.src = product.image;
                    imageEl.alt = product.title;
                }
                if (currentEl) {
                    currentEl.textContent = padIndex(nextIndex + 1);
                }

                thumbButtons.forEach((btn) => {
                    const btnIndex = Number(btn.dataset.productThumb);
                    const active = btnIndex === nextIndex;
                    btn.classList.toggle('is-active', active);
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                productIndex = nextIndex;
                syncThumbsToProduct(nextIndex);

                window.requestAnimationFrame(() => {
                    copyEls.forEach((el) => el.classList.remove('product-copy-leave'));
                    productBusy = false;
                });
            }, 180);
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                setProduct(productIndex - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                setProduct(productIndex + 1);
            });
        }

        thumbButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const index = Number(btn.dataset.productThumb);
                if (!Number.isNaN(index)) {
                    setProduct(index);
                }
            });
        });

        /* 主視覺區：左右拖曳一次切一筆產品 */
        const DRAG_THRESHOLD = 48;
        const dragSurfaces = Array.from(homeProductsSection.querySelectorAll('[data-product-drag]'));

        dragSurfaces.forEach((surface) => {
            let pointerId = null;
            let startX = 0;
            let startY = 0;
            let dragging = false;
            let didDrag = false;

            surface.addEventListener('pointerdown', (event) => {
                if (event.button !== 0) {
                    return;
                }
                if (event.target.closest('.product-nav-btn')) {
                    return;
                }

                pointerId = event.pointerId;
                startX = event.clientX;
                startY = event.clientY;
                dragging = true;
                didDrag = false;
                surface.classList.add('is-dragging');

                try {
                    surface.setPointerCapture(event.pointerId);
                } catch (error) {
                    /* ignore */
                }
            });

            surface.addEventListener('pointermove', (event) => {
                if (!dragging || event.pointerId !== pointerId) {
                    return;
                }

                const dx = event.clientX - startX;
                const dy = event.clientY - startY;

                if (!didDrag && Math.abs(dx) > 12 && Math.abs(dx) > Math.abs(dy)) {
                    didDrag = true;
                }
            });

            const endDrag = (event) => {
                if (!dragging || (event && event.pointerId !== pointerId)) {
                    return;
                }

                const dx = event.clientX - startX;
                dragging = false;
                pointerId = null;
                surface.classList.remove('is-dragging');

                if (Math.abs(dx) >= DRAG_THRESHOLD) {
                    if (dx < 0) {
                        setProduct(productIndex + 1);
                    } else {
                        setProduct(productIndex - 1);
                    }
                }
            };

            surface.addEventListener('pointerup', endDrag);
            surface.addEventListener('pointercancel', endDrag);
        });
    }
}

/* 產品介紹頁：L1 Tab + L2 側欄／手機下拉選單 */
const productsCatalog = document.querySelector('[data-products-catalog]');
if (productsCatalog) {
    const l1Buttons = Array.from(productsCatalog.querySelectorAll('[data-products-l1]'));
    const l2Nav = productsCatalog.querySelector('[data-products-l2-nav]');
    const l2Toggle = productsCatalog.querySelector('[data-products-l2-toggle]');
    const l2Menu = productsCatalog.querySelector('[data-products-l2-menu]');
    const l2Label = productsCatalog.querySelector('[data-products-l2-label]');
    const l2Panels = Array.from(productsCatalog.querySelectorAll('[data-products-l2-panel]'));
    const l2Buttons = Array.from(productsCatalog.querySelectorAll('[data-products-l2]'));
    const l3Panels = Array.from(productsCatalog.querySelectorAll('[data-products-l3-panel]'));

    function setL2MenuOpen(open) {
        if (!l2Toggle || !l2Menu) return;
        l2Toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        l2Menu.classList.toggle('is-open', open);
    }

    function updateL2Label(l2Id) {
        if (!l2Label) return;
        const activeBtn = l2Buttons.find((btn) => btn.dataset.productsL2 === l2Id && !btn.closest('[hidden]'));
        const fallback = l2Buttons.find((btn) => btn.dataset.productsL2 === l2Id);
        const source = activeBtn || fallback;
        if (source) {
            l2Label.textContent = source.textContent.trim();
        }
    }

    function setL2Active(l2Id) {
        l2Buttons.forEach((btn) => {
            const active = btn.dataset.productsL2 === l2Id;
            btn.classList.toggle('is-active', active);
        });

        l3Panels.forEach((panel) => {
            const active = panel.dataset.productsL3Panel === l2Id;
            panel.classList.toggle('is-active', active);
            panel.hidden = !active;
        });

        updateL2Label(l2Id);
        setL2MenuOpen(false);
    }

    function setL1Active(l1Id, preferredL2Id) {
        l1Buttons.forEach((btn) => {
            const active = btn.dataset.productsL1 === l1Id;
            btn.classList.toggle('is-active', active);
            btn.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        l2Panels.forEach((panel) => {
            const active = panel.dataset.productsL2Panel === l1Id;
            panel.classList.toggle('is-active', active);
            panel.hidden = !active;
        });

        const panelL2Buttons = Array.from(
            productsCatalog.querySelectorAll(`[data-products-l2-panel="${l1Id}"] [data-products-l2]`)
        );
        const preferred =
            preferredL2Id &&
            panelL2Buttons.find((btn) => btn.dataset.productsL2 === preferredL2Id);
        const targetL2 = preferred || panelL2Buttons[0];
        if (targetL2) {
            setL2Active(targetL2.dataset.productsL2);
        }
    }

    function resolveCategoryFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const urlL1 = params.get('l1') || '';
        const urlL2 = params.get('l2') || '';
        const defaultL1 = productsCatalog.dataset.defaultL1 || '';
        const defaultL2 = productsCatalog.dataset.defaultL2 || '';

        const knownL1 = (id) => l1Buttons.some((btn) => btn.dataset.productsL1 === id);
        const knownL2 = (id) => l2Buttons.some((btn) => btn.dataset.productsL2 === id);

        let l1Id = knownL1(urlL1) ? urlL1 : '';
        let l2Id = knownL2(urlL2) ? urlL2 : '';

        if (!l1Id && l2Id) {
            const match = l2Buttons.find((btn) => btn.dataset.productsL2 === l2Id);
            l1Id = match?.dataset.productsL1Ref || '';
        }

        if (!l1Id && knownL1(defaultL1)) {
            l1Id = defaultL1;
        }
        if (!l2Id && knownL2(defaultL2)) {
            l2Id = defaultL2;
        }

        if (l1Id) {
            setL1Active(l1Id, l2Id || undefined);
        }
    }

    resolveCategoryFromUrl();

    l1Buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            setL1Active(btn.dataset.productsL1);
        });
    });

    l2Buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const l1Id = btn.dataset.productsL1Ref;
            if (l1Id) {
                l1Buttons.forEach((l1Btn) => {
                    const active = l1Btn.dataset.productsL1 === l1Id;
                    l1Btn.classList.toggle('is-active', active);
                    l1Btn.setAttribute('aria-selected', active ? 'true' : 'false');
                });
                l2Panels.forEach((panel) => {
                    const active = panel.dataset.productsL2Panel === l1Id;
                    panel.classList.toggle('is-active', active);
                    panel.hidden = !active;
                });
            }
            setL2Active(btn.dataset.productsL2);
        });
    });

    if (l2Toggle && l2Menu) {
        l2Toggle.addEventListener('click', () => {
            const open = l2Toggle.getAttribute('aria-expanded') !== 'true';
            setL2MenuOpen(open);
        });

        document.addEventListener('click', (event) => {
            if (!l2Nav || l2Nav.contains(event.target)) return;
            setL2MenuOpen(false);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setL2MenuOpen(false);
            }
        });
    }
}
