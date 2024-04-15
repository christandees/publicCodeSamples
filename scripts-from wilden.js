jQuery( document ).ready(function($) {
    $(window).on('load', function(){
    	
      $('#cover').fadeOut(1000);
    });

    $('.explore-nbhds a.btn').each(function(){
        var linnk = $(this).attr('href');
        // console.log(window.location.pathname , linnk);
        if(linnk == window.location.pathname){
            $(this).closest('.real-estate-column').remove();
        }
    })


    // lot-finder
    $('#lot-finder').submit(function(e){
        if($('#neighbourhood').val() == '' && !$('#neighbourhood').hasClass('all-lots')) {
        }

        if($('#lot_number').val() != '' && $('#neighbourhood').val() == ''){
            alert('It looks like you want to view a specific lot details.  Please select a neighbourhood as well.');
            return false;
        }
    });

    $('#neighbourhood').change(function(){
        if($(this).val() == ''){
            $('#lot-finder').attr('action', '/kelowna-real-estate/single-family-lots/#lot-finder');
        }else{
            $('#lot-finder').attr('action', '/neighbourhoods/'+$(this).val()+'/#lot-finder');
        }
    });

    var linkit = $('.linkit').text();
    $('.linkit').html('<a href="'+linkit+'" traget="_blank">'+linkit+'</a>')

    $('.ubermenu a').each(function(){
        if($(this).attr('title') !== undefined){
            if($(this).attr('title').length < 3){
                $(this).removeAttr('title');
            }
        }
    });

    $('.wilden_close_popup').on('click', function(e){
        e.preventDefault();
        hidePopup();
        return false;
    });

//Play youtube video for slider
	$('.yvideo').on('click', function(event) {
       // alert("ddd");
       // event.preventDefault();
       
        $.fancybox({
            'type' : 'iframe',
            // hide the related video suggestions and autoplay the video
            'href' : $(this).attr("href"),
            'overlayShow' : true,
            'centerOnScroll' : true,
            'speedIn' : 100,
            'speedOut' : 50,
            'width' : 820,
            'height' : 720
        });
	});
    $('body').on('click','.requestinfo-btn',function(e){
        $('.inquiryBox').fadeIn(300);
        $('.mls-num').html(mls);
    });

    $('.inquiryBox').on('click', function(e){
        var cl = e.target.className;
        if(cl == 'inquiryBox'){
    		$('.inquiryBox').fadeOut(500);
    	}
    });

	$(".listing-banner:contains('Sold')").css({"background-color": "#ff6969 ", "display":"block" });
	$(".listing-banner:contains('Pending')").css({"background-color": "#ffce91", "display":"block" });
	$(".listing-banner:contains('Available')").css({"background-color": "#1990cc", "display":"block" });
	$(".listing-banner:contains('Showhomes')").css({"background-color": "#db933b", "display":"block" });
	$(".listing-banner:contains('Lot Home Package')").css({"background-color": "#db933b", "display":"block" });

    if($('.listingdetail-price').length > 0){
        $('#LoanAmount').val($('.listingdetail-price').eq(0).text().trim());
    }

   

    $('.listingdetail-price, .listinglist-price').each(function(){
        var numcommas = ($(this).text().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        $(this).text('$'+numcommas);
    });
    $('.pp-price .wpb_wrapper, .list-price, .f-price').each(function(){
        var numcommas = ($(this).text().toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        $(this).text(numcommas);
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() > 0) {
            $('.nav').css('top', $(window).scrollTop());
        }
    }
    );
   $(window).on('scroll', function(){
        var scrollTop = $(window).scrollTop();
        if(scrollTop >= 500 ){
            $('img.logo').css({'position':'fixed','top':'0px','width':'50px'});
            $('#wrapper-182').css({'position':'fixed','top':'0px','width':'100%' ,'z-index':'999991'});
            $('nav').css({'margin-top':'0px', 'margin-bottom':'4px'});
            if(winW > 992){
                // $('.bodywrapper').css({'margin-top':'60px'});
            }
            // else{
            //     $('div#ultimatummenu-86-responsive-menu').addClass('mobile-fixed ')
            // }
            
        }else{
            $('#wrapper-182').css({'position':'static'});
            $('nav').css({'margin-top':'-45px'});
            $('img.logo').css({'position':'static','width':'70px'});
            if(winW < 992){
                // $('.bodywrapper').css({'margin-top':'60px'});
                $('nav').css({'margin-top':'0'});
                // $('img.logo').css({'position':'fixed','top':'0px','width':'50px'});
            }
            // $('.bodywrapper').css({'margin-top':'90px'});
            // $('div#ultimatummenu-86-responsive-menu').removeClass('mobile-fixed ')
        }
    });

    // Ensure left-aligned megamenus are set to left: 0 on window resize
    $(window).resize(function(){
        $('.ultimatum-megamenu-wrapper').each(function(){
            if($(this).position().left <= -700){
                $(this).css('left', '0px');
            }
        });
    });

    // Sort form change event
    $('#sort').change(function(){
        $('#sort_form').submit();
    });

    // Move neighbourhood name to new location on listing list page
    if($('.neighbourhood-name').length > 0){
        $('.neighbourhood-name').each(function(){
            var dest = $(this).closest('article').find('.neighbourhood-name-div');
            dest.html($(this).html());
        });
    }

    // Add notice to viewers if property brochure is displayed on listing details page
    if($('.listingdetails-propertybrochure').length > 0){
        $('.vc_custom_1422388878179').after('<p>See Property Brochure For Detailed Information</p>');
    }

    // Slide for Advanced Search
    $( ".advanced-search-open" ).click(function() {
        $( ".advanced-search-row" ).slideToggle( "600", function() {
            // Animation complete.
        });
    });

    // Form adjustments
    $('.requestinfo-btn').on('click', function(){
        var elem = $(this);
        var address = elem.closest('.wpb_wrapper').find('.listinglist-address a').text();
        $('#contactForm .listing-header').html('Inquire About '+address);
        $('#contactForm input[name="contactForm[address]"]').val(address);
    });

    $('#field_1_8').css('display', 'flex');
    $('#gform_1 .gform_footer').addClass('col-md-6').appendTo('#field_1_8');
    $('#field_1_8 .ginput_container').addClass('col-md-6').css('padding', '0px');

    // Form submissions
    $('#contactForm, #emailShare').submit(function(e){
        $(this).find(".form-control-required").each(function(){
            if($(this).val() == ''){
                alert('Please enter your '+$(this).attr('id').replace('_', ' ')+'!');
                $(this).focus();
                e.preventDefault();
                return false;
            }
        });
    });

    $('.listingdetail-mailto').on('click', function(e){
        e.preventDefault();
        if($('#emailShare').is(':hidden'))
            $('#emailShare').stop().slideDown();
        else
            $('#emailShare').stop().slideUp();
    });

    // remove video and map tabs if no content provided
    var gallery_tab = $('ul.wpb_tabs_nav a:contains("Gallery")');
    var map_tab = $('ul.wpb_tabs_nav a:contains("Map")');
    var video_tab = $('ul.wpb_tabs_nav a:contains("Video")');

    if($(gallery_tab).length > 0){
        var gallery_tab_href = gallery_tab.attr('href');
        if($(gallery_tab_href).html().trim() == '') gallery_tab.parent().remove();
    }

    if($(map_tab).length > 0){
        var map_tab_href = map_tab.attr('href');
        if($(map_tab_href).html().trim() == '') map_tab.parent().remove();
    }

    if($(video_tab).length > 0){
        var video_tab_href = video_tab.attr('href');
        if($(video_tab_href).html().trim() == '') video_tab.parent().remove();
    }

    if($('#wilden_map').length > 0){
        // var iconbase = '/wp-content/themes/wilden/images/';
        var map_div = $('#wilden_map');
        if($(map_tab).length > 0){
            $(map_tab).on('click', function(e){
                e.preventDefault();
                $(map_tab_href).show();
                $(map_tab_href).find('.wpb_content_element').append(map_div);
                map_div.show();
                createOLMap($(map_tab_href));
            });
        }else{
            createOLMap(false);
        }
    }

    // remove gallery popup image title object
    $('.ppt').css('display', 'none !important');

    // unbind prettyphoto
    $("a[class='prettyphoto']").removeClass('prettyphoto');

    $('.flexslider li').on('click', function(e){
        e.preventDefault()
    });

      jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
            if(formId == 5) {
                // run code specific to form ID 1
                console.log('yep');
                $('html, body').animate({
                    scrollTop: $("#register").offset().top
                    }, 2000);
               
            } else {
                console.log('nope');
            }
        });
$('#facet-reset').click(function(){
    FWP.reset();


})
$('.listings-title').click(function(){
    if($('.listings-facets').hasClass('open')){
        $('.listings-facets').removeClass('open');
    }else{
         $('.listings-facets').addClass('open');
    }

})


//Echo Ridge Movie Launcher
  function init() {
        var vidDefer = document.getElementsByTagName('iframe');
        for (var i=0; i<vidDefer.length; i++) {
        if(vidDefer[i].getAttribute('data-src')) {
        vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
    } } }


$('#launchER').click(function() {
    console.log('hello');
    window.onload = init;
});
$('body').on('hidden.bs.modal', '.modal', function () {
    

        $("iframe").each(function() { 
        var src= $(this).attr('src');
        $(this).attr('src',src);  
        });
    });


/* Get the element you want displayed in fullscreen mode (a video in this example): */

 $('#modal-trg-txt-wrap-3717').on('click', function(){
    console.log('tour');
 });
var elem = document.getElementById("tourfull");

/* When the openFullscreen() function is executed, open the video in fullscreen.
Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */




});/////////////////////////// Ready close////////////////////////////////////
