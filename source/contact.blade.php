---
title: 聯絡我們
description: 聯絡我們
---
@extends('_layouts.main')

@section('body')
    @php
        $contact = $page->footer ?? [];
        $mapSrc = trim((string) ($contact['mapUrl'] ?? ''));
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'contact',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'CONTACT',
        'crumbs' => [['name' => '聯絡我們']],
    ])

    {{-- ========== 表單＋聯絡資訊 ========== --}}
    <section class="bg-white" aria-label="聯絡我們">
        <div class="layout-grid flex flex-col gap-14 py-16 md:gap-16 md:py-20 lg:flex-row lg:items-start lg:gap-20 lg:py-28">

            {{-- 表單 --}}
            <div class="flex w-full flex-col gap-10 md:gap-12 lg:w-[70%]" data-aos="fade-up">
                <div class="flex flex-col items-start gap-5">
                    <h2 class="text-ch3 text-gray5">留下訊息</h2>
                    <div class="title-rule" aria-hidden="true"></div>
                    <p class="text-cb2 text-gray4">如有產品詢問、技術支援或合作需求，歡迎填寫以下資料，我們將盡快與您聯繫。</p>
                </div>

                <form id="contact-form" class="flex w-full flex-col gap-5" novalidate>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="form-field">
                            <label for="contact-name" class="form-label">姓名 <span class="text-main2">*</span></label>
                            <input id="contact-name" name="name" type="text" class="form-control" autocomplete="name" required placeholder="請輸入姓名">
                        </div>
                        <div class="form-field">
                            <label for="contact-phone" class="form-label">手機 <span class="text-main2">*</span></label>
                            <input id="contact-phone" name="phone" type="tel" class="form-control" autocomplete="tel" inputmode="tel" required placeholder="請輸入手機號碼">
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="contact-email" class="form-label">Mail <span class="text-main2">*</span></label>
                        <input id="contact-email" name="email" type="email" class="form-control" autocomplete="email" required placeholder="請輸入電子郵件">
                    </div>

                    <div class="form-field">
                        <label for="contact-message" class="form-label">留言資訊 <span class="text-main2">*</span></label>
                        <textarea id="contact-message" name="message" rows="5" class="form-control" required placeholder="請輸入留言內容"></textarea>
                    </div>

                    <p class="text-cb3 text-gray3">
                        此網站受 Google reCAPTCHA 保護，適用
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="text-main1 underline-offset-2 hover:underline">隱私權政策</a>
                        與
                        <a href="https://policies.google.com/terms" target="_blank" rel="noopener noreferrer" class="text-main1 underline-offset-2 hover:underline">服務條款</a>。
                    </p>

                    <div class="flex justify-end pt-1">
                        <button type="submit" class="btn-solid">
                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                            <span>送出訊息</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- 聯絡資訊 --}}
            <aside class="flex w-full flex-col gap-10 md:gap-12 lg:w-[30%]" data-aos="fade-up" data-aos-delay="100">
                <div class="flex flex-col items-start gap-5">
                    <h2 class="text-ch3 text-gray5">聯絡資訊</h2>
                    <div class="title-rule" aria-hidden="true"></div>
                </div>

                <dl class="flex flex-col gap-0">
                        <div class="contact-meta-row">
                            <dt>地址</dt>
                            <dd>{{ $contact['address'] }}</dd>
                        </div>
                        <div class="contact-meta-row">
                            <dt>電話</dt>
                            <dd><a href="tel:{{ $contact['phoneTel'] }}">{{ $contact['phone'] }}</a></dd>
                        </div>
                        <div class="contact-meta-row">
                            <dt>傳真</dt>
                            <dd>{{ $contact['fax'] }}</dd>
                        </div>
                        <div class="contact-meta-row">
                            <dt>信箱</dt>
                            <dd><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></dd>
                        </div>
                </dl>
            </aside>
        </div>
    </section>

    {{-- ========== Google Map ========== --}}
    <section class="history-section relative overflow-hidden" aria-label="Google Map">
        {{-- 裝飾大字 LOCATION：裁切浮水印，與首頁產品區塊同款 --}}
        <div class="section-watermark" aria-hidden="true">
            <div class="layout-grid">
                <span class="section-watermark-text">LOCATION</span>
            </div>
        </div>

        <div class="layout-grid relative z-10 py-16 md:py-20 lg:py-28" data-aos="fade-up">
            <div class="contact-map overflow-hidden">
                <iframe
                    title="佢朋公司位置 Google Map"
                    src="{{ $mapSrc }}"
                    class="h-full w-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>

    {{-- ========== 送出成功確認燈箱 ========== --}}
    <div id="contact-success-modal" class="apply-modal" hidden>
        <div class="apply-modal-backdrop" data-contact-success-close tabindex="-1" aria-hidden="true"></div>
        <div
            class="apply-modal-panel apply-success-panel"
            role="dialog"
            aria-modal="true"
            aria-labelledby="contact-success-title"
        >
            <button type="button" class="apply-modal-close apply-success-close" data-contact-success-close aria-label="關閉">
                <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
            </button>
            <div class="flex flex-col items-center gap-4 px-8 py-10 text-center md:px-12 md:py-12">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-main3 text-main1" aria-hidden="true">
                    <i data-lucide="check" class="h-7 w-7"></i>
                </div>
                <div class="flex flex-col gap-2">
                    <h2 id="contact-success-title" class="text-ch4 text-gray5">訊息已送出</h2>
                    <p class="text-cb2 text-gray4">感謝您的來信，我們已收到資料，將盡快與您聯繫。</p>
                </div>
                <button type="button" class="btn-solid mt-2" data-contact-success-close>
                    <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                    <span>關閉</span>
                </button>
            </div>
        </div>
    </div>
@endsection
