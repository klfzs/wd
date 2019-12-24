$('.video_in_paly').click(function() {
    var src = $(this).next().attr('video_src')
    var title = $(this).prev().find('h2').text();
    var html = '<div class="videoplay">' +
        '<div class="videoplay_main">' +
        '<video width="100%" height="480px" loop controls autoplay="autoplay">' +
        '<source src="/static' + src + '" type="video/mp4">' +
        +'<source src="movie.ogg" type="video/ogg">' +
        '您的浏览器不支持Video标签。' +
        ' </video>' +
        '<div class="videoplay_main_title">' +
        '<h2>' + title + '</h2>' +
        '</div>' +
        '</div>' +
        '</div>'
    $('.main').append(html);
})
$('.main').on('click', '.videoplay', function() {
    $('.videoplay').remove();

})
var zxwd = $.cookie('zxwd');
if (!zxwd) {
    $('.zxwd').css('display', 'block')

}
$('.zxwd_content_main').click(function() {

    $.cookie('zxwd', 'zxwd');
    $('.zxwd').css('display', 'none')


})