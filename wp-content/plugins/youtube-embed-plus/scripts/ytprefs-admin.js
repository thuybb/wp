function widen_ytprefs_wiz() {
    setTimeout(function () {
        jQuery("#TB_window").animate({marginLeft: '-475px', width: '950px'}, 150, 'swing', function () {
            jQuery("#TB_window").get(0).style.setProperty('width', '950px', 'important');
        });

        jQuery("#TB_window iframe").animate({width: '950px'}, 150);
    }, 750);
}
jQuery(document).ready(function () {
    jQuery('body').on('click.tbyt', "#ytprefs_wiz_button", function () {
        widen_ytprefs_wiz();
    });
    jQuery(window).resize(widen_ytprefs_wiz);
});