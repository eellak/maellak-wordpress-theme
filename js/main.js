!function ($) {

  $(function(){
    var $window = $(window);
    var body = document.body;

    $('#carousel').carousel();

    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    var $videos = $("iframe[src^='http://player.vimeo.com'], iframe[src^='http://www.youtube.com']");
    var $videoWrap = $(".video-wrap");

    $videos.each(function() {
        $(this).data('aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');
    });

    $(window).resize(function() {
        resizeSponsorImgs();

        var newWidth = $videoWrap.width();
        var newHeight = $videoWrap.height();
        $videos.each(function() {
            var $el = $(this);
            $el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
        });

        handleCollapsibles();
    }).resize();

    //  restyle comment form in case markup cannot be bootstrapified, remove out if that's not the case
    $('#respond').find('form').hide().addClass('form-horizontal');
    $('#respond').find('textarea').addClass('span12').attr('placeholder', 'Η άποψή σας');
    $('#respond').find('input#author').attr('value', 'Όνομα (υποχρεωτικό)');
    $('#respond').find('input#email').attr('value', 'Email (υποχρεωτικό)');
    $('#respond').find('input#author, input#email').addClass('span12').parent('p').addClass('span6').wrapAll('<div class="row-fluid"></div>');
    $('#respond').find('input#url').attr('value', 'URL').addClass('span12').parent('p').addClass('span12').wrap('<div class="row-fluid"></div>');
    $('#respond').find('input[type=submit]').wrap('<div class="actions"><div class="span4"></div></div>').addClass('btn btn-primary btn-block');
    $('#respond').find('form').show();

    function handleCollapsibles() {
        // trigger collpasible list-with-icons when .btn .btn-navbar is visible ie < 980px
        if($('.btn.btn-navbar').is(':hidden')) {
            $('.accordion-body.collapse').removeAttr('style').addClass('in');
            $('.accordion-toggle').click(function(e) {
                e.preventDefault();
            }).removeAttr('data-toggle');
            $('#accordion1').parent('div.span6').addClass('text-right');
        } else {
            $('#accordion1').parent('div.span6').removeClass('text-right');
            $('.accordion-body.collapse').removeClass('in');
            $('.accordion-toggle').addClass('collapsed').attr('data-toggle', 'collapse');
        }
    }

    function resizeSponsorImgs() {
        $('.sponsor img').each(function(i, img) {
            var h = $(img).height();
            var targetH = $('.colophon').height();
            var diff = .5*(targetH - h);

            $(img).css({
                marginTop: diff,
                visibility: 'visible'
            });
            // });
            // .animate({
            //     opacity: 1
            // }, 2200);

            // prefer css %
            // $(this).css({
            //     // paddingLeft: $(this).next().css('margin-left')
            // });

            // this is more reliable than checking for window width
            if($('#theI').is(':hidden')) {
                $(img).removeAttr('style').css({
                    // visibility: 'visible',
                    // opacity: 1
                });
            }
        });
    }

  })

}(window.jQuery);
