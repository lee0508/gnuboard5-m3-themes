<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>
<a class="skip-link" href="#container">본문 바로가기</a>
<header class="site-header" id="site-header">
    <div class="header-alert">
        <div class="inner alert-inner">
            <p><i class="bx bx-info-circle" aria-hidden="true"></i> 응급 증상은 온라인 상담 대신 119 또는 가까운 응급실을 이용해 주세요.</p>
            <div class="header-user-links">
                <?php if ($is_member) { ?>
                    <a href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
                    <?php if ($is_admin) { ?><a href="<?php echo G5_ADMIN_URL; ?>">관리자</a><?php } ?>
                <?php } else { ?>
                    <a href="<?php echo G5_BBS_URL; ?>/login.php">로그인</a>
                    <a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="inner nav-row">
        <a class="brand" href="<?php echo G5_URL; ?>" aria-label="ONCARE 의원 홈">
            <span class="brand-mark"><i class="bx bx-plus-medical" aria-hidden="true"></i></span>
            <span><strong>ONCARE 의원</strong><small>ONCARE CLINIC</small></span>
        </a>
        <button class="mobile-menu-button" type="button" aria-expanded="false" aria-controls="main-navigation">
            <i class="bx bx-menu" aria-hidden="true"></i><span class="sound_only">전체 메뉴</span>
        </button>
        <nav id="main-navigation" class="main-navigation" aria-label="주요 메뉴">
            <?php
            // 메뉴 설정(관리자 > 환경설정 > 메뉴설정)을 읽어옵니다.
            // 테마 파일에 메뉴 URL을 고정하지 않아 병원별 메뉴 변경이 즉시 반영됩니다.
            $menu_datas = get_menu_db(0, true);
            if (!empty($menu_datas)) {
                echo '<ul class="main-menu">';
                foreach ($menu_datas as $row) {
                    if (empty($row)) continue;
                    echo '<li><a href="'.get_text($row['me_link']).'" target="_'.get_text($row['me_target']).'">'.get_text($row['me_name']).'</a>';
                    // 2차 메뉴가 설정된 경우에만 하위 목록을 출력합니다.
                    // null 병합 연산자를 사용해 PHP 8에서 sub 키가 없는 메뉴도 경고 없이 처리합니다.
                    if (!empty($row['sub'])) {
                        echo '<ul class="sub-menu">';
                        foreach (($row['sub'] ?? array()) as $row2) {
                            if (empty($row2)) continue;
                            echo '<li><a href="'.get_text($row2['me_link']).'" target="_'.get_text($row2['me_target']).'">'.get_text($row2['me_name']).'</a></li>';
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                }
                echo '</ul>';
            } else {
            ?>
                <ul class="main-menu">
                    <li><a href="<?php echo G5_URL; ?>">병원 소개</a></li>
                    <li><a href="#doctors">의료진</a></li>
                    <li><a href="#departments">진료 안내</a></li>
                    <li><a href="#health-checkup">건강검진</a></li>
                    <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php">상담·예약</a></li>
                    <li><a href="#location">이용 안내</a></li>
                </ul>
            <?php } ?>
        </nav>
        <a class="header-reservation" href="<?php echo G5_BBS_URL; ?>/qalist.php">
            <i class="bx bx-calendar-check" aria-hidden="true"></i> 진료 예약
        </a>
    </div>
</header>
<main id="container" class="site-main">
<?php if (!defined('_INDEX_')) { ?>
    <div class="subpage-title"><div class="inner"><span>ONCARE CLINIC</span><h1><?php echo get_head_title($g5['title']); ?></h1></div></div>
    <div class="inner subpage-content">
<?php } ?>
