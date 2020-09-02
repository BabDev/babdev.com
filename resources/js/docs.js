import jQuery from 'jquery';
import hljs from 'highlight.js';

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
});

const makeTableResponsive = function () {
    jQuery(this).addClass('table').wrap('<div class="table-responsive"></div>');
};

const wrapWithHeadingContainer = function () {
    jQuery(this).wrap('<div class="section-heading"></div>');
};

jQuery('.package-docs__content h1').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h2').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h3').each(wrapWithHeadingContainer);
jQuery('.package-docs__content h4').each(wrapWithHeadingContainer);

jQuery('.package-docs__content table').each(makeTableResponsive);
