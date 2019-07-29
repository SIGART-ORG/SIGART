"use strict";
/*****Ready function start*****/
$(document).ready(function(){
    mintos();
    // emailApp();
    // chatApp();
    // calendarApp();
    // fmApp();
    /*Disabled*/
    $(document).on("click", "a.disabled,a:disabled",function(e) {
        return false;
    });
});
/*****Ready function end*****/

/*****Load function start*****/
$(window).on("load",function(){
    $(".preloader-it").delay(500).fadeOut("slow");
});
/*****Load function* end*****/

/*Variables*/
var height,width,
    $wrapper = $(".hk-wrapper"),
    $nav = $(".hk-nav"),
    $vertnaltNav = $(".hk-wrapper.hk-vertical-nav,.hk-wrapper.hk-alt-nav"),
    $horizontalNav = $(".hk-wrapper.hk-horizontal-nav"),
    $navbar= $(".hk-navbar");

/***** Mintos function start *****/
var mintos = function(){

    /*Feather Icon*/
    var featherIcon = $('.feather-icon');
    if( featherIcon.length > 0 ){
        feather.replace();
    }


    /*Counter Animation*/
    var counterAnim = $('.counter-anim');
    if( counterAnim.length > 0 ){
        counterAnim.counterUp({ delay: 10,
            time: 1000});
    }

    /*Tooltip*/
    if( $('[data-toggle="tooltip"]').length > 0 )
        $('[data-toggle="tooltip"]').tooltip();

    /*Popover*/
    if( $('[data-toggle="popover"]').length > 0 )
        $('[data-toggle="popover"]').popover()

    /*Navbar Collapse Animation*/
    var navbarNavCollapse = $('.hk-nav .navbar-nav  li');
    var navbarNavAnchor = '.hk-nav .navbar-nav  li a';
    $(document).on("click",navbarNavAnchor,function (e) {
        if ($(this).attr('aria-expanded') === "false")
            $(this).blur();
        $(this).parent().siblings().find('.collapse').collapse('hide');
        $(this).parent().find('.collapse').collapse('hide');
    });

    /*Card Remove*/
    $(document).on('click', '.card-close', function (e) {
        var effect = $(this).data('effect');
        $(this).closest('.card')[effect]();
        return false;
    });

    /*Accordion js*/
    $(document).on('show.bs.collapse', '.accordion .collapse', function (e) {
        $(this).siblings('.card-header').addClass('activestate');
    });

    $(document).on('hide.bs.collapse', '.accordion .collapse', function (e) {
        $(this).siblings('.card-header').removeClass('activestate');
    });

    /*Navbar Toggle*/
    $(document).on('click', '#navbar_toggle_btn', function (e) {
        $wrapper.toggleClass('hk-nav-toggle');
        $(window).trigger( "resize" );
        return false;
    });
    $(document).on('click', '#hk_nav_backdrop,#hk_nav_close', function (e) {
        $wrapper.removeClass('hk-nav-toggle');
        return false;
    });

    /*Settings panel Toggle*/
    $(document).on('click', '#settings_toggle_btn', function (e) {
        $wrapper.toggleClass('hk-settings-toggle');
        return false;
    });
    $(document).on('click', '#settings_panel_close', function (e) {
        $wrapper.removeClass('hk-settings-toggle');
        return false;
    });
    $(document).on('click', '#nav_light_select', function (e) {
        $nav.removeClass('hk-nav-dark').addClass('hk-nav-light');
        return false;
    });
    $(document).on('click', '#nav_dark_select', function (e) {
        $nav.removeClass('hk-nav-light').addClass('hk-nav-dark');
        return false;
    });
    $(document).on('click', '#nav_light_select,#nav_dark_select', function (e) {
        $('.hk-nav-select').find('.btn').removeClass('btn-outline-primary').addClass('btn-outline-light');
        $(this).removeClass('btn-outline-light').addClass('btn-outline-primary').blur();
        return false;
    });
    $(document).on('click', '#navtop_light_select,#navtop_dark_select', function (e) {
        $('.hk-navbar-select').find('.btn').removeClass('btn-outline-primary').addClass('btn-outline-light');
        $(this).removeClass('btn-outline-light').addClass('btn-outline-primary').blur();
        return false;
    });
    $(document).on('click', '#navtop_light_select', function (e) {
        $navbar.removeClass('navbar-dark').addClass('navbar-light').find('img.brand-img').attr('src','dist/img/logo-light.png');
        return false;
    });
    $(document).on('click', '#navtop_dark_select', function (e) {
        $navbar.removeClass('navbar-light').addClass('navbar-dark').find('img.brand-img').attr('src','dist/img/logo-dark.png');
        return false;
    });
    if( $('.scroll-nav-switch').length > 0 ){
        $('.scroll-nav-switch').toggles({
            drag: true, // allow dragging the toggle between positions
            click: true, // allow clicking on the toggle
            text: {
                on: '', // text for the ON position
                off: '' // and off
            },
            on: false, // is the toggle ON on init
            animate: 250, // animation time (ms)
            easing: 'swing', // animation transition easing function
            checkbox: null, // the checkbox to toggle (for use in forms)
            clicker: null, // element that can be clicked on to toggle. removes binding from the toggle itself (use nesting)

            type: 'compact' // if this is set to 'select' then the select style toggle will be used
        });
        $('.scroll-nav-switch.toggle').on('toggle', function(e, active) {
            if (active) {
                $wrapper.addClass('scrollable-nav');
            } else {
                $wrapper.removeClass('scrollable-nav');
            }
        });
    }
    var navBarChk = ($('.hk-navbar').hasClass('navbar-dark')),
        navChk = ($('.hk-nav').hasClass('hk-nav-dark'))
    $(document).on('click', '#reset_settings', function (e) {
        if (navBarChk)
            $('#navtop_dark_select').click();
        else
            $('#navtop_light_select').click();
        if (navChk)
            $('#nav_dark_select').click();
        else
            $('#nav_light_select').click();
        $('.scroll-nav-switch').click();
        if ($('.scroll-nav-switch').find('.toggle-on').hasClass('active'))
            $('.scroll-nav-switch').click();
        return false;
    });

    /*Search form Collapse*/
    $(document).on('click', '#navbar_search_btn', function (e) {
        $('html,body').animate({ scrollTop: 0 }, 'slow');
        $(".navbar-search input").focus();
        $wrapper.addClass('navbar-search-toggle');
        $(window).trigger( "resize" );
    });
    $(document).on('click', '#navbar_search_close',function (e) {
        $wrapper.removeClass('navbar-search-toggle');
        $(window).trigger( "resize" );
        return false;
    });

    /*Slimscroll*/
    $('.nicescroll-bar').slimscroll({height:'100%',color: '#d6d9da', disableFadeOut : true,borderRadius:0,size:'6px',enableKeyNavigation: true,opacity:.8});
    $('.notifications-nicescroll-bar').slimscroll({height:'330px',size: '6px',color: '#d6d9da',disableFadeOut : true,borderRadius:0,enableKeyNavigation: true,opacity:.8});


    /*Slimscroll Key Control*/
    $(".slimScrollDiv").hover(function() {
        $(this).find('[class*="nicescroll-bar"]').focus();
    },function() {
        $(this).find('[class*="nicescroll-bar"]').blur();
    });

    /*Refresh Init Js*/
    var refreshMe = '.refresh';
    $(document).on("click",refreshMe,function (e) {
        var panelToRefresh = $(this).closest('.card').find('.refresh-container');
        var dataToRefresh = $(this).closest('.card').find('.panel-wrapper');
        var loadingAnim = panelToRefresh.find('.la-anim-1');
        panelToRefresh.show();
        setTimeout(function(){
            loadingAnim.addClass('la-animate');
        },100);
        function started(){} //function before timeout
        setTimeout(function(){
            function completed(){} //function after timeout
            panelToRefresh.fadeOut(800);
            setTimeout(function(){
                loadingAnim.removeClass('la-animate');
            },800);
        },1500);
        return false;
    });

    /*Fullscreen Init Js*/
    $(document).on("click",".full-screen",function (e) {
        $(this).parents('.card').toggleClass('fullscreen');
        $(window).trigger( "resize" );
        return false;
    });

};
/***** Mintos function end *****/
