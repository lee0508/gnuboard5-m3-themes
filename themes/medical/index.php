<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 그누보드 공통 초기화 없이 직접 실행되는 것을 차단합니다.

// 메인 홈은 의료기관 공통 예시입니다. 실제 진료 정보·예약 안내는 병원 검수 후 교체해야 합니다.
include_once(G5_THEME_PATH.'/head.php');
?>
<!-- 진료과 선택은 데모 단계에서 화면 콘텐츠만 바꿉니다. 실제 의료 콘텐츠는 승인된 게시물로 연결해야 합니다. -->
<section class="clinic-switcher" aria-labelledby="clinic-switcher-title"><div class="inner"><p id="clinic-switcher-title">진료과별 메인 화면 미리보기</p><div class="clinic-tabs" role="tablist" aria-label="진료과 선택"><button type="button" role="tab" aria-selected="true" data-clinic="dental">치과</button><button type="button" role="tab" aria-selected="false" data-clinic="dermatology">피부과</button><button type="button" role="tab" aria-selected="false" data-clinic="plastic">성형외과</button></div><span>실제 진료 범위·의료진·장비 정보는 병원 승인 후 등록합니다.</span></div></section>
<section class="hero" aria-labelledby="hero-title">
    <div class="hero-shape hero-shape-one"></div><div class="hero-shape hero-shape-two"></div>
    <div class="inner hero-grid">
        <div class="hero-copy">
            <p class="eyebrow"><span></span> <span data-clinic-label>치과 진료</span> · 정확한 진단, 따뜻한 진료</p>
            <h1 id="hero-title" data-clinic-title>자연치아를 오래 지키는<br><em>치과 진료를 안내합니다</em></h1>
            <p class="hero-description" data-clinic-description>증상과 상태를 확인한 뒤 치료 선택지, 예상 기간, 주의사항을 이해하기 쉬운 언어로 설명합니다.</p>
            <div class="hero-actions">
                <a class="button button-primary" href="#reservation">예약 안내 보기 <i class="bx bx-right-arrow-alt"></i></a>
                <a class="button button-ghost" href="tel:0200000000"><i class="bx bx-phone-call"></i> 02-000-0000</a>
            </div>
            <ul class="hero-trust">
                <li><i class="bx bx-check-shield"></i><span><strong>승인된 정보</strong>검수 후 게시</span></li>
                <li><i class="bx bx-conversation"></i><span><strong>충분한 설명</strong>한계·주의사항 안내</span></li>
                <li><i class="bx bx-building-house"></i><span><strong>이용 전 확인</strong>진료시간·위치 확인</span></li>
            </ul>
        </div>
        <div class="hero-visual" aria-label="의료진을 상징하는 그래픽">
            <div class="medical-orbit orbit-one"></div><div class="medical-orbit orbit-two"></div>
            <div class="doctor-card"><div class="doctor-portrait"><i class="bx bx-plus-medical"></i></div><div class="doctor-badge"><i class="bx bx-heart"></i><span>환자 중심<br><strong>안심 진료</strong></span></div></div>
        </div>
    </div>
</section>
<section class="quick-info" aria-label="진료 빠른 안내">
    <div class="inner quick-info-grid">
        <article><i class="bx bx-time-five"></i><div><span>예약 상담시간</span><strong>09:00 — 18:00</strong><small>휴진일·점심시간은 확인 후 안내</small></div></article>
        <article id="kakao-contact"><i class="bx bxl-kakao-talk"></i><div><span>카카오톡 상담</span><strong>@oncare</strong><small>친구 추가 후 상담 가능</small></div></article>
        <a href="tel:0200000000"><i class="bx bx-phone-call"></i><div><span>전화 예약·상담</span><strong>02-000-0000</strong><small>모바일에서 바로 연결</small></div><i class="bx bx-chevron-right"></i></a>
        <a href="#location"><i class="bx bx-map"></i><div><span>오시는 길</span><strong>○○구 ○○로 00</strong><small>방문 전 위치를 확인해 주세요</small></div><i class="bx bx-chevron-right"></i></a>
    </div>
</section>
<section class="section departments" id="departments">
    <div class="inner">
        <div class="section-heading centered"><p class="eyebrow"><span></span> SPECIALIZED CARE <span></span></p><h2>주요 진료 분야</h2><p>치과·피부과·성형외과의 정보는 치료 목적과 미용 목적을 명확히 구분해 안내합니다.</p></div>
        <div class="department-grid">
            <a class="department-card active" href="#reservation"><span class="department-number">01</span><i class="bx bx-tooth"></i><h3>치과 진료</h3><p>증상, 진단, 치료 선택지, 치료기간과 유지관리 정보를 순서대로 안내합니다.</p><span class="more">예약 전 확인 <i class="bx bx-right-arrow-alt"></i></span></a>
            <a class="department-card" href="#reservation"><span class="department-number">02</span><i class="bx bx-face"></i><h3>피부과 진료</h3><p>피부질환 진료와 미용·레이저 시술을 구분해 적응증과 주의사항을 안내합니다.</p><span class="more">예약 전 확인 <i class="bx bx-right-arrow-alt"></i></span></a>
            <a class="department-card" href="#reservation"><span class="department-number">03</span><i class="bx bx-body"></i><h3>성형외과 상담</h3><p>수술 방법, 마취, 회복, 부작용과 사후관리 정보를 충분히 확인하도록 구성합니다.</p><span class="more">상담 절차 보기 <i class="bx bx-right-arrow-alt"></i></span></a>
            <a class="department-card" href="#health-checkup"><span class="department-number">04</span><i class="bx bx-pulse"></i><h3>이용 안내</h3><p>진료시간, 휴진일, 오시는 길, 비급여 진료비와 개인정보 처리방침을 확인합니다.</p><span class="more">이용 안내 <i class="bx bx-right-arrow-alt"></i></span></a>
        </div>
    </div>
</section>
<section class="section care-principle" id="health-checkup">
    <div class="inner principle-grid">
        <div class="principle-visual"><div class="cross-pattern"></div><div class="principle-message"><strong>01</strong><p>환자의 이야기를<br>먼저 듣겠습니다.</p></div></div>
        <div class="principle-copy">
            <p class="eyebrow"><span></span> OUR PROMISE</p><h2>진료의 시작은<br><em>이해와 공감</em>입니다</h2>
            <p>검사 결과만 보는 것이 아니라 환자의 일상과 걱정을 함께 살핍니다. 의료진이 이해하기 쉬운 언어로 설명하고 치료 선택을 돕겠습니다.</p>
            <ol class="promise-list">
                <li><strong>01</strong><div><h3>꼭 필요한 진료</h3><p>과잉 진료 없이 근거에 따라 치료 방법을 안내합니다.</p></div></li>
                <li><strong>02</strong><div><h3>충분하고 쉬운 설명</h3><p>치료 과정과 주의사항, 예상되는 한계를 투명하게 설명합니다.</p></div></li>
                <li><strong>03</strong><div><h3>지속적인 사후관리</h3><p>진료 후 회복과 건강한 생활까지 함께 관리합니다.</p></div></li>
            </ol>
        </div>
    </div>
</section>
<section class="section doctors" id="doctors">
    <div class="inner">
        <div class="section-heading split-heading"><div><p class="eyebrow"><span></span> MEDICAL TEAM</p><h2>당신의 건강을 함께하는 의료진</h2></div><a class="text-link" href="#">의료진 전체 보기 <i class="bx bx-right-arrow-alt"></i></a></div>
        <div class="doctor-grid">
            <article class="doctor-profile"><div class="profile-visual profile-one"><i class="bx bx-user"></i></div><div class="profile-copy"><span>의료진 정보 등록 예정</span><h3>의료진 A</h3><p>진료분야·학력·경력은 증빙 및 의료진 최종 승인 후 게시합니다.</p><a href="#reservation">예약 안내 <i class="bx bx-right-arrow-alt"></i></a></div></article>
            <article class="doctor-profile"><div class="profile-visual profile-two"><i class="bx bx-user"></i></div><div class="profile-copy"><span>의료진 정보 등록 예정</span><h3>의료진 B</h3><p>진료일정과 의료진 지정 예약은 실제 운영 기준 확정 후 연결합니다.</p><a href="#reservation">예약 안내 <i class="bx bx-right-arrow-alt"></i></a></div></article>
            <article class="doctor-profile"><div class="profile-visual profile-three"><i class="bx bx-user"></i></div><div class="profile-copy"><span>의료진 정보 등록 예정</span><h3>의료진 C</h3><p>의료광고 검토가 필요한 정보는 검수 완료 상태에서만 게시합니다.</p><a href="#reservation">예약 안내 <i class="bx bx-right-arrow-alt"></i></a></div></article>
        </div>
    </div>
</section>
<section class="reservation-banner" id="reservation">
    <div class="inner reservation-grid"><div><p>RESERVATION PROCESS</p><h2>예약 신청은 병원 확인 후 확정됩니다.</h2><span>예약 상담은 오전 09:00부터 오후 18:00까지 가능합니다. 이름·휴대전화·희망 진료항목·희망 날짜만 우선 수집하도록 설계하며, EMR/CRM 연동은 제공 정보가 확인된 뒤 연결합니다.</span></div><div class="reservation-actions"><a href="tel:0200000000"><i class="bx bx-phone-call"></i><span>전화 상담<strong>02-000-0000</strong></span></a><a class="reserve-now" href="#kakao-contact"><i class="bx bxl-kakao-talk"></i><span>카카오톡 상담<strong>@oncare</strong></span></a></div></div>
</section>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
