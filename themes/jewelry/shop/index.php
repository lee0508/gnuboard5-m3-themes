<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

if(! defined('_INDEX_')) define('_INDEX_', TRUE);

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>

<!-- 메인이미지 시작 { -->
<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<!-- } 메인이미지 끝 -->

<!-- 다있다 히어로 배너 (그누위즈 데모 구조 참조) 시작 { -->
<section id="daitda_hero">
    <h2 class="sound_only">메인 배너</h2>
    <div class="hero_slider owl-carousel">
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=10" class="hero_slide" style="background-image:url('<?php echo G5_DATA_URL; ?>/common/hero_1.jpg')">
            <div class="hero_txt">
                <em>다있다 주얼리</em>
                <strong>빛나는 순간을<br>선물하세요</strong>
                <span>14K · 18K 파인 주얼리 특가전</span>
                <b class="hero_btn">주얼리 보러가기 <i class='bx bx-right-arrow-alt'></i></b>
            </div>
        </a>
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=1010" class="hero_slide" style="background-image:url('<?php echo G5_DATA_URL; ?>/common/hero_2.jpg')">
            <div class="hero_txt">
                <em>RING COLLECTION</em>
                <strong>평생을 함께할<br>단 하나의 반지</strong>
                <span>랩 다이아몬드 반지 모음전</span>
                <b class="hero_btn">반지 보러가기 <i class='bx bx-right-arrow-alt'></i></b>
            </div>
        </a>
        <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=20" class="hero_slide" style="background-image:url('<?php echo G5_DATA_URL; ?>/common/hero_3.jpg')">
            <div class="hero_txt">
                <em>GIFT COLLECTION</em>
                <strong>감사한 마음을<br>주얼리에 담아</strong>
                <span>팔찌 · 탄생석 펜던트 선물 추천</span>
                <b class="hero_btn">악세서리 보러가기 <i class='bx bx-right-arrow-alt'></i></b>
            </div>
        </a>
    </div>
</section>
<script>
$(function(){
    $('#daitda_hero .hero_slider').owlCarousel({
        items:1, loop:true, autoplay:true, autoplayTimeout:5000,
        autoplayHoverPause:true, nav:true, dots:true,
        navText:["<i class='bx bx-chevron-left'></i>","<i class='bx bx-chevron-right'></i>"]
    });
});
</script>
<!-- } 다있다 히어로 배너 끝 -->

<!-- 인기 키워드 (그누위즈 데모 구조 참조) 시작 { -->
<section id="daitda_keyword">
    <h2>인기 키워드 <i class='bx bx-trending-up sec_emoji'></i></h2>
    <p class="sec_desc">고객님들이 가장 많이 찾는 검색어입니다.</p>
    <div class="keyword_chips">
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('반지'); ?>"># 반지</a>
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('목걸이'); ?>"># 목걸이</a>
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('귀걸이'); ?>"># 귀걸이</a>
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('팔찌'); ?>"># 팔찌</a>
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('탄생석'); ?>"># 탄생석</a>
        <a href="<?php echo G5_SHOP_URL; ?>/search.php?q=<?php echo urlencode('랩다이아'); ?>"># 랩다이아</a>
    </div>
</section>
<!-- } 인기 키워드 끝 -->

<?php if($default['de_type1_list_use']) { ?>
<!-- 히트상품 시작 { -->
<section id="idx_hit" class="sct_wrap">
    <header>
        <h2><a href="<?php echo shop_type_url('1'); ?>">히트상품 <i class='bx bxs-hot sec_emoji'></i></a></h2>
        <p class="sec_desc">지금 가장 잘나가는 인기 상품입니다.</p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(1);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    $list->set_view('star', true);
    echo $list->run();
    ?>
</section>
<!-- } 히트상품 끝 -->
<script>
//히트상품
$(function(){
    var hit_smt_val = parseInt($('#idx_hit .smt_40').attr("data-value"));
    
    if(! hit_smt_val){
        hit_smt_val = 5;
    }

	$('#idx_hit .smt_40').owlCarousel({
	    loop:true,
	    nav:true,
	    autoplay:true,
        autoplayHoverPause:true,
	    responsive:{
	        1000:{items: hit_smt_val}
	    }
	})
});
</script>
<?php } ?>

<?php if($default['de_type3_list_use']) { ?>
<!-- 최신상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo shop_type_url('3'); ?>">최신상품 <i class='bx bxs-star sec_emoji'></i></a></h2>
        <p class="sec_desc">새로 입고된 따끈따끈한 신상품입니다.</p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(3);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    $list->set_view('star', true);
    echo $list->run();
    ?>
</section>
<!-- } 최신상품 끝 -->
<?php } ?>

<?php if($default['de_type2_list_use']) { ?>
<!-- 추천상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo shop_type_url('2'); ?>">추천상품 <i class='bx bxs-like sec_emoji'></i></a></h2>
        <p class="sec_desc">다있다 주얼리가 자신 있게 추천합니다.</p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(2);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    $list->set_view('star', true);
    echo $list->run();
    ?>
</section>
<!-- } 추천상품 끝 -->
<?php } ?>

<?php include_once(G5_SHOP_SKIN_PATH.'/boxevent.skin.php'); // 이벤트 ?>

<?php if($default['de_type5_list_use']) { ?>
<!-- 할인상품 시작 { -->
<section class="sct_wrap">
    <header>
        <h2><a href="<?php echo shop_type_url('5'); ?>">할인상품 <i class='bx bxs-gift sec_emoji'></i></a></h2>
        <p class="sec_desc">지금 놓치면 아쉬운 특가 상품입니다.</p>
    </header>
    <?php
    $list = new item_list();
    $list->set_type(5);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_basic', true);
    $list->set_view('it_cust_price', true);
    $list->set_view('it_price', true);
    $list->set_view('it_icon', true);
    $list->set_view('sns', true);
    $list->set_view('star', true);
    echo $list->run();
    ?>
</section>
<!-- } 할인상품 끝 -->
<?php } ?>

<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');