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

//image
$(document).on('click', '.js_prevent_default',function(e){
    e.preventDefault();
});
$(document).on('click','.js_open_thumb',function(e){
    e.preventDefault();
    $('.js_prevent_default').attr('class','js_open_thumb');
    $(this).attr('class','js_prevent_default active_thumb');
    $('.js_main_img').attr('src',$(this).attr('data-big'));

    var ind=$(this).attr('data-index');
    $('.js_photo_swipe').attr('data-index',ind);
});

$('.js_main_img').click(function(){
    var active_thumb_link=$('.js_prevent_default');
    active_thumb_link.attr('class','js_open_thumb');
    var next=active_thumb_link.parent().next().find('a');
    if(next.length===0){
        next=active_thumb_link.parents('ul').find('li:first-child a');
    }
    $(this).attr('src',next.attr('data-big'));
    next.attr('class','js_prevent_default active_thumb');

    var ind=next.attr('data-index');
    $('.js_photo_swipe').attr('data-index',ind);
});

//photo swipe
$(document).on('click','.js_photo_swipe',function(e){
    e.preventDefault();
    var index=$(this).attr('data-index');
    openPhotoSwipe(index);
});

var openPhotoSwipe = function(ind)
{
    var pswpElement =document.querySelectorAll('.pswp')[0];

    ind=parseInt(ind);
    // define options (if needed)
    var options = {
        index: ind, // start at first slide
        showHideOpacity:true,
        getThumbBoundsFn:false,
        bgOpacity:0.9,
        closeOnScroll:false,
        shareButtons: false
    };
    var items = [];
    var image=new Image();
    $(".js_img").each(function() {
        var src=$(this).parent().attr('data-big');
        image.src=src;
        var w=image.width;
        var h=image.height;
        items.push({src:src, w:w, h:h});
    });

    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
};

//search date picker
function startChange(data){
    var date_to_input=$('#hotelsearch-date_to');
    var start_millis=data.getTime();
    var end_string=date_to_input.val();
    var end_date=new Date(end_string);
    var end_millis=end_date.getTime();
    var diff =  Math.floor((end_millis - start_millis) / 86400000);
    if(end_millis<start_millis){
        var monthNames = [
            "Jan", "Feb", "Mar",
            "Apr", "May", "Jun", "Jul",
            "Aug", "Sep", "Oct",
            "Nov", "Dec"
        ];

        diff=7;

        var date = new Date();
        var res = date.setDate(data.getDate() + 7);
        var zb=new Date(res);
        var day = zb.getDate();
        var monthIndex = zb.getMonth();
        var year = zb.getFullYear();
        date_to_input.kvDatepicker({format: 'dd M yyyy'});
        date_to_input.kvDatepicker("update", new Date(day + ' ' + monthNames[monthIndex] + ' ' + year));
    }
    $('.js_nights_count').text(diff+'-night stay');
}

$('.js_show_additional_book_rows').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    $('.js_tbl_'+id).find('.js_book_row_additional').slideDown();
    $(this).hide();
});

//child age
$('.js_children').change(function(){
    var label=$('.js_child_ages_label');
    var date=label.attr('data-date');
    var children=$(this).val();
    var container=$('.js_child_ages');
    container.html('');

    if(children>0){
        if(children==1){label.text("Age of child on "+date);}
        else {label.text("Age of children on "+date);}
    }
    else{label.text("");}

    var input;
    for (var i=0; i<children; i++){
        input=$('.js_child_here select').clone();
        container.append(input);
    }
});

//open terms
$('.js_terms_link').click(function(){
    var hotel_id=$(this).attr('data-hotel');
    var excel_id=$(this).attr('data-excel');
    var cont=$('.js_terms_here');
    cont.html("<div class='loader'></div>");
    $.ajax({
            type: 'POST',
            data: {hotel_id:hotel_id, excel_id:excel_id, _csrf: yii.getCsrfToken()},
            url: '/site/load-terms',
            //beforeSend: function () {},
            success:function(data){
                cont.html(data);
            }
        });
});

//tab search
$('.js_flights_tab').click(function(){
    $(this).hide();
    $('.js_hotels_tab').find('span').hide();
    $('.js_hotels_wrap').hide();
    $('.js_flights_wrap').show();
});
$('.js_hotels_tab').click(function(){
    $(this).find('span').show();
    $('.js_flights_tab').show();
    $('.js_hotels_wrap').show();
    $('.js_flights_wrap').hide();
});