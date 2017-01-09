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

//Check to see if the window is top if not then display button
$(window).scroll(function(){
    if ($(this).scrollTop() > 300) {
        $('.scrollToTop').fadeIn();
    } else {
        $('.scrollToTop').fadeOut();
    }
});

//Click event to scroll to top
$('.scrollToTop').click(function(e){
    e.preventDefault();
    $('html, body').animate({scrollTop : 0},500);
    return false;
});

//city depdrop on country
$('#hotel-country_id').on('change',function(){
    var country_id=$(this).val();
    $.ajax({
            method: "POST",
            url: "/city/country-cities",
            data: { country_id: country_id }
        })
        .done(function( msg ) {
            $('#hotel-city_id').html(msg);
        });
});

//add skus
$('.js_add_sku').click(function (e) {
    e.preventDefault();
    var inp=$('.js_sku_form').find('div').clone();
    $('.js_skus').append(inp);
});

//grab loading
var sub_but=$('.js_grab_submit');
sub_but.click(function(){
    $('.js_grab_loading').show();
    $('.alert').hide();
});

$('.js_excel_form').submit(function(){
    sub_but.attr("disabled", true);
});