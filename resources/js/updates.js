import jQuery from 'jquery';

const wrapWithHeadingContainer = function () {
    jQuery(this).wrap('<div class="section-heading"></div>');
};

jQuery('.package-update__content h3').each(wrapWithHeadingContainer);
jQuery('.package-update__content h4').each(wrapWithHeadingContainer);
