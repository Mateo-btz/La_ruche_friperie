// $(window).scroll(function() {
//     $('.fade-in').each(function() {
//         var position = $(this).offset().top;
//         var windowTop = $(window).scrollTop();
//         if (position < windowTop + $(window).height()) {
//             $(this).addClass('visible');
//         }
//     });
// });

$(window).scroll(function() {
    var hT = $('.fade-in').offset().top,
        hH = $('.fade-in').outerHeight(),
        wH = $(window).height(),
        wS = $(this).scrollTop();
    if (wS > (hT+hH-wH)){
        $('.fade-in').addClass('visible');
        console.log('on est dedans');
    }
 });