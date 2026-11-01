(function ($) {
    'use strict';

    $(function () {
        var $menu = $('#main-navigation');
        var $menuButton = $('.mobile-menu-button');

        // 모바일 메뉴 버튼의 시각 상태와 접근성 상태를 함께 변경합니다.
        $menuButton.on('click', function () {
            var isOpen = $menu.toggleClass('open').hasClass('open');
            $(this).attr('aria-expanded', isOpen);
            $(this).find('.bx').toggleClass('bx-menu', !isOpen).toggleClass('bx-x', isOpen);
        });

        // 모바일 메뉴에서 링크를 선택하면 열린 메뉴를 닫습니다.
        $menu.find('a').on('click', function () {
            if (window.innerWidth <= 768) {
                $menu.removeClass('open');
                $menuButton.attr('aria-expanded', 'false').find('.bx').removeClass('bx-x').addClass('bx-menu');
            }
        });

        // 브라우저 크기가 바뀌었을 때 모바일 메뉴 상태가 남지 않도록 정리합니다.
        $(window).on('resize', function () {
            if (window.innerWidth > 768) {
                $menu.removeClass('open');
                $menuButton.attr('aria-expanded', 'false').find('.bx').removeClass('bx-x').addClass('bx-menu');
            }
        });

        $('.top-button').on('click', function () {
            $('html, body').animate({ scrollTop: 0 }, 350);
        });

        // 진료과별 비교용 문구입니다. 의료기관이 승인한 실제 콘텐츠로 교체하기 전까지는
        // 치료 효과·성공률·전후 사진 등 광고 심의가 필요한 표현을 사용하지 않습니다.
        var clinicContent = {
            dental: { label: '치과 진료', title: '자연치아를 오래 지키는<br><em>치과 진료를 안내합니다</em>', description: '증상과 상태를 확인한 뒤 치료 선택지, 예상 기간, 주의사항을 이해하기 쉬운 언어로 설명합니다.' },
            dermatology: { label: '피부과 진료', title: '질환 진료와 미용 시술을<br><em>구분해 안내합니다</em>', description: '피부질환과 미용·레이저 정보를 구분하고, 적응증·횟수·회복·주의사항을 확인할 수 있도록 구성합니다.' },
            plastic: { label: '성형외과 상담', title: '충분한 숙고와 안전정보를<br><em>먼저 안내합니다</em>', description: '수술 방법, 마취, 회복기간, 발생 가능한 부작용과 사후관리 정보를 상담 전부터 확인하도록 구성합니다.' }
        };

        $('.clinic-tabs button').on('click', function () {
            var selectedClinic = clinicContent[$(this).data('clinic')];
            if (!selectedClinic) return;
            $('.clinic-tabs button').attr('aria-selected', 'false');
            $(this).attr('aria-selected', 'true');
            $('[data-clinic-label]').text(selectedClinic.label);
            $('[data-clinic-title]').html(selectedClinic.title);
            $('[data-clinic-description]').text(selectedClinic.description);
        });
    });
})(jQuery);
