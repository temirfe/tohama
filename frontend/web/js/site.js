//adminpanel open-close
$('.js_openclose').click(function(){
    $door=$('.js_admpanel-content');
    if($door.is(':visible')){
        $door.slideUp();
        $(this).text('Collapse +');
    }
    else{
        $door.slideDown();
        $(this).text('Hide -');
    }
});

$(window).scroll(function() {
    var logo_wrap=$('.js_logo_wrap');
    if ($(window).scrollTop() > 200) {
        logo_wrap.removeClass('logo_wrap_index');
    }
    else {
        logo_wrap.addClass('logo_wrap_index');
    }
});