---
title: 人力招募
description: 人力招募
---
@extends('_layouts.main')

@section('body')
    @php
        $jobBanks = [
            ['name' => '104 人力銀行', 'url' => 'https://www.104.com.tw/', 'short' => '104'],
            ['name' => '1111 人力銀行', 'url' => 'https://www.1111.com.tw/', 'short' => '1111'],
        ];
        $jobs = $page->jobs ?? [];
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'careers',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'CAREERS',
        'crumbs' => [['name' => '人力招募']],
    ])

    {{-- ========== 公司福利＋人力銀行 ========== --}}
    <section class="bg-white" aria-label="公司福利">
        <div class="layout-grid flex flex-col gap-12 py-16 md:py-20 lg:py-28">
            {{-- 區塊標題 --}}
            <div class="flex flex-col items-start gap-5" data-aos="fade-up">
                <h2 class="text-ch3 text-gray5 lg:text-ch2">加入佢朋</h2>
                <div class="title-rule" aria-hidden="true"></div>
                <p class="max-w-3xl text-cb2 text-gray4">
                    我們專注 PCB 與 IC 產業，提供設備、原物料、耗材與技術服務。歡迎認同誠信、品質與服務價值的夥伴加入，一起打造穩定且具效率的整合服務。
                </p>
            </div>

            {{-- 福利項目 --}}
            <div class="grid w-full grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-8">
                <div class="philosophy-card flex flex-col gap-1 border-l-[3px] border-main2 pl-6 py-5" data-aos="fade-up">
                    <h3 class="text-ch5 text-gray5">完善保險</h3>
                    <p class="text-cb2 text-gray3">依法投保勞健保，並提供團保等相關保障。</p>
                </div>
                <div class="philosophy-card flex flex-col gap-1 border-l-[3px] border-main2 pl-6 py-5" data-aos="fade-up" data-aos-delay="50">
                    <h3 class="text-ch5 text-gray5">年節獎金</h3>
                    <p class="text-cb2 text-gray3">依營運狀況發放年終與節慶獎金。</p>
                </div>
                <div class="philosophy-card flex flex-col gap-1 border-l-[3px] border-main2 pl-6 py-5" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-ch5 text-gray5">休假制度</h3>
                    <p class="text-cb2 text-gray3">依勞基法給予特休，並配合公司行事曆安排休假。</p>
                </div>
                <div class="philosophy-card flex flex-col gap-1 border-l-[3px] border-main2 pl-6 py-5" data-aos="fade-up" data-aos-delay="150">
                    <h3 class="text-ch5 text-gray5">教育訓練</h3>
                    <p class="text-cb2 text-gray3">提供產品與專業技能訓練，支持持續學習成長。</p>
                </div>
            </div>

            {{-- 人力銀行連結 --}}
            <div class="flex w-full flex-col items-start gap-5 border-t border-gray1 pt-10 md:pt-12" data-aos="fade-up">
                <div class="flex flex-col gap-2">
                    <h3 class="text-ch4 text-gray5">人力銀行職缺</h3>
                    <p class="text-cb2 text-gray4">亦可至以下人力銀行查看最新職缺資訊。</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @foreach ($jobBanks as $bank)
                        <a
                            href="{{ $bank['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-solid"
                        >
                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                            <span>{{ $bank['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ========== 職缺列表 ========== --}}
    <section class="history-section relative overflow-hidden" aria-label="職缺列表" id="jobs">
        {{-- 裝飾大字 CAREERS：裁切浮水印，與 HISTORY／LOCATION／PRODUCT 同款 --}}
        <div class="section-watermark" aria-hidden="true">
            <div class="layout-grid">
                <span class="section-watermark-text">CAREERS</span>
            </div>
        </div>

        <div class="layout-grid relative z-10 flex flex-col gap-10 py-16 md:gap-14 md:py-20 lg:gap-16 lg:pt-24 lg:pb-28">
            {{-- 區塊標題 --}}
            <div class="flex flex-col items-center gap-5" data-aos="fade-up">
                <h2 class="text-ch3 text-gray5 lg:text-ch2">目前職缺</h2>
                <div class="title-rule" aria-hidden="true"></div>
                <p class="text-cb2 text-gray4">點選職缺查看內容，若要應徵請點「應徵此職缺」直接填寫。</p>
            </div>

            {{-- 職缺卡面 --}}
            <div class="flex w-full flex-col gap-4" id="job-list">
                @foreach ($jobs as $job)
                    <article
                        class="job-card bg-white"
                        data-job-id="{{ $job['id'] }}"
                        data-job-title="{{ $job['title'] }}"
                        data-aos="fade-up"
                        data-aos-delay="{{ min($loop->index * 80, 240) }}"
                    >
                        {{-- 卡面摘要（點擊展開） --}}
                        <button
                            type="button"
                            class="job-card-toggle flex w-full items-start justify-between gap-4 px-6 py-5 text-left md:items-center md:px-8 md:py-6"
                            aria-expanded="false"
                            aria-controls="job-detail-{{ $job['id'] }}"
                        >
                            <div class="flex min-w-0 flex-1 flex-col gap-2 md:flex-row md:items-center md:gap-8">
                                <h3 class="text-ch5 md:text-ch4 text-gray5 md:w-44 md:shrink-0">{{ $job['title'] }}</h3>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-cb3 text-gray4">
                                    <span class="inline-flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="h-3.5 w-3.5 text-main2" aria-hidden="true"></i>
                                        {{ $job['location'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <i data-lucide="briefcase" class="h-3.5 w-3.5 text-main2" aria-hidden="true"></i>
                                        {{ $job['type'] }}
                                    </span>
                                </div>
                                <p class="text-cb2 text-gray4 md:flex-1">{{ $job['summary'] }}</p>
                            </div>
                            <i data-lucide="chevron-down" class="job-card-chevron mt-1 h-5 w-5 shrink-0 text-main1 md:mt-0" aria-hidden="true"></i>
                        </button>

                        {{-- 詳細：工作內容／條件／卡內應徵表單 --}}
                        <div id="job-detail-{{ $job['id'] }}" class="job-card-detail">
                            <div class="job-card-detail-clip">
                                <div class="job-card-detail-inner border-t border-gray1 px-6 pb-6 pt-2 md:px-8 md:pb-8">
                                    <div class="grid gap-8 pt-4 md:grid-cols-2">
                                        <div class="flex flex-col gap-3">
                                            <h4 class="text-cb1 font-bold text-main1">工作內容</h4>
                                            <p class="whitespace-pre-line text-cb2 text-gray4">{{ $job['duties'] ?? '' }}</p>
                                        </div>
                                        <div class="flex flex-col gap-3">
                                            <h4 class="text-cb1 font-bold text-main1">條件要求</h4>
                                            <p class="whitespace-pre-line text-cb2 text-gray4">{{ $job['requirements'] ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button type="button" class="btn-solid job-apply-btn" data-job-title="{{ $job['title'] }}" aria-expanded="false">
                                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                                            <span class="job-apply-btn-label">應徵此職缺</span>
                                        </button>
                                    </div>

                                    {{-- 表單插入點（點應徵後展開） --}}
                                    <div class="job-apply-panel">
                                        <div class="job-apply-panel-clip">
                                            <div class="job-apply-slot"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- 應徵表單（暫存，由 JS 移入職缺卡） --}}
            <div id="apply-form-park" hidden>
                <form id="apply-form" class="job-apply-form" novalidate>
                    <div class="mb-4 flex flex-col gap-1">
                        <h4 class="text-ch5 text-main1">填寫應徵資料</h4>
                        <p class="text-cb2 text-gray4">
                            應徵職缺：<span id="apply-job-display" class="text-cb2 text-gray5"></span>
                        </p>
                        <input type="hidden" id="apply-job" name="job" required>
                    </div>

                    {{-- 左半：姓名＋性別並排｜右半：年齡 --}}
                    <div class="grid items-end gap-4 md:grid-cols-2">
                        <div class="grid grid-cols-[minmax(0,1fr)_auto] items-end gap-4">
                            <div class="form-field !w-auto min-w-0">
                                <label for="apply-name" class="form-label">姓名 <span class="text-main2">*</span></label>
                                <input id="apply-name" name="name" type="text" class="form-control" autocomplete="name" required>
                            </div>
                            <div class="flex h-11 items-center gap-4" role="group" aria-label="性別">
                                <label class="form-radio">
                                    <input type="radio" name="gender" value="男" required>
                                    <span>男</span>
                                </label>
                                <label class="form-radio">
                                    <input type="radio" name="gender" value="女">
                                    <span>女</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="apply-age" class="form-label">年齡 <span class="text-main2">*</span></label>
                            <input id="apply-age" name="age" type="number" min="16" max="80" class="form-control" required>
                        </div>
                    </div>

                    {{-- 手機｜信箱 --}}
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="form-field">
                            <label for="apply-phone" class="form-label">手機 <span class="text-main2">*</span></label>
                            <input id="apply-phone" name="phone" type="tel" class="form-control" autocomplete="tel" inputmode="tel" required>
                        </div>
                        <div class="form-field">
                            <label for="apply-email" class="form-label">信箱 <span class="text-main2">*</span></label>
                            <input id="apply-email" name="email" type="email" class="form-control" autocomplete="email" required>
                        </div>
                    </div>

                    {{-- 工作經歷 --}}
                    <div class="form-field">
                        <label for="apply-experience" class="form-label">工作經歷 <span class="text-main2">*</span></label>
                        <textarea id="apply-experience" name="experience" rows="3" class="form-control" required placeholder="請簡述相關工作經歷"></textarea>
                    </div>

                    {{-- 留言資訊 --}}
                    <div class="form-field">
                        <label for="apply-message" class="form-label">留言資訊</label>
                        <textarea id="apply-message" name="message" rows="3" class="form-control" placeholder="其他想補充的資訊（選填）"></textarea>
                    </div>

                    <p class="text-cb3 text-gray3">
                        此網站受 Google reCAPTCHA 保護，適用
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="text-main1 underline-offset-2 hover:underline">隱私權政策</a>
                        與
                        <a href="https://policies.google.com/terms" target="_blank" rel="noopener noreferrer" class="text-main1 underline-offset-2 hover:underline">服務條款</a>。
                    </p>

                    <div class="flex flex-wrap items-center justify-end gap-3 pt-1">
                        <button type="button" class="job-apply-cancel text-cb2 text-gray4 transition-colors hover:text-main1" data-apply-cancel>
                            取消
                        </button>
                        <button type="submit" class="btn-solid">
                            <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                            <span>送出應徵</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ========== 送出成功確認燈箱 ========== --}}
    <div id="apply-success-modal" class="apply-modal" hidden>
        <div class="apply-modal-backdrop" data-success-close tabindex="-1" aria-hidden="true"></div>
        <div
            class="apply-modal-panel apply-success-panel"
            role="dialog"
            aria-modal="true"
            aria-labelledby="apply-success-title"
        >
            <button type="button" class="apply-modal-close apply-success-close" data-success-close aria-label="關閉">
                <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
            </button>
            <div class="flex flex-col items-center gap-4 px-8 py-10 text-center md:px-12 md:py-12">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-main3 text-main1" aria-hidden="true">
                    <i data-lucide="check" class="h-7 w-7"></i>
                </div>
                <div class="flex flex-col gap-2">
                    <h2 id="apply-success-title" class="text-ch4 text-gray5">應徵資料已送出</h2>
                    <p class="text-cb2 text-gray4">感謝您的應徵，我們已收到資料，將盡快與您聯繫。</p>
                </div>
                <button type="button" class="btn-solid mt-2" data-success-close>
                    <i data-lucide="arrow-right" class="btn-solid-icon" aria-hidden="true"></i>
                    <span>關閉</span>
                </button>
            </div>
        </div>
    </div>
@endsection
