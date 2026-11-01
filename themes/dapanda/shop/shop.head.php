<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.css">', 0);

// 다판다 커스텀 : M3 토큰(Pretendard 포함) + 로컬 Boxicons v3 + 시니어 친화 스타일. 외부 CDN 없음 (공통 디자인 규칙 10장)
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/m3-tokens.css?v=2611012">', 1);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/icons/boxicons-local.css?v=2611012">', 2);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/dapanda.css?v=2611012">', 3);
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
	} ?>
     
	<div id="tnb">
    	<div class="inner">
            <?php if(defined('G5_COMMUNITY_USE') && G5_COMMUNITY_USE) { ?>
    		<ul id="hd_define">
    			<li><a href="<?php echo G5_URL ?>/">커뮤니티</a></li>
    			<li class="active"><a href="<?php echo G5_SHOP_URL ?>/">쇼핑몰</a></li>
    		</ul>
            <?php } ?>
            <!-- 최상단 유틸 바 (참조 테마 ety_theme_company 구성) 시작 { -->
            <ul id="tnb_sns">
                <li><a href="#" title="페이스북"><i class='bx bxl-facebook'></i><span class="sound_only">페이스북</span></a></li>
                <li><a href="#" title="트위터"><i class='bx bxl-twitter'></i><span class="sound_only">트위터</span></a></li>
                <li><a href="#" title="인스타그램"><i class='bx bxl-instagram'></i><span class="sound_only">인스타그램</span></a></li>
            </ul>
            <?php
            // 현재 접속자 수 (최고관리자 제외)
            $tmp_row = sql_fetch(" select count(*) as cnt from {$g5['login_table']} where mb_id <> '{$config['cf_admin']}' ");
            $tnb_connect_cnt = number_format($tmp_row['cnt']);
            ?>
            <ul id="tnb_util">
                <li><a href="<?php echo G5_BBS_URL; ?>/new.php"><i class='bx bx-history'></i> 새글</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/current_connect.php"><i class='bx bx-group'></i> 접속자 <strong class="visit-num"><?php echo $tnb_connect_cnt; ?></strong></a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><i class='bx bx-chat'></i> 1:1문의</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/faq.php"><i class='bx bx-question-mark'></i> FAQ</a></li>
            <?php if ($is_member) { ?>
                <?php if (!$is_admin) { // 관리자 계정은 이름 인사와 관리자 링크를 노출하지 않음 ?>
                <li class="tnb_hello"><i class='bx bxs-user-circle'></i> <b><?php echo get_text($member['mb_name']); ?></b>님</li>
                <?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/logout.php"><i class='bx bx-log-out'></i> 로그아웃</a></li>
            <?php } else { ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>" class="tnb_point"><i class='bx bx-log-in'></i> 로그인</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/register.php"><i class='bx bx-user-plus'></i> 회원가입</a></li>
            <?php } ?>
            </ul>
            <!-- } 최상단 유틸 바 끝 -->
			<?php /* 고객 메뉴는 오른쪽 사이드 바(#quick)로 이동 */ ?>
		</div>
	</div>
    <div id="hd_wrapper">
        <div id="logo">
        	<a href="<?php echo G5_SHOP_URL; ?>/" class="dapanda_logo"><i class='bx bxs-shopping-bag'></i><span><?php echo $config['cf_title']; ?></span></a>
        </div>
		
		<div class="hd_sch_wr">
	        <fieldset id="hd_sch">
	            <legend>쇼핑몰 전체검색</legend>
	            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
	            <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	            <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required placeholder="검색어를 입력해주세요">
	            <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
	            </form>
	            <script>
	            function search_submit(f) {
	                if (f.q.value.length < 2) {
	                    alert("검색어는 두글자 이상 입력하십시오.");
	                    f.q.select();
	                    f.q.focus();
	                    return false;
	                }
	                return true;
	            }
	            </script>
	        </fieldset>
		</div>
        <!-- 쇼핑몰 배너 시작 { -->
        <?php // echo display_banner('왼쪽'); ?>
        <!-- } 쇼핑몰 배너 끝 -->
        
        <ul class="hd_login">        
            <?php if ($is_member) {  ?>
			<li class="shop_login">
				<?php echo outlogin('theme/shop_basic'); // 아웃로그인 ?>	
			</li>
			<li class="shop_cart"><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="sound_only">장바구니</span><span class="count"><?php echo get_boxcart_datas_count(); ?></span></a></li>
            <?php } else { ?>
            <li class="login"><a href="<?php echo G5_BBS_URL ?>/login.php?url=<?php echo $urlencode; ?>">로그인</a></li>
            <?php }  ?>
        </ul>
    </div>

    <div id="hd_menu">
    	<button type="button" id="menu_open"><i class="fa fa-bars" aria-hidden="true"></i> 카테고리</button>
		<?php include_once(G5_THEME_SHOP_PATH.'/category.php'); // 분류 ?>
		<ul class="hd_menu">
            <li><a href="<?php echo shop_type_url(1); ?>">히트상품</a></li>
            <li><a href="<?php echo shop_type_url(2); ?>">추천상품</a></li>
            <li><a href="<?php echo shop_type_url(3); ?>">최신상품</a></li>
            <li><a href="<?php echo shop_type_url(4); ?>">인기상품</a></li>
            <li><a href="<?php echo shop_type_url(5); ?>">할인상품</a></li>
        </ul>
    </div> 
</div>
<!-- } 상단 끝 -->
        
<div id="side_menu">
	<!-- 사이드 바 접기/펼치기 토글 -->
	<button type="button" id="side_toggle" aria-expanded="true" aria-controls="side_menu"><i class='bx bx-chevron-right'></i><span>메뉴닫기</span></button>
	<ul id="quick">
		<li><button class="btn_sm_cl1 btn_sm"><i class="fa fa-user-o" aria-hidden="true"></i><span class="qk_tit">마이메뉴</span></button></li>
		<li><button class="btn_sm_cl2 btn_sm"><i class="fa fa-archive" aria-hidden="true"></i><span class="qk_tit">오늘 본 상품</span></button></li>
		<li><button class="btn_sm_cl3 btn_sm"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="qk_tit">장바구니</span></button></li>
		<li><button class="btn_sm_cl4 btn_sm"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="qk_tit">위시리스트</span></button></li>
		<!-- 고객 메뉴 (상단 유틸에서 이동) 시작 { -->
		<li class="qk_divider" aria-hidden="true"></li>
		<li class="qk_link"><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"><i class='bx bx-credit-card'></i><span class="qk_tit">개인결제</span></a></li>
		<li class="qk_link"><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php"><i class='bx bx-star'></i><span class="qk_tit">사용후기</span></a></li>
		<li class="qk_link"><a href="<?php echo G5_SHOP_URL; ?>/itemqalist.php"><i class='bx bx-help-circle'></i><span class="qk_tit">상품문의</span></a></li>
		<li class="qk_link"><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php"><i class='bx bxs-coupon'></i><span class="qk_tit">쿠폰존</span></a></li>
		<!-- } 고객 메뉴 끝 -->
    </ul>
    <button type="button" id="top_btn"><i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></button>
    <div id="tabs_con">
	    <div class="side_mn_wr1 qk_con">
	    	<div class="qk_con_wr">
	    		<?php echo outlogin('theme/shop_side'); // 아웃로그인 ?>
		        <ul class="side_tnb">
		        	<?php if ($is_member) { ?>
					<li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></li>
		            <?php } ?>
					<li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문내역</a></li>
					<li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
		            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1문의</a></li>
		            <li><a href="<?php echo G5_SHOP_URL ?>/personalpay.php">개인결제</a></li>
		            <li><a href="<?php echo G5_SHOP_URL ?>/itemuselist.php">사용후기</a></li>
		            <li><a href="<?php echo G5_SHOP_URL ?>/itemqalist.php">상품문의</a></li>
		            <li><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php">쿠폰존</a></li>
		        </ul>
	        	<?php // include_once(G5_SHOP_SKIN_PATH.'/boxcommunity.skin.php'); // 커뮤니티 ?>
	    		<button type="button" class="con_close"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">나의정보 닫기</span></button>
	    	</div>
	    </div>
	    <div class="side_mn_wr2 qk_con">
	    	<div class="qk_con_wr">
	        	<?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
	    		<button type="button" class="con_close"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">오늘 본 상품 닫기</span></button>
	    	</div>
	    </div>
	    <div class="side_mn_wr3 qk_con">
	    	<div class="qk_con_wr">
	        	<?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>
	    		<button type="button" class="con_close"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">장바구니 닫기</span></button>
	    	</div>
	    </div>
	    <div class="side_mn_wr4 qk_con">
	    	<div class="qk_con_wr">
	        	<?php include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>
	    		<button type="button" class="con_close"><i class="fa fa-times-circle" aria-hidden="true"></i><span class="sound_only">위시리스트 닫기</span></button>
	    	</div>
	    </div>
    </div>
</div>
<script>
jQuery(function ($){
	$(".btn_member_mn").on("click", function() {
        $(".member_mn").toggle();
        $(".btn_member_mn").toggleClass("btn_member_mn_on");
    });
    
    var active_class = "btn_sm_on",
        side_btn_el = "#quick .btn_sm",
        quick_container = ".qk_con";

    $(document).on("click", side_btn_el, function(e){
        e.preventDefault();

        var $this = $(this);
        
        if (!$this.hasClass(active_class)) {
            $(side_btn_el).removeClass(active_class);
            $this.addClass(active_class);
        }

        if( $this.hasClass("btn_sm_cl1") ){
            $(".side_mn_wr1").show();
        } else if( $this.hasClass("btn_sm_cl2") ){
            $(".side_mn_wr2").show();
        } else if( $this.hasClass("btn_sm_cl3") ){
            $(".side_mn_wr3").show();
        } else if( $this.hasClass("btn_sm_cl4") ){
            $(".side_mn_wr4").show();
        }
    }).on("click", ".con_close", function(e){
        $(quick_container).hide();
        $(side_btn_el).removeClass(active_class);
    });

    $(document).mouseup(function (e){
        var container = $(quick_container),
            mn_container = $(".shop_login");
        if( container.has(e.target).length === 0){
            container.hide();
            $(side_btn_el).removeClass(active_class);
        }
        if( mn_container.has(e.target).length === 0){
            $(".member_mn").hide();
            $(".btn_member_mn").removeClass("btn_member_mn_on");
        }
    });

    $("#side_toggle").on("click", function() {
        var closed = $("#side_menu").toggleClass("sm_closed").hasClass("sm_closed");
        $(this).attr("aria-expanded", closed ? "false" : "true");
        $(this).find("span").text(closed ? "메뉴보기" : "메뉴닫기");
        $(this).find("i").attr("class", closed ? "bx bx-chevron-left" : "bx bx-chevron-right");
        if (closed) {
            $(".qk_con").hide();
            $("#quick .btn_sm").removeClass("btn_sm_on");
        }
    });

    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<?php
    $wrapper_class = array();
    if( defined('G5_IS_COMMUNITY_PAGE') && G5_IS_COMMUNITY_PAGE ){
        $wrapper_class[] = 'is_community';
    }
?>
<!-- 전체 콘텐츠 시작 { -->
<div id="wrapper" class="<?php echo implode(' ', $wrapper_class); ?>">
    <!-- #container 시작 { -->
    <div id="container">

        <?php if(defined('_INDEX_')) { ?>
        <div id="aside">
            <?php include_once(G5_SHOP_SKIN_PATH.'/boxcategory.skin.php'); // 상품분류 ?>
            <?php if($default['de_type4_list_use']) { ?>
            <!-- 인기상품 시작 { -->
            <section id="side_pd">
                <h2><a href="<?php echo shop_type_url('4'); ?>">인기상품</a></h2>
                <?php
                $list = new item_list();
                $list->set_type(4);
                $list->set_view('it_id', false);
                $list->set_view('it_name', true);
                $list->set_view('it_basic', false);
                $list->set_view('it_cust_price', false);
                $list->set_view('it_price', true);
                $list->set_view('it_icon', false);
                $list->set_view('sns', false);
                $list->set_view('star', true);
                echo $list->run();
                ?>
            </section>
            <!-- } 인기상품 끝 -->
            <?php } ?>
            
            <?php echo display_banner('왼쪽', 'boxbanner.skin.php'); ?>
            <?php echo poll('theme/shop_basic'); // 설문조사 ?>
        </div>
        <?php } // end if ?>
        <?php
            $content_class = array('shop-content');
            if( isset($it_id) && isset($it) && isset($it['it_id']) && $it_id === $it['it_id']){
                $content_class[] = 'is_item';
            }
            if( defined('IS_SHOP_SEARCH') && IS_SHOP_SEARCH ){
                $content_class[] = 'is_search';
            }
            if( defined('_INDEX_') && _INDEX_ ){
                $content_class[] = 'is_index';
            }
        ?>
        <!-- .shop-content 시작 { -->
        <div class="<?php echo implode(' ', $content_class); ?>">
            <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><div id="wrapper_title"><?php echo $g5['title'] ?></div><?php } ?>
            <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
            <div id="text_size">
                <button class="no_text_resize" onclick="font_resize('container', 'decrease');">작게</button>
                <button class="no_text_resize" onclick="font_default('container');">기본</button>
                <button class="no_text_resize" onclick="font_resize('container', 'increase');">크게</button>
            </div>
            <!-- } 글자크기 조정 display:none 되어 있음 끝 -->