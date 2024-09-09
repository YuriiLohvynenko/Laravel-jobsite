/* ----------------- Start Document ----------------- */
(function($) {
    "use strict";

    $(document).ready(function() {

        /*--------------------------------------------------*/
        /*  Mobile Menu - mmenu.js
        /*--------------------------------------------------*/
        $(function() {
            function mmenuInit() {
                var wi = $(window).width();
                if (wi <= '1099') {

                    $(".mmenu-init").remove();
                    $("#navigation").clone().addClass("mmenu-init").insertBefore("#navigation").removeAttr('id').removeClass('style-1 style-2')
                        .find('ul, div').removeClass('style-1 style-2 mega-menu mega-menu-content mega-menu-section').removeAttr('id');
                    $(".mmenu-init").find("ul").addClass("mm-listview");
                    $(".mmenu-init").find(".mobile-styles .mm-listview").unwrap();


                    $(".mmenu-init").mmenu({
                        "counters": true
                    }, {
                        // configuration
                        offCanvas: {
                            pageNodetype: "#wrapper"
                        }
                    });

                    var mmenuAPI = $(".mmenu-init").data("mmenu");
                    var $icon = $(".mmenu-trigger .hamburger");

                    $(".mmenu-trigger").on('click', function() {
                        mmenuAPI.open();
                    });

                }
                $(".mm-next").addClass("mm-fullsubopen");
            }
            mmenuInit();
            $(window).resize(function() { mmenuInit(); });
        });


        /*--------------------------------------------------*/
        /*  Sticky Header
        /*--------------------------------------------------*/
        function stickyHeader() {

            $(window).on('scroll load', function() {

                if ($(window).width() < '1099') {
                    $("#header-container").removeClass("cloned");
                }

                if ($(window).width() > '1099') {

                    // CSS adjustment
                    $("#header-container").css({
                        position: 'fixed',
                    });

                    var headerOffset = $("#header-container").height();

                    if ($(window).scrollTop() >= headerOffset) {
                        $("#header-container").addClass('cloned');
                        $(".wrapper-with-transparent-header #header-container").addClass('cloned').removeClass("transparent-header unsticky");
                    } else {
                        $("#header-container").removeClass("cloned");
                        $(".wrapper-with-transparent-header #header-container").addClass('transparent-header unsticky').removeClass("cloned");
                    }

                    // Sticky Logo
                    var transparentLogo = $('#header-container #logo img').attr('data-transparent-logo');
                    var stickyLogo = $('#header-container #logo img').attr('data-sticky-logo');

                    if ($('.wrapper-with-transparent-header #header-container').hasClass('cloned')) {
                        $("#header-container.cloned #logo img").attr("src", stickyLogo);
                    }

                    if ($('.wrapper-with-transparent-header #header-container').hasClass('transparent-header')) {
                        $("#header-container #logo img").attr("src", transparentLogo);
                    }

                    $(window).on('load resize', function() {
                        var headerOffset = $("#header-container").height();
                        $("#wrapper").css({ 'padding-top': headerOffset });
                    });
                }
            });
        }

        // Sticky Header Init
        stickyHeader();


        /*--------------------------------------------------*/
        /*  Transparent Header Spacer Adjustment
        /*--------------------------------------------------*/
        $(window).on('load resize', function() {
            var transparentHeaderHeight = $('.transparent-header').outerHeight();
            $('.transparent-header-spacer').css({
                height: transparentHeaderHeight,
            });
        });


        /*----------------------------------------------------*/
        /*  Back to Top
        /*----------------------------------------------------*/

        // Button
        function backToTop() {
            $('body').append('<div id="backtotop"><a href="#"></a></div>');
        }
        backToTop();

        // Showing Button
        var pxShow = 600; // height on which the button will show
        var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.

        $(window).scroll(function() {
            if ($(window).scrollTop() >= pxShow) {
                $("#backtotop").addClass('visible');
            } else {
                $("#backtotop").removeClass('visible');
            }
        });

        $('#backtotop a').on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, scrollSpeed);
            return false;
        });


        /*--------------------------------------------------*/
        /*  Ripple Effect
        /*--------------------------------------------------*/
        $('.ripple-effect, .ripple-effect-dark').on('click', function(e) {
            var rippleDiv = $('<span class="ripple-overlay">'),
                rippleOffset = $(this).offset(),
                rippleY = e.pageY - rippleOffset.top,
                rippleX = e.pageX - rippleOffset.left;

            rippleDiv.css({
                top: rippleY - (rippleDiv.height() / 2),
                left: rippleX - (rippleDiv.width() / 2),
                // background: $(this).data("ripple-color");
            }).appendTo($(this));

            window.setTimeout(function() {
                rippleDiv.remove();
            }, 800);
        });


        /*--------------------------------------------------*/
        /*  Interactive Effects
        /*--------------------------------------------------*/
        $(".switch, .radio").each(function() {
            var intElem = $(this);
            intElem.on('click', function() {
                intElem.addClass('interactive-effect');
                setTimeout(function() {
                    intElem.removeClass('interactive-effect');
                }, 400);
            });
        });


        /*--------------------------------------------------*/
        /*  Sliding Button Icon
        /*--------------------------------------------------*/
        $(window).on('load', function() {
            $(".button.button-sliding-icon").not(".task-listing .button.button-sliding-icon").each(function() {
                var buttonWidth = $(this).outerWidth() + 30;
                $(this).css('width', buttonWidth);
            });
        });


        /*--------------------------------------------------*/
        /*  Sliding Button Icon
        /*--------------------------------------------------*/
        // $('.bookmark-icon').on('click', function(e){
        // e.preventDefault();
        // 	$(this).toggleClass('bookmarked');
        // });
        //
        // $('.bookmark-button').on('click', function(e){
        // e.preventDefault();
        // 	$(this).toggleClass('bookmarked');
        // });


        /*----------------------------------------------------*/
        /*  Notifications Boxes
        /*----------------------------------------------------*/
        $("a.close").removeAttr("href").on('click', function() {
            function slideFade(elem) {
                var fadeOut = { opacity: 0, transition: 'opacity 0.5s' };
                elem.css(fadeOut).slideUp();
            }
            slideFade($(this).parent());
        });

        /*--------------------------------------------------*/
        /*  Notification Dropdowns
        /*--------------------------------------------------*/
        $(".header-notifications").each(function() {
            var userMenu = $(this);
            var userMenuTrigger = $(this).find('.header-notifications-trigger a');

            $(userMenuTrigger).on('click', function(event) {
                event.preventDefault();

                if ($(this).closest(".header-notifications").is(".active")) {
                    close_user_dropdown();
                } else {
                    close_user_dropdown();
                    userMenu.addClass('active');
                }
            });
        });

        // Closing function
        function close_user_dropdown() {
            $('.header-notifications').removeClass("active");
        }

        // Closes notification dropdown on click outside the conatainer
        var mouse_is_inside = false;

        $(".header-notifications").on("mouseenter", function() {
            mouse_is_inside = true;
        });
        $(".header-notifications").on("mouseleave", function() {
            mouse_is_inside = false;
        });

        $("body").mouseup(function() {
            if (!mouse_is_inside) close_user_dropdown();
        });

        // Close with ESC
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                close_user_dropdown();
            }
        });


        /*--------------------------------------------------*/
        /*  User Status Switch
        /*--------------------------------------------------*/
        if ($('.status-switch label.user-invisible').hasClass('current-status')) {
            $('.status-indicator').addClass('right');
        }

        /*--------------------------------------------------*/
        /*  Full Screen Page Scripts
        /*--------------------------------------------------*/

        // Wrapper Height (window height - header height)
        function wrapperHeight() {
            var headerHeight = $("#header-container").outerHeight();
            var windowHeight = $(window).outerHeight() - headerHeight;
            $('.full-page-content-container, .dashboard-content-container, .dashboard-sidebar-inner, .dashboard-container, .full-page-container').css({ height: windowHeight });
            $('.dashboard-content-inner').css({ 'min-height': windowHeight });
        }

        // Enabling Scrollbar
        function fullPageScrollbar() {
            $(".full-page-sidebar-inner, .dashboard-sidebar-inner").each(function() {

                var headerHeight = $("#header-container").outerHeight();
                var windowHeight = $(window).outerHeight() - headerHeight;
                var sidebarContainerHeight = $(this).find(".sidebar-container, .dashboard-nav-container").outerHeight();

                // Enables scrollbar if sidebar is higher than wrapper
                if (sidebarContainerHeight > windowHeight) {
                    $(this).css({ height: windowHeight });

                } else {
                    $(this).find('.simplebar-track').hide();
                }
            });
        }

        // Init
        $(window).on('load resize', function() {
            wrapperHeight();
            fullPageScrollbar();
        });

        /* Updating by Daniel Ramos */

        // Sliding Sidebar
        $('.enable-filters-button').on('click', function() {
            //$('.full-page-sidebar').toggleClass("enabled-sidebar");
            //$(this).toggleClass("active");

            var windowWidth = $(window).width();

            $(this).toggleClass("active");

            if (windowWidth > 768) {
                $('.full-page-sidebar').toggleClass("enabled-sidebar");
            } else {
                $('.main-filter-widget-lists').toggleClass('enabled-filter-lists');
                $('.sidebar-search-button-container').toggleClass('enabled-search-filter');
            }

            $('.filter-button-tooltip').removeClass('tooltip-visible');

        });
        /* Updating ended by Daniel Ramos */


        /*  Enable Filters Button Tooltip */
        $(window).on('load', function() {
            $('.filter-button-tooltip').css({
                    left: $('.enable-filters-button').outerWidth() + 48
                })
                .addClass('tooltip-visible');
        });

        // Avatar Switcher
        function avatarSwitcher() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            };

            $(".file-upload").on('change', function() {
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        }
        avatarSwitcher();


        /*----------------------------------------------------*/
        /* Dashboard Scripts
        /*----------------------------------------------------*/

        // Dashboard Nav Submenus
        $('.dashboard-nav ul li a').on('click', function(e) {
            if ($(this).closest("li").children("ul").length) {
                if ($(this).closest("li").is(".active-submenu")) {
                    $('.dashboard-nav ul li').removeClass('active-submenu');
                } else {
                    $('.dashboard-nav ul li').removeClass('active-submenu');
                    $(this).parent('li').addClass('active-submenu');
                }
                e.preventDefault();
            }
        });


        // Responsive Dashbaord Nav Trigger
        $('.dashboard-responsive-nav-trigger').on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');

            var dashboardNavContainer = $('body').find(".dashboard-nav");

            if ($(this).hasClass('active')) {
                $(dashboardNavContainer).addClass('active');
            } else {
                $(dashboardNavContainer).removeClass('active');
            }

            $('.dashboard-responsive-nav-trigger .hamburger').toggleClass('is-active');

        });

        // Fun Facts
        function funFacts() {
            /*jslint bitwise: true */
            function hexToRgbA(hex) {
                var c;
                if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                    c = hex.substring(1).split('');
                    if (c.length == 3) {
                        c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                    }
                    c = '0x' + c.join('');
                    return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',0.07)';
                }
            }

            $(".fun-fact").each(function() {
                var factColor = $(this).attr('data-fun-fact-color');

                if (factColor !== undefined) {
                    $(this).find(".fun-fact-icon").css('background-color', hexToRgbA(factColor));
                    $(this).find("i").css('color', factColor);
                }
            });

        }
        funFacts();


        // Notes & Messages Scrollbar
        $(window).on('load resize', function() {
            var winwidth = $(window).width();
            if (winwidth > 1199) {

                // Notes
                $('.row').each(function() {
                    var mbh = $(this).find('.main-box-in-row').outerHeight();
                    var cbh = $(this).find('.child-box-in-row').outerHeight();
                    if (mbh < cbh) {
                        var headerBoxHeight = $(this).find('.child-box-in-row .headline').outerHeight();
                        var mainBoxHeight = $(this).find('.main-box-in-row').outerHeight() - headerBoxHeight + 39;

                        $(this).find('.child-box-in-row .content')
                            .wrap('<div class="dashboard-box-scrollbar" style="max-height: ' + mainBoxHeight + 'px" data-simplebar></div>');
                    }
                });

                // Messages Sidebar
                // var messagesList = $(".messages-inbox").outerHeight();
                // var messageWrap = $(".message-content").outerHeight();
                // if ( messagesList > messagesWrap) {
                // 	$(messagesList).css({
                // 		'max-height': messageWrap,
                // 	});
                // }
            }
        });

        // Mobile Adjustment for Single Button Icon in Dashboard Box
        $('.buttons-to-right').each(function() {
            var btr = $(this).width();
            if (btr < 36) {
                $(this).addClass('single-right-button');
            }
        });

        // Small Footer Adjustment
        $(window).on('load resize', function() {
            var smallFooterHeight = $('.small-footer').outerHeight();
            $('.dashboard-footer-spacer').css({
                'padding-top': smallFooterHeight + 45
            });
        });


        // Auto Resizing Message Input Field
        /* global jQuery */
        jQuery.each(jQuery('textarea[data-autoresize]'), function() {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function(el) {
                jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
        });


        /*--------------------------------------------------*/
        /*  Star Rating
        /*--------------------------------------------------*/
        function starRating(ratingElem) {

            $(ratingElem).each(function() {

                var dataRating = $(this).attr('data-rating');

                // Rating Stars Output
                function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
                    return ('' +
                        '<span class="' + firstStar + '"></span>' +
                        '<span class="' + secondStar + '"></span>' +
                        '<span class="' + thirdStar + '"></span>' +
                        '<span class="' + fourthStar + '"></span>' +
                        '<span class="' + fifthStar + '"></span>');
                }

                var fiveStars = starsOutput('star', 'star', 'star', 'star', 'star');

                var fourHalfStars = starsOutput('star', 'star', 'star', 'star', 'star half');
                var fourStars = starsOutput('star', 'star', 'star', 'star', 'star empty');

                var threeHalfStars = starsOutput('star', 'star', 'star', 'star half', 'star empty');
                var threeStars = starsOutput('star', 'star', 'star', 'star empty', 'star empty');

                var twoHalfStars = starsOutput('star', 'star', 'star half', 'star empty', 'star empty');
                var twoStars = starsOutput('star', 'star', 'star empty', 'star empty', 'star empty');

                var oneHalfStar = starsOutput('star', 'star half', 'star empty', 'star empty', 'star empty');
                var oneStar = starsOutput('star', 'star empty', 'star empty', 'star empty', 'star empty');

                var halfStar = starsOutput('star half', 'star empty', 'star empty', 'star empty', 'star empty');
                var zeroStar = starsOutput('star empty', 'star empty', 'star empty', 'star empty', 'star empty');

                // Rules
                if (dataRating >= 4.75) {
                    $(this).append(fiveStars);
                } else if (dataRating >= 4.25) {
                    $(this).append(fourHalfStars);
                } else if (dataRating >= 3.75) {
                    $(this).append(fourStars);
                } else if (dataRating >= 3.25) {
                    $(this).append(threeHalfStars);
                } else if (dataRating >= 2.75) {
                    $(this).append(threeStars);
                } else if (dataRating >= 2.25) {
                    $(this).append(twoHalfStars);
                } else if (dataRating >= 1.75) {
                    $(this).append(twoStars);
                } else if (dataRating >= 1.25) {
                    $(this).append(oneHalfStar);
                } else if (dataRating >= 0.75) {
                    $(this).append(oneStar);
                } else if (dataRating >= 0.25) {
                    $(this).append(halfStar);
                } else {
                    $(this).append(zeroStar);
                }
            });

        }
        starRating('.star-rating');


        /*--------------------------------------------------*/
        /*  Enabling Scrollbar in User Menu
        /*--------------------------------------------------*/
        function userMenuScrollbar() {
            $(".header-notifications-scroll").each(function() {
                var scrollContainerList = $(this).find('ul');
                var itemsCount = scrollContainerList.children("li").length;
                var notificationItems;

                // Determines how many items are displayed based on items height
                /* jshint shadow:true */
                if (scrollContainerList.children("li").outerHeight() > 140) {
                    var notificationItems = 2;
                } else {
                    var notificationItems = 3;
                }


                // Enables scrollbar if more than 2 items
                if (itemsCount > notificationItems) {

                    var listHeight = 0;

                    $(scrollContainerList).find('li:lt(' + notificationItems + ')').each(function() {
                        listHeight += $(this).height();
                    });

                    $(this).css({ height: listHeight });

                } else {
                    $(this).css({ height: 'auto' });
                    $(this).find('.simplebar-track').hide();
                }
            });
        }

        // Init
        userMenuScrollbar();


        /*--------------------------------------------------*/
        /*  Tippy JS
        /*--------------------------------------------------*/
        /* global tippy */
        tippy('[data-tippy-placement]', {
            delay: 100,
            arrow: true,
            arrowType: 'sharp',
            size: 'regular',
            duration: 200,

            // 'shift-toward', 'fade', 'scale', 'perspective'
            animation: 'shift-away',

            animateFill: true,
            theme: 'dark',

            // How far the tooltip is from its reference element in pixels
            distance: 10,

        });


        /*----------------------------------------------------*/
        /*	Accordion @Lewis Briffa
        /*----------------------------------------------------*/
        var accordion = (function() {

            var $accordion = $('.js-accordion');
            var $accordion_header = $accordion.find('.js-accordion-header');

            // default settings
            var settings = {
                // animation speed
                speed: 400,

                // close all other accordion items if true
                oneOpen: false
            };

            return {
                // pass configurable object literal
                init: function($settings) {
                    $accordion_header.on('click', function() {
                        accordion.toggle($(this));
                    });

                    $.extend(settings, $settings);

                    // ensure only one accordion is active if oneOpen is true
                    if (settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                        $('.js-accordion-item.active:not(:first)').removeClass('active');
                    }

                    // reveal the active accordion bodies
                    $('.js-accordion-item.active').find('> .js-accordion-body').show();
                },
                toggle: function($this) {

                    if (settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                        $this.closest('.js-accordion')
                            .find('> .js-accordion-item')
                            .removeClass('active')
                            .find('.js-accordion-body')
                            .slideUp();
                    }

                    // show/hide the clicked accordion item
                    $this.closest('.js-accordion-item').toggleClass('active');
                    $this.next().stop().slideToggle(settings.speed);
                }
            };
        })();

        $(document).ready(function() {
            accordion.init({ speed: 300, oneOpen: true });
        });


        /*--------------------------------------------------*/
        /*  Tabs
        /*--------------------------------------------------*/
        $(document).ready(function() {
            if ($(".tabs")[0]) {
                $('.tabs').each(function() {

                    var thisTab = $(this);

                    // Intial Border Position
                    var activePos = thisTab.find('.tabs-header .active').position();

                    function changePos() {

                        // Update Position
                        activePos = thisTab.find('.tabs-header .active').position();

                        // Change Position & Width
                        thisTab.find('.tab-hover').stop().css({
                            left: activePos.left,
                            width: thisTab.find('.tabs-header .active').width()
                        });
                    }

                    changePos();

                    // Intial Tab Height
                    var tabHeight = thisTab.find('.tab.active').outerHeight();

                    // Animate Tab Height
                    function animateTabHeight() {

                        // Update Tab Height
                        tabHeight = thisTab.find('.tab.active').outerHeight();

                        // Animate Height
                        thisTab.find('.tabs-content').stop().css({
                            height: tabHeight + 'px'
                        });
                    }

                    animateTabHeight();

                    // Change Tab
                    function changeTab() {
                        var getTabId = thisTab.find('.tabs-header .active a').attr('data-tab-id');

                        // Remove Active State
                        thisTab.find('.tab').stop().fadeOut(300, function() {
                            // Remove Class
                            $(this).removeClass('active');
                        }).hide();

                        thisTab.find('.tab[data-tab-id=' + getTabId + ']').stop().fadeIn(300, function() {
                            // Add Class
                            $(this).addClass('active');

                            // Animate Height
                            animateTabHeight();
                        });
                    }

                    // Tabs
                    thisTab.find('.tabs-header a').on('click', function(e) {
                        e.preventDefault();
                        if ($(this).text() === 'taskapron') {
                            document.location.href = "/";
                        }
                        // Tab Id
                        var tabId = $(this).attr('data-tab-id');

                        // Remove Active State
                        thisTab.find('.tabs-header a').stop().parent().removeClass('active');

                        // Add Active State
                        $(this).stop().parent().addClass('active');

                        changePos();

                        // Update Current Itm
                        tabCurrentItem = tabItems.filter('.active');

                        // Remove Active State
                        thisTab.find('.tab').stop().fadeOut(300, function() {
                            // Remove Class
                            $(this).removeClass('active');
                        }).hide();

                        // Add Active State
                        thisTab.find('.tab[data-tab-id="' + tabId + '"]').stop().fadeIn(300, function() {
                            // Add Class
                            $(this).addClass('active');

                            // Animate Height
                            animateTabHeight();
                        });
                    });

                    // Tab Items
                    var tabItems = thisTab.find('.tabs-header ul li');

                    // Tab Current Item
                    var tabCurrentItem = tabItems.filter('.active');

                    // Next Button
                    thisTab.find('.tab-next').on('click', function(e) {
                        e.preventDefault();

                        var nextItem = tabCurrentItem.next();

                        tabCurrentItem.removeClass('active');

                        if (nextItem.length) {
                            tabCurrentItem = nextItem.addClass('active');
                        } else {
                            tabCurrentItem = tabItems.first().addClass('active');
                        }

                        changePos();
                        changeTab();
                    });

                    // Prev Button
                    thisTab.find('.tab-prev').on('click', function(e) {
                        e.preventDefault();

                        var prevItem = tabCurrentItem.prev();

                        tabCurrentItem.removeClass('active');

                        if (prevItem.length) {
                            tabCurrentItem = prevItem.addClass('active');
                        } else {
                            tabCurrentItem = tabItems.last().addClass('active');
                        }

                        changePos();
                        changeTab();
                    });
                });
            }
        });




        /*--------------------------------------------------*/
        /*  Bootstrap Range Slider
        /*--------------------------------------------------*/

        // Thousand Separator
        function ThousandSeparator(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        // Bidding Slider Average Value
        var avgValue = (parseInt($('.bidding-slider').attr("data-slider-min")) + parseInt($('.bidding-slider').attr("data-slider-max"))) / 2;
        if ($('.bidding-slider').data("slider-value") === 'auto') {
            $('.bidding-slider').attr({ 'data-slider-value': avgValue });
        }

        // Bidding Slider Init
        $('.bidding-slider').slider();

        $(".bidding-slider").on("slide", function(slideEvt) {
            $("#biddingVal").text(ThousandSeparator(parseInt(slideEvt.value)));
        });
        $("#biddingVal").text(ThousandSeparator(parseInt($('.bidding-slider').val())));


        // Default Bootstrap Range Slider
        var currencyAttr = $(".range-slider").attr('data-slider-currency');

        $(".range-slider").slider({
            formatter: function(value) {
                return currencyAttr + ThousandSeparator(parseInt(value[0])) + " - " + currencyAttr + ThousandSeparator(parseInt(value[1]));
            }
        });

        $(".range-slider-single").slider();


        /*----------------------------------------------------*/
        /*  Payment Accordion
        /*----------------------------------------------------*/
        var radios = document.querySelectorAll('.payment-tab-trigger > input');

        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', expandAccordion);
        }

        function expandAccordion(event) {
            /* jshint validthis: true */
            var tabber = this.closest('.payment');
            var allTabs = tabber.querySelectorAll('.payment-tab');
            for (var i = 0; i < allTabs.length; i++) {
                allTabs[i].classList.remove('payment-tab-active');
            }
            event.target.parentNode.parentNode.classList.add('payment-tab-active');
        }

        $('.billing-cycle-radios').on("click", function() {
            if ($('.billed-yearly-radio input').is(':checked')) { $('.pricing-plans-container').addClass('billed-yearly'); }
            if ($('.billed-monthly-radio input').is(':checked')) { $('.pricing-plans-container').removeClass('billed-yearly'); }
        });


        /*--------------------------------------------------*/
        /*  Quantity Buttons
        /*--------------------------------------------------*/
        function qtySum() {
            var arr = document.getElementsByName('qtyInput');
            var tot = 0;
            for (var i = 0; i < arr.length; i++) {
                if (parseInt(arr[i].value))
                    tot += parseInt(arr[i].value);
            }
        }
        qtySum();

        $(".qtyDec, .qtyInc").on("click", function() {

            var $button = $(this);
            var oldValue = $button.parent().find("input").val();

            if ($button.hasClass('qtyInc')) {
                $button.parent().find("input").val(parseFloat(oldValue) + 1);
            } else {
                if (oldValue > 1) {
                    $button.parent().find("input").val(parseFloat(oldValue) - 1);
                } else {
                    $button.parent().find("input").val(1);
                }
            }

            qtySum();
            $(".qtyTotal").addClass("rotate-x");

        });


        /*----------------------------------------------------*/
        /*  Inline CSS replacement for backgrounds
        /*----------------------------------------------------*/
        function inlineBG() {

            // Common Inline CSS
            $(".single-page-header, .intro-banner").each(function() {
                var attrImageBG = $(this).attr('data-background-image');

                if (attrImageBG !== undefined) {
                    $(this).append('<div class="background-image-container"></div>');
                    $('.background-image-container').css('background-image', 'url(' + attrImageBG + ')');
                }
            });

        }
        inlineBG();

        // Fix for intro banner with label
        $(".intro-search-field").each(function() {
            var bannerLabel = $(this).children("label").length;
            if (bannerLabel > 0) {
                $(this).addClass("with-label");
            }
        });

        // Photo Boxes
        $(".photo-box, .photo-section, .video-container").each(function() {
            var photoBox = $(this);
            var photoBoxBG = $(this).attr('data-background-image');

            if (photoBox !== undefined) {
                $(this).css('background-image', 'url(' + photoBoxBG + ')');
            }
        });


        /*----------------------------------------------------*/
        /*  Share URL and Buttons
        /*----------------------------------------------------*/
        /* global ClipboardJS */
        $('.copy-url input').val(window.location.href);
        new ClipboardJS('.copy-url-button');

        $(".share-buttons-icons a").each(function() {
            var buttonBG = $(this).attr("data-button-color");
            if (buttonBG !== undefined) {
                $(this).css('background-color', buttonBG);
            }
        });


        /*----------------------------------------------------*/
        /*  Tabs
        /*----------------------------------------------------*/
        var $tabsNav = $('.popup-tabs-nav'),
            $tabsNavLis = $tabsNav.children('li');

        $tabsNav.each(function() {
            var $this = $(this);

            $this.next().children('.popup-tab-content').stop(true, true).hide().first().show();
            $this.children('li').first().addClass('active').stop(true, true).show();
        });

        $tabsNavLis.on('click', function(e) {
            var $this = $(this);

            $this.siblings().removeClass('active').end().addClass('active');

            $this.parent().next().children('.popup-tab-content').stop(true, true).hide()
                .siblings($this.find('a').attr('href')).fadeIn();

            e.preventDefault();
        });

        var hash = window.location.hash;
        var anchor = $('.tabs-nav a[href="' + hash + '"]');
        if (anchor.length === 0) {
            $(".popup-tabs-nav li:first").addClass("active").show(); //Activate first tab
            $(".popup-tab-content:first").show(); //Show first tab content
        } else {
            anchor.parent('li').click();
        }

        // Link to Register Tab
        $('.register-tab').on('click', function(event) {
            event.preventDefault();
            $(".popup-tab-content").hide();
            $("#register.popup-tab-content").show();
            $("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click();
        });

        // Disable tabs if there's only one tab
        $('.popup-tabs-nav').each(function() {
            var listCount = $(this).find("li").length;
            if (listCount < 2) {
                $(this).css({
                    'pointer-events': 'none'
                });
            }
        });


        /*----------------------------------------------------*/
        /*  Indicator Bar
        /*----------------------------------------------------*/
        $('.indicator-bar').each(function() {
            var indicatorLenght = $(this).attr('data-indicator-percentage');
            $(this).find("span").css({
                width: indicatorLenght + "%"
            });
        });


        /*----------------------------------------------------*/
        /*  Custom Upload Button
        /*----------------------------------------------------*/

        var uploadButton = {
            $button: $('.uploadButton-input'),
            $nameField: $('.uploadButton-file-name')
        };

        uploadButton.$button.on('change', function() {
            _populateFileField($(this));
        });

        function _populateFileField($button) {
            var selectedFile = [];
            for (var i = 0; i < $button.get(0).files.length; ++i) {
                selectedFile.push($button.get(0).files[i].name + '<br>');
            }
            uploadButton.$nameField.html(selectedFile);
        }


        /*----------------------------------------------------*/
        /*  Slick Carousel
        /*----------------------------------------------------*/
        $('.default-slick-carousel').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1292,
                    settings: {
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });


        $('.testimonial-carousel').slick({
            centerMode: true,
            centerPadding: '30%',
            slidesToShow: 1,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1600,
                    settings: {
                        centerPadding: '21%',
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        centerPadding: '15%',
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        centerPadding: '5%',
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });


        $('.logo-carousel').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            responsive: [{
                    breakpoint: 1365,
                    settings: {
                        slidesToShow: 5,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });

        $('.blog-carousel').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            responsive: [{
                    breakpoint: 1365,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false
                    }
                }
            ]
        });

        /*----------------------------------------------------*/
        /*  Magnific Popup
        /*----------------------------------------------------*/
        $('.mfp-gallery-container').each(function() { // the containers for all your galleries

            $(this).magnificPopup({
                type: 'image',
                delegate: 'a.mfp-gallery',

                fixedContentPos: true,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: false,
                preloader: true,

                removalDelay: 0,
                mainClass: 'mfp-fade',

                gallery: { enabled: true, tCounter: '' }
            });
        });

        /*$('.popup-with-zoom-anim').magnificPopup({
		 type: 'inline',

		 fixedContentPos: false,
		 fixedBgPos: true,

		 overflowY: 'auto',

		 closeBtnInside: true,
		 preloader: false,

		 midClick: true,
		 removalDelay: 300,
		 mainClass: 'my-mfp-zoom-in'
	});
*/
        $('.mfp-image').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-fade',
            image: {
                verticalFit: true
            }
        });

        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
        });



        // ------------------ End Document ------------------ //
    });

})(this.jQuery);



(function() {
    $('.material').find('input, textarea').each(function() {
        $(this).on('change', function() {
            $this = $(this);
            if (this.value !== "") {
                $this.addClass('filled');
            } else {
                $this.removeClass('filled');
            }
        });
    });
})();


jQuery.fn.extend({
    autoHeight: function() {
        function autoHeight_(element) {
            return jQuery(element)
                .css({ 'height': 'auto', 'overflow-y': 'hidden' })
                .height(element.scrollHeight);
        }
        return this.each(function() {
            autoHeight_(this).on('input', function() {
                autoHeight_(this);
            });
        });
    }
});

$('textarea').autoHeight();

$(function() {
    $(".focused").focus();
});


function autosize(textarea) {
    $(textarea).height(1); // temporarily shrink textarea so that scrollHeight returns content height when content does not fill textarea
    $(textarea).height($(textarea).prop("scrollHeight"));
}

$(document).ready(function() {
    $(document).on("input", "textarea", function() {
        autosize(this);
    });
    $("textarea").each(function() {
        autosize(this);
    });
});

var anyFieldReceivedFocus = false;

function fieldReceivedFocus() {
    anyFieldReceivedFocus = true;
}

function focusFirstField() {
    if (!anyFieldReceivedFocus) {
        $(".focused").focus();
    }
}





$(document).ready(function() {


    // Intial Border Position
    var activePos = $('.dbtabs-header .active').position();

    // Change Position
    function changePos() {

        // Update Position
        activePos = $('.dbtabs-header .active').position();

        // Change Position & Width
        $('.border').stop().css({
            left: activePos.left,
            width: $('.dbtabs-header .active').width()
        });
    }

    changePos();

    // Intial Tab Height
    var tabHeight = $('.tab.active').height();

    // Animate Tab Height
    function animateTabHeight() {

        // Update Tab Height
        tabHeight = $('.tab.active').height();

        // Animate Height
        $('.dbtabs-content').stop().css({
            height: tabHeight + 'px'
        });
    }

    animateTabHeight();

    // Change Tab
    function changeTab() {
        var getTabId = $('.dbtabs-header .active a').attr('tab-id');

        // Remove Active State
        $('.tab').stop().fadeOut(300, function() {
            // Remove Class
            $(this).removeClass('active');
        }).hide();

        $('.tab[tab-id=' + getTabId + ']').stop().fadeIn(300, function() {
            // Add Class
            $(this).addClass('active');

            // Animate Height
            animateTabHeight();
        });
    }

    // Tabs
    $('.dbtabs-header a').on('click', function(e) {
        e.preventDefault();

        // Tab Id
        var tabId = $(this).attr('tab-id');

        // Remove Active State
        $('.dbtabs-header a').stop().parent().removeClass('active');

        // Add Active State
        $(this).stop().parent().addClass('active');

        changePos();

        // Update Current Itm
        tabCurrentItem = tabItems.filter('.active');

        // Remove Active State
        $('.tab').stop().fadeOut(300, function() {
            // Remove Class
            $(this).removeClass('active');
        }).hide();

        // Add Active State
        $('.tab[tab-id="' + tabId + '"]').stop().fadeIn(300, function() {
            // Add Class
            $(this).addClass('active');

            // Animate Height
            animateTabHeight();
        });
    });

    // Tab Items
    var tabItems = $('.dbtabs-header ul li');

    // Tab Current Item
    var tabCurrentItem = tabItems.filter('.active');

    // Next Button
    $('#next').on('click', function(e) {
        e.preventDefault();

        var nextItem = tabCurrentItem.next();

        tabCurrentItem.removeClass('active');

        if (nextItem.length) {
            tabCurrentItem = nextItem.addClass('active');
        } else {
            tabCurrentItem = tabItems.first().addClass('active');
        }

        changePos();
        changeTab();
    });

    // Prev Button
    $('#prev').on('click', function(e) {
        e.preventDefault();

        var prevItem = tabCurrentItem.prev();

        tabCurrentItem.removeClass('active');

        if (prevItem.length) {
            tabCurrentItem = prevItem.addClass('active');
        } else {
            tabCurrentItem = tabItems.last().addClass('active');
        }

        changePos();
        changeTab();
    });

    // Ripple
    $('[ripple]').on('click', function(e) {
        var rippleDiv = $('<div class="ripple" />'),
            rippleOffset = $(this).offset(),
            rippleY = e.pageY - rippleOffset.top,
            rippleX = e.pageX - rippleOffset.left,
            ripple = $('.ripple');

        rippleDiv.css({
            top: rippleY - (ripple.height() / 2),
            left: rippleX - (ripple.width() / 2),
            background: $(this).attr("ripple-color")
        }).appendTo($(this));

        window.setTimeout(function() {
            rippleDiv.remove();
        }, 1500);
    });









    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            // Information about the dataset
            datasets: [{
                label: "Views",
                backgroundColor: 'rgba(42,65,232,0.08)',
                borderColor: '#2a41e8',
                borderWidth: "3",
                data: [196, 132, 215, 362, 210, 252],
                pointRadius: 5,
                pointHoverRadius: 5,
                pointHitRadius: 10,
                pointBackgroundColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointBorderWidth: "2",
            }]
        },

        // Configuration options
        options: {

            layout: {
                padding: 10,
            },

            legend: { display: false },
            title: { display: false },

            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: false
                    },
                    gridLines: {
                        borderDash: [6, 10],
                        color: "#d8d8d8",
                        lineWidth: 1,
                    },
                }],
                xAxes: [{
                    scaleLabel: { display: false },
                    gridLines: { display: false },
                }],
            },

            tooltips: {
                backgroundColor: '#333',
                titleFontSize: 13,
                titleFontColor: '#fff',
                bodyFontColor: '#fff',
                bodyFontSize: 13,
                displayColors: false,
                xPadding: 10,
                yPadding: 10,
                intersect: false
            }
        },


    });

    var draw = Chart.controllers.doughnut.prototype.draw;
    Chart.controllers.doughnut = Chart.controllers.doughnut.extend({
        draw: function() {
            draw.apply(this, arguments);
            let ctx = this.chart.chart.ctx;
            let _fill = ctx.fill;
            ctx.fill = function() {
                ctx.save();
                ctx.shadowColor = '#0000000f';
                ctx.shadowBlur = 13;
                ctx.shadowOpacity = 0;
                ctx.shadowOffsetX = 2;
                ctx.shadowOffsetY = 2;
                _fill.apply(this, arguments)
                ctx.restore();
            }
        }
    });



















    /* !
     * tingle.js
     * @author  robin_parisi
     * @version 0.15.0
     * @url
     */

    /* global define,module*/
    (function(root, factory) {
        if (typeof define === 'function' && define.amd) {
            define(factory)
        } else if (typeof exports === 'object') {
            module.exports = factory()
        } else {
            root.tingle = factory()
        }
    }(this, function() {

        /* ----------------------------------------------------------- */
        /* == modal */
        /* ----------------------------------------------------------- */

        var isBusy = false

        function Modal(options) {
            var defaults = {
                onClose: null,
                onOpen: null,
                beforeOpen: null,
                beforeClose: null,
                stickyFooter: false,
                footer: false,
                cssClass: [],
                closeLabel: 'Close',
                closeMethods: ['overlay', 'button', 'escape']
            }

            // extends config
            this.opts = extend({}, defaults, options)

            // init modal
            this.init()
        }

        Modal.prototype.init = function() {
            if (this.modal) {
                return
            }

            _build.call(this)
            _bindEvents.call(this)

            // insert modal in dom
            document.body.insertBefore(this.modal, document.body.firstChild)

            if (this.opts.footer) {
                this.addFooter()
            }

            return this
        }

        Modal.prototype._busy = function(state) {
            isBusy = state
        }

        Modal.prototype._isBusy = function() {
            return isBusy
        }

        Modal.prototype.destroy = function() {
            if (this.modal === null) {
                return
            }

            // restore scrolling
            if (this.isOpen()) {
                this.close(true)
            }

            // unbind all events
            _unbindEvents.call(this)

            // remove modal from dom
            this.modal.parentNode.removeChild(this.modal)

            this.modal = null
        }

        Modal.prototype.isOpen = function() {
            return !!this.modal.classList.contains('tingle-modal--visible')
        }

        Modal.prototype.open = function() {
            if (this._isBusy()) return
            this._busy(true)

            var self = this

            // before open callback
            if (typeof self.opts.beforeOpen === 'function') {
                self.opts.beforeOpen()
            }

            if (this.modal.style.removeProperty) {
                this.modal.style.removeProperty('display')
            } else {
                this.modal.style.removeAttribute('display')
            }

            // prevent double scroll
            this._scrollPosition = window.pageYOffset
            document.body.classList.add('tingle-enabled')
            document.body.style.top = -this._scrollPosition + 'px'

            // sticky footer
            this.setStickyFooter(this.opts.stickyFooter)

            // show modal
            this.modal.classList.add('tingle-modal--visible')

            // onOpen callback
            if (typeof self.opts.onOpen === 'function') {
                self.opts.onOpen.call(self)
            }

            self._busy(false)

            // check if modal is bigger than screen height
            this.checkOverflow()

            return this
        }

        Modal.prototype.close = function(force) {
            if (this._isBusy()) return
            this._busy(true)
            force = force || false

            //  before close
            if (typeof this.opts.beforeClose === 'function') {
                var close = this.opts.beforeClose.call(this)
                if (!close) {
                    this._busy(false)
                    return
                }
            }

            document.body.classList.remove('tingle-enabled')
            window.scrollTo(0, this._scrollPosition)
            document.body.style.top = null

            this.modal.classList.remove('tingle-modal--visible')

            // using similar setup as onOpen
            var self = this

            self.modal.style.display = 'none'

            // onClose callback
            if (typeof self.opts.onClose === 'function') {
                self.opts.onClose.call(this)
            }

            // release modal
            self._busy(false)

        }

        Modal.prototype.setContent = function(content) {
            // check type of content : String or Node
            if (typeof content === 'string') {
                this.modalBoxContent.innerHTML = content
            } else {
                this.modalBoxContent.innerHTML = ''
                this.modalBoxContent.appendChild(content)
            }

            if (this.isOpen()) {
                // check if modal is bigger than screen height
                this.checkOverflow()
            }

            return this
        }

        Modal.prototype.getContent = function() {
            return this.modalBoxContent
        }

        Modal.prototype.addFooter = function() {
            // add footer to modal
            _buildFooter.call(this)

            return this
        }

        Modal.prototype.setFooterContent = function(content) {
            // set footer content
            this.modalBoxFooter.innerHTML = content

            return this
        }

        Modal.prototype.getFooterContent = function() {
            return this.modalBoxFooter
        }

        Modal.prototype.setStickyFooter = function(isSticky) {
            // if the modal is smaller than the viewport height, we don't need sticky
            if (!this.isOverflow()) {
                isSticky = false
            }

            if (isSticky) {
                if (this.modalBox.contains(this.modalBoxFooter)) {
                    this.modalBox.removeChild(this.modalBoxFooter)
                    this.modal.appendChild(this.modalBoxFooter)
                    this.modalBoxFooter.classList.add('tingle-modal-box__footer--sticky')
                    _recalculateFooterPosition.call(this)
                    this.modalBoxContent.style['padding-bottom'] = this.modalBoxFooter.clientHeight + 20 + 'px'
                }
            } else if (this.modalBoxFooter) {
                if (!this.modalBox.contains(this.modalBoxFooter)) {
                    this.modal.removeChild(this.modalBoxFooter)
                    this.modalBox.appendChild(this.modalBoxFooter)
                    this.modalBoxFooter.style.width = 'auto'
                    this.modalBoxFooter.style.left = ''
                    this.modalBoxContent.style['padding-bottom'] = ''
                    this.modalBoxFooter.classList.remove('tingle-modal-box__footer--sticky')
                }
            }

            return this
        }


        Modal.prototype.addFooterBtn = function(label, cssClass, callback) {
            var btn = document.createElement('button')

            // set label
            btn.innerHTML = label

            // bind callback
            btn.addEventListener('click', callback)

            if (typeof cssClass === 'string' && cssClass.length) {
                // add classes to btn
                cssClass.split(' ').forEach(function(item) {
                    btn.classList.add(item)
                })
            }

            this.modalBoxFooter.appendChild(btn)

            return btn
        }

        Modal.prototype.resize = function() {
            // eslint-disable-next-line no-console
            console.warn('Resize is deprecated and will be removed in version 1.0')
        }

        Modal.prototype.isOverflow = function() {
            var viewportHeight = window.innerHeight
            var modalHeight = this.modalBox.clientHeight

            return modalHeight >= viewportHeight
        }

        Modal.prototype.checkOverflow = function() {
            // only if the modal is currently shown
            if (this.modal.classList.contains('tingle-modal--visible')) {
                if (this.isOverflow()) {
                    this.modal.classList.add('tingle-modal--overflow')
                } else {
                    this.modal.classList.remove('tingle-modal--overflow')
                }

                // tODO: remove offset
                // _offset.call(this);
                if (!this.isOverflow() && this.opts.stickyFooter) {
                    this.setStickyFooter(false)
                } else if (this.isOverflow() && this.opts.stickyFooter) {
                    _recalculateFooterPosition.call(this)
                    this.setStickyFooter(true)
                }
            }
        }


        /* ----------------------------------------------------------- */
        /* == private methods */
        /* ----------------------------------------------------------- */

        function closeIcon() {
            return '<svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg"><path d="M.3 9.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3L5 6.4l3.3 3.3c.2.2.5.3.7.3.2 0 .5-.1.7-.3.4-.4.4-1 0-1.4L6.4 5l3.3-3.3c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0L5 3.6 1.7.3C1.3-.1.7-.1.3.3c-.4.4-.4 1 0 1.4L3.6 5 .3 8.3c-.4.4-.4 1 0 1.4z" fill="#000" fill-rule="nonzero"/></svg>'
        }

        function _recalculateFooterPosition() {
            if (!this.modalBoxFooter) {
                return
            }
            this.modalBoxFooter.style.width = this.modalBox.clientWidth + 'px'
            this.modalBoxFooter.style.left = this.modalBox.offsetLeft + 'px'
        }

        function _build() {

            // wrapper
            this.modal = document.createElement('div')
            this.modal.classList.add('tingle-modal')

            // remove cusor if no overlay close method
            if (this.opts.closeMethods.length === 0 || this.opts.closeMethods.indexOf('overlay') === -1) {
                this.modal.classList.add('tingle-modal--noOverlayClose')
            }

            this.modal.style.display = 'none'

            // custom class
            this.opts.cssClass.forEach(function(item) {
                if (typeof item === 'string') {
                    this.modal.classList.add(item)
                }
            }, this)

            // close btn
            if (this.opts.closeMethods.indexOf('button') !== -1) {
                this.modalCloseBtn = document.createElement('button')
                this.modalCloseBtn.type = 'button'
                this.modalCloseBtn.classList.add('tingle-modal__close')

                this.modalCloseBtnIcon = document.createElement('span')
                this.modalCloseBtnIcon.classList.add('tingle-modal__closeIcon')
                this.modalCloseBtnIcon.innerHTML = closeIcon()

                this.modalCloseBtnLabel = document.createElement('span')
                this.modalCloseBtnLabel.classList.add('tingle-modal__closeLabel')
                this.modalCloseBtnLabel.innerHTML = this.opts.closeLabel

                this.modalCloseBtn.appendChild(this.modalCloseBtnIcon)
                this.modalCloseBtn.appendChild(this.modalCloseBtnLabel)
            }

            // modal
            this.modalBox = document.createElement('div')
            this.modalBox.classList.add('tingle-modal-box')

            // modal box content
            this.modalBoxContent = document.createElement('div')
            this.modalBoxContent.classList.add('tingle-modal-box__content')

            this.modalBox.appendChild(this.modalBoxContent)

            if (this.opts.closeMethods.indexOf('button') !== -1) {
                this.modal.appendChild(this.modalCloseBtn)
            }

            this.modal.appendChild(this.modalBox)

        }

        function _buildFooter() {
            this.modalBoxFooter = document.createElement('div')
            this.modalBoxFooter.classList.add('tingle-modal-box__footer')
            this.modalBox.appendChild(this.modalBoxFooter)
        }

        function _bindEvents() {

            this._events = {
                clickCloseBtn: this.close.bind(this),
                clickOverlay: _handleClickOutside.bind(this),
                resize: this.checkOverflow.bind(this),
                keyboardNav: _handleKeyboardNav.bind(this)
            }

            if (this.opts.closeMethods.indexOf('button') !== -1) {
                this.modalCloseBtn.addEventListener('click', this._events.clickCloseBtn)
            }

            this.modal.addEventListener('mousedown', this._events.clickOverlay)
            window.addEventListener('resize', this._events.resize)
            document.addEventListener('keydown', this._events.keyboardNav)
        }

        function _handleKeyboardNav(event) {
            // escape key
            if (this.opts.closeMethods.indexOf('escape') !== -1 && event.which === 27 && this.isOpen()) {
                this.close()
            }
        }

        function _handleClickOutside(event) {
            // if click is outside the modal
            if (this.opts.closeMethods.indexOf('overlay') !== -1 && !_findAncestor(event.target, 'tingle-modal') &&
                event.clientX < this.modal.clientWidth) {
                this.close()
            }
        }

        function _findAncestor(el, cls) {
            while ((el = el.parentElement) && !el.classList.contains(cls));
            return el
        }

        function _unbindEvents() {
            if (this.opts.closeMethods.indexOf('button') !== -1) {
                this.modalCloseBtn.removeEventListener('click', this._events.clickCloseBtn)
            }
            this.modal.removeEventListener('mousedown', this._events.clickOverlay)
            window.removeEventListener('resize', this._events.resize)
            document.removeEventListener('keydown', this._events.keyboardNav)
        }

        /* ----------------------------------------------------------- */
        /* == helpers */
        /* ----------------------------------------------------------- */

        function extend() {
            for (var i = 1; i < arguments.length; i++) {
                for (var key in arguments[i]) {
                    if (arguments[i].hasOwnProperty(key)) {
                        arguments[0][key] = arguments[i][key]
                    }
                }
            }
            return arguments[0]
        }

        /* ----------------------------------------------------------- */
        /* == return */
        /* ----------------------------------------------------------- */

        return {
            modal: Modal
        }

    }))

});
$(function() {
    $('#dropdownselector').change(function() {
        $('.timesheet').hide();
        $('#' + $(this).val()).show();
    });
});

(function() {
    $('.material').find('input, textarea').each(function() {
        $(this).on('change', function() {
            $this = $(this);
            if (this.value !== "") {
                $this.addClass('filled');
            } else {
                $this.removeClass('filled');
            }
        });
    });
})();


jQuery.fn.extend({
    autoHeight: function() {
        function autoHeight_(element) {
            return jQuery(element)
                .css({ 'height': 'auto', 'overflow-y': 'hidden' })
                .height(element.scrollHeight);
        }
        return this.each(function() {
            autoHeight_(this).on('input', function() {
                autoHeight_(this);
            });
        });
    }
});

$('textarea').autoHeight();

$(function() {
    $(".focused").focus();
});


function autosize(textarea) {
    $(textarea).height(1); // temporarily shrink textarea so that scrollHeight returns content height when content does not fill textarea
    $(textarea).height($(textarea).prop("scrollHeight"));
}

$(document).ready(function() {
    $(document).on("input", "textarea", function() {
        autosize(this);
    });
    $("textarea").each(function() {
        autosize(this);
    });

});

var anyFieldReceivedFocus = false;

function fieldReceivedFocus() {
    anyFieldReceivedFocus = true;
}

function focusFirstField() {
    if (!anyFieldReceivedFocus) {
        $(".focused").focus();
    }
}

var maxLength = 100;
$('.textarea-limit').keyup(function() {
    var length = $(this).val().length;
    var length = maxlength - length;
    $('#chars').text(length);
});