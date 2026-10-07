---
title: 隱私權政策
description: 隱私權政策
---
@extends('_layouts.main')

@section('body')
    @php
        $company = $page->footer['copyrightName'] ?? $page->siteName;
        $email = $page->footer['email'] ?? '';
        $phone = $page->footer['phone'] ?? '';
        $address = $page->footer['address'] ?? '';
    @endphp

    @include('_components.page-banner', [
        'bannerKey' => 'privacy',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'PRIVACY',
        'crumbs' => [['name' => '隱私權政策']],
        'showVeil' => false,
        'tone' => 'dark',
        'compact' => true,
    ])

    <section class="bg-white" aria-label="隱私權政策內容">
        <div class="layout-grid py-14 md:py-20 lg:py-24">
            <article class="legal-doc text-cb2 text-gray4" data-aos="fade-up">
                <p class="legal-lead">
                    {{ $company }}（以下稱「本公司」）重視您的隱私權。本政策說明當您使用本公司網站（以下稱「本網站」）時，我們如何蒐集、處理、利用與保護個人資料。若您不同意本政策，請停止使用本網站相關服務。
                </p>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">一、適用範圍</h2>
                    <p>本政策適用於本網站所提供之瀏覽、表單填寫、職缺應徵與相關線上服務。本網站若另有個別服務條款或說明，得與其併同適用；若有衝突，以該服務之特別約定為優先。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">二、蒐集之個人資料類別</h2>
                    <p>視您使用之功能，本公司可能蒐集下列資料：</p>
                    <ol>
                        <li>身分與聯絡資料：如姓名、電子郵件、電話號碼、公司／單位名稱等。</li>
                        <li>訊息內容：您於聯絡表單、留言或應徵相關欄位主動提供之文字資訊。</li>
                        <li>裝置與使用資料：如 IP 位址、瀏覽器類型、瀏覽頁面、造訪時間、來源網址，以及為維運與安全目的而產生之紀錄。</li>
                        <li>Cookie 與類似技術所產生之資料（詳見「Cookie」一節）。</li>
                        <li>第三方服務所提供之驗證或統計資訊，例如 Google reCAPTCHA、Google 地圖等（依該服務實際啟用情形而定）。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">三、蒐集、處理及利用之目的</h2>
                    <p>本公司基於下列目的處理個人資料：</p>
                    <ol>
                        <li>回覆詢問、提供產品／技術資訊與售後或業務聯繫。</li>
                        <li>處理人力招募、履歷審核與面試相關聯繫。</li>
                        <li>維護網站安全、防止濫用、詐欺或惡意行為（含機器人驗證）。</li>
                        <li>改善網站內容、使用體驗與服務品質（含流量統計與錯誤排查）。</li>
                        <li>履行法令義務，或配合主管機關依法之要求。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">四、利用期間、地區、對象及方式</h2>
                    <ol>
                        <li>期間：自蒐集之日起，至前述目的完成、法令所定保存期限屆滿，或您依法請求刪除／停止利用之日止（以較晚者為準，法令另有規定者從其規定）。</li>
                        <li>地區：中華民國境內，以及為達成目的所必要之境外處理地區（例如雲端主機或國際服務提供者所在地）。</li>
                        <li>對象：本公司內部相關承辦人員；以及為達成目的所必要之受託處理者（如主機託管、郵件系統、網站分析或驗證服務提供者），並要求其善盡保密與安全義務。</li>
                        <li>方式：以自動化機器或其他非自動化之方式蒐集、處理、利用，包含紙本、電子檔案與資訊系統。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">五、Cookie 與類似技術</h2>
                    <p>本網站可能使用 Cookie 或類似技術，以維持網站基本運作、記住偏好設定或進行流量分析。您可透過瀏覽器設定拒絕或刪除 Cookie；惟部分功能可能因此無法正常運作。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">六、第三方服務</h2>
                    <p>本網站可能嵌入或串接第三方服務（例如 Google reCAPTCHA、Google 地圖、字型或分析工具）。該等服務可能依其自身隱私權政策蒐集與處理資料，建議您另行參閱其政策。本公司僅在提供服務所必要之範圍內使用該等工具。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">七、資料安全</h2>
                    <p>本公司採取合理之技術與管理措施保護個人資料，避免遭竊取、竄改、毀損、滅失或洩漏。惟任何網路傳輸或儲存方式皆無法保證絕對安全，請您亦妥善保管個人裝置與帳密資訊。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">八、您的權利</h2>
                    <p>依《個人資料保護法》，就本公司所保有之您的個人資料，您得行使下列權利：</p>
                    <ol>
                        <li>查詢或請求閱覽。</li>
                        <li>請求製給複製本。</li>
                        <li>請求補充或更正。</li>
                        <li>請求停止蒐集、處理或利用。</li>
                        <li>請求刪除。</li>
                    </ol>
                    <p>行使權利時，本公司得請您提供必要之身分證明，並得依規定酌收合理費用。若有法令規定得拒絕之情形，本公司將說明理由。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">九、未成年人</h2>
                    <p>本網站主要提供企業與專業人士使用。若您未滿十八歲，請在法定代理人同意下使用本網站並提供個人資料。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">十、政策修訂</h2>
                    <p>本公司得視業務、法令或技術變更修訂本政策，並公布於本頁。修訂後自公布時起生效；若涉及重大變更，本公司得視情況於網站上另行提示。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">十一、聯絡方式</h2>
                    <p>如對本政策或個人資料相關事項有任何問題，歡迎與我們聯繫：</p>
                    <ul>
                        @if ($company !== '')
                            <li>單位：{{ $company }}</li>
                        @endif
                        @if ($address !== '')
                            <li>地址：{{ $address }}</li>
                        @endif
                        @if ($email !== '')
                            <li>E-mail：<a href="mailto:{{ $email }}">{{ $email }}</a></li>
                        @endif
                        @if ($phone !== '')
                            <li>電話：{{ $phone }}</li>
                        @endif
                    </ul>
                </section>

                <p class="mt-10 border-t border-gray1 pt-6 text-cb2 text-gray3">更新日期：{{ date('Y') }} 年 10 月</p>
            </article>
        </div>
    </section>
@endsection
