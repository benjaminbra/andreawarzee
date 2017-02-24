var map = {65: false, 87: false};
$(document).keydown(function(e) {
    if (e.keyCode in map) {
        map[e.keyCode] = true;
        console.log(map);
        if (map[65] && map[87]) {
            $('body').toggleClass('unicorn');
        }
    }
}).keyup(function(e) {
    if (e.keyCode in map) {
        map[e.keyCode] = false;
    }
});
$('.block-menu').mouseenter(function(){
    $(this).children('.description').slideToggle();
}).mouseleave(function(){
    $(this).children('.description').slideToggle();
});

$('.mobile-menu button').on('click', function(){
    $('.menu').toggleClass('active');
});

$('.scrollable-block').perfectScrollbar();