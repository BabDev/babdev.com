import jQuery from 'jquery';
import Prism from 'prismjs';

Prism.highlightAll();

const wrapWithHeadingContainer = function () {
    jQuery(this).wrap('<div class="section-heading"></div>');
};

jQuery('.package-docs__content h1').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h2').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h3').each(wrapWithHeadingContainer);
