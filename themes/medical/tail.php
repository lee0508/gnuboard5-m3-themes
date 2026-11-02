<?php
// head.php에서 연 비인덱스 본문 컨테이너를 정확히 닫아 게시판·콘텐츠 페이지의 레이아웃을 유지합니다.
if (!defined('_GNUBOARD_')) exit;
?>
<?php if (!defined('_INDEX_')) { ?></div><?php } ?>
</main>
<footer class="site-footer" id="location">
    <div class="inner footer-grid">
        <div class="footer-brand">
            <a class="brand brand-light" href="<?php echo G5_URL; ?>"><span class="brand-mark"><i class="bx bx-plus-medical"></i></span><span><strong>ONCARE 의원</strong><small>ONCARE CLINIC</small></span></a>
            <p>환자의 이야기를 먼저 듣고, 충분히 설명하는 진료를 지향합니다.</p>
        </div>
        <div><h2>병원 정보</h2><ul><li>서울특별시 ○○구 ○○로 00</li><li>대표전화 <a href="tel:0200000000">02-000-0000</a></li><li>예약 상담 09:00 — 18:00</li></ul></div>
        <div><h2>바로가기</h2><div class="footer-links"><a href="#kakao-contact">카카오톡 ID @oncare</a><a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a><a href="<?php echo get_pretty_url('content', 'provision'); ?>">이용약관</a><a href="<?php echo G5_BBS_URL; ?>/faq.php">자주 묻는 질문</a></div></div>
    </div>
    <div class="inner copyright">Copyright &copy; <?php echo date('Y'); ?> ONCARE 의원. All rights reserved.</div>
</footer>
<div class="mobile-quickbar" aria-label="빠른 메뉴">
    <a href="tel:0200000000"><i class="bx bx-phone"></i><span>전화</span></a>
    <a href="<?php echo G5_BBS_URL; ?>/qalist.php"><i class="bx bx-message-rounded-dots"></i><span>상담</span></a>
    <a href="<?php echo G5_BBS_URL; ?>/qalist.php"><i class="bx bx-calendar-check"></i><span>예약</span></a>
</div>
<button class="top-button" type="button" aria-label="페이지 상단으로"><i class="bx bx-up-arrow-alt"></i></button>
<?php
// 그누보드의 스크립트 큐를 사용해 jQuery·공통 스크립트 뒤에 테마 상호작용 스크립트를 적재합니다.
add_javascript('<script src="'.G5_THEME_JS_URL.'/medical.js"></script>', 20);
if ($config['cf_analytics']) echo $config['cf_analytics'];
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
