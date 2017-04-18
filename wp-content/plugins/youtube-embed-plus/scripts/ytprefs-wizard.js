var _EPYTWIZ_ = _EPYTWIZ_ || {};
(function ($) {

    _EPYTWIZ_.selectText = _EPYTWIZ_.selectText || function (ele) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(ele);
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(ele);
            window.getSelection().addRange(range);
        }
    };


    _EPYTWIZ_.loadmovieplain = _EPYTWIZ_.loadmovieplain || function (vid) {
        var codetemplate = '<iframe width="600" height="368" src="//www.youtube.com/embed/~ytid?showinfo=0&autoplay=1" frameborder="0" allowfullscreen ></iframe>';
        codetemplate = codetemplate.replace(/~ytid/g, vid);
        $("#watch" + vid).html(codetemplate);
        $('#closeme' + vid).css('display', 'inline');
        $("#moviecontainer" + vid).css('display', 'block');
        if (document.getElementById('scrollwatch' + vid)) {
            setTimeout(function () {
                $('html, body').animate({
                    scrollTop: $('#scrollwatch' + vid).offset().top - 50
                }, 250, function () {
                });

            }, 800);
        }
    };


    _EPYTWIZ_.closeme = _EPYTWIZ_.closeme || function (vid) {
        $("#moviecontainer" + vid).css('display', 'none');
        $("#watch" + vid).html("");
    };

    $(document).ready(function () {
        $('.wiz-accordion').accordion({
            header: "h3",
            collapsible: true,
            active: false,
            icons: {
                header: "ui-icon-circle-arrow-e",
                activeHeader: "ui-icon-circle-arrow-s"
            },
            heightStyle: "content",
            autoHeight: false
        }).find('h3.header-go').click(function () {
            window.open($(this).find('a').attr('href'), '_blank');
            return false;
        });

        $('.playlist-tabs').tabs();

        if (_EPYTWIZ_.acc_expand)
        {
            $('.wiz-accordion #' + _EPYTWIZ_.acc_expand).click();
        }

        $('form.wizform').each(function () {
            $thisForm = $(this);
            $thisForm.find('.txturlpastecustom').on('paste', function () {
                $thisTxtUrl = $(this);
                setTimeout(function () {
                    var thepaste = $.trim($thisTxtUrl.val());
                    var badpaste = /<.*/i;
                    if (badpaste.test(thepaste)) {
                        var reg = new RegExp('(?:https?://)?(?:www\\.)?(?:youtu\\.be/|youtube\\.com(?:/embed/|/v/|/watch\\?v=))([\\w-]{10,12})', 'ig');
                        //get matches found for the regular expression
                        var matches = reg.exec(thepaste);
                        //check if we have found a match for a YouTube video
                        //will support legacy code, shortened urls and
                        if (matches) {
                            var ytid = matches[1];
                            $thisTxtUrl.val('https://www.youtube.com/watch?v=' + ytid);
                        }
                        else {
                            $thisTxtUrl.val('https://www.youtube.com/watch?v=');
                        }
                        $thisForm.find('.badpaste').show();

                    }
                    else {
                        $thisForm.find('.badpaste').hide();
                    }

                }, 100);
            });
        });


        $('#epyt_wiz_wrap').on('click', '.copycode', function () {
            _EPYTWIZ_.selectText(this);
        });

        $('#epyt_wiz_wrap').on('click', '.inserttopost', function () {
            var targetdomain = window.location.toString().split("/")[0] + "//" + window.location.toString().split("/")[2];
            var embedline = $(this).attr("rel");
            parent.postMessage("youtubeembedplus|" + embedline, targetdomain);
        });

        $('#epyt_wiz_wrap').on('click', '.resultdiv .load-movie', function () {
            _EPYTWIZ_.loadmovieplain($(this).closest('.resultdiv').data('vid'));
            return false;
        });

        $('#epyt_wiz_wrap').on('click', '.moviecontainer a.closeme', function () {
            _EPYTWIZ_.closeme($(this).data('vid'));
        });

    });
})(jQuery);