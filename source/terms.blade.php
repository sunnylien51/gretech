---
title: 服務條款
description: 服務條款
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
        'bannerKey' => 'terms',
        'eyebrow' => 'GRETECH',
        'enTitle' => 'TERMS',
        'crumbs' => [['name' => '服務條款']],
        'showVeil' => false,
        'tone' => 'dark',
        'compact' => true,
    ])

    <section class="bg-white" aria-label="服務條款內容">
        <div class="layout-grid py-14 md:py-20 lg:py-24">
            <article class="legal-doc text-cb2 text-gray4" data-aos="fade-up">
                <p class="legal-lead">
                    歡迎使用 {{ $company }}（以下稱「本公司」）網站（以下稱「本網站」）。當您瀏覽或使用本網站，即表示您已閱讀、瞭解並同意遵守本服務條款。若您不同意，請立即停止使用本網站。
                </p>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">一、條款之接受與變更</h2>
                    <ol>
                        <li>本條款構成您與本公司間就使用本網站之約定。</li>
                        <li>本公司得隨時修訂本條款，並公布於本頁；修訂後自公布時起生效。若您於修訂後繼續使用本網站，視為同意修訂內容。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">二、服務內容</h2>
                    <ol>
                        <li>本網站提供公司介紹、產品與應用資訊、人力招募、聯絡管道及其他本公司不定期更新之內容。</li>
                        <li>本網站內容以形象展示與資訊提供為主；線上資訊不當然構成要約、報價或契約。實際產品規格、交期、價格與合作條件，仍以雙方另行確認或書面約定為準。</li>
                        <li>本公司得視營運需要增減、調整或暫停本網站全部或部分功能，恕不另行個別通知。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">三、使用者義務</h2>
                    <p>您同意不會從事下列行為：</p>
                    <ol>
                        <li>以任何方式干擾、破壞本網站系統、安全機制或他人使用。</li>
                        <li>上傳、傳送含有惡意程式、違法、侵權、誹謗、猥褻或其他不當內容。</li>
                        <li>未經授權蒐集本網站使用者資料，或進行自動化大量抓取、掃描。</li>
                        <li>偽冒身分、提供不實資料，或以詐欺方式使用聯絡／應徵表單。</li>
                        <li>其他違反中華民國法令或公序良俗之行為。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">四、智慧財產權</h2>
                    <ol>
                        <li>本網站之文字、圖片、圖示、影音、版面設計、商標與其他內容，除法令另有規定或另行標示外，其權利歸本公司或合法權利人所有。</li>
                        <li>非經權利人事先書面同意，您不得重製、改作、公開傳輸、散布、販售或以其他方式利用本網站內容。</li>
                        <li>若您認為本網站內容有侵權疑慮，請透過本頁「聯絡方式」與我們聯繫，我們將盡速處理。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">五、外部連結</h2>
                    <p>本網站可能提供第三方網站或服務之連結（例如人力銀行、地圖服務）。該等網站或服務由第三人營運，其內容、隱私與條款與其自行負責；您進入前請自行審慎評估。本公司不對第三方內容或服務負保證責任。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">六、免責聲明</h2>
                    <ol>
                        <li>本網站內容已盡合理努力維持正確與更新，惟可能因市場、供應或技術變更而有所調整；本公司不保證內容之絕對完整、即時或適用於特定用途。</li>
                        <li>本網站可能因維護、升級、通訊或不可抗力等因素中斷或發生錯誤，本公司不保證服務永不中斷或完全無誤。</li>
                        <li>在法律允許之最大範圍內，本公司對因使用或無法使用本網站所生之任何直接、間接、附隨或衍生損害，不負賠償責任。但因本公司故意或重大過失所致者，不在此限。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">七、表單與資訊提交</h2>
                    <ol>
                        <li>您透過聯絡表單、應徵或其他管道提交之資料，應確保真實、完整且未侵害他人權益。</li>
                        <li>本公司收受訊息後將盡力回覆，惟不保證特定回覆時間，亦不因此當然成立商業或僱傭契約。</li>
                        <li>個人資料之處理請另參本網站「隱私權政策」。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">八、準據法與管轄</h2>
                    <p>本條款之解釋與適用，以中華民國法令為準據法。因本條款或本網站使用所生之爭議，雙方應先友善協商；協商不成時，同意以臺灣桃園地方法院為第一審管轄法院。但法令另有強制規定者，從其規定。</p>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">九、其他</h2>
                    <ol>
                        <li>本條款任一條款經認定無效者，不影響其他條款之效力。</li>
                        <li>本公司未行使本條款任一權利，不構成對該權利之拋棄。</li>
                    </ol>
                </section>

                <section class="legal-section">
                    <h2 class="text-ch5 text-gray5">十、聯絡方式</h2>
                    <p>如對本服務條款有任何問題，歡迎與我們聯繫：</p>
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
