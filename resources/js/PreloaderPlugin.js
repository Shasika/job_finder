export default {
    install(Vue) {
        Vue.prototype.$openPreLoader = function () {
            $('#preloader-active').delay(450).fadeOut('slow');
            $('body').delay(450).css({
                'overflow': 'visible'
            });
        };
    }
}
