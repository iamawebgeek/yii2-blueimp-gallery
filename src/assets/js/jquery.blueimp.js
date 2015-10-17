(function ($) {

    $.fn.blueImp = function (items, options) {
        if ($(this).hasClass("blueimp-gallery-carousel")) {
            blueimp.Gallery(items, options);
        } else {
            $(this).data(options);
        }
        return this;
    };

})(window.jQuery);