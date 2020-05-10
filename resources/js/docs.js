import jQuery from 'jquery';
import Prism from 'prismjs';

Prism.highlightAll();

const makeTableResponsive = function () {
    jQuery(this).addClass('table').wrap('<div class="table-responsive"></div>');
};

const wrapWithHeadingContainer = function () {
    jQuery(this).wrap('<div class="section-heading"></div>');
};

jQuery('.package-docs__content h1').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h2').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h3').each(wrapWithHeadingContainer);

jQuery('.package-docs__content table').each(makeTableResponsive);
