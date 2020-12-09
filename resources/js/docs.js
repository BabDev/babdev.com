import hljs from 'highlight.js';

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
});

const makeTableResponsive = function (element) {
    element.classList.add('table');

    const wrapper = document.createElement('div');
    wrapper.className = 'table-responsive';

    element.parentNode.insertBefore(wrapper, element);

    wrapper.appendChild(element);
};

const wrapWithHeadingContainer = function (element) {
    const wrapper = document.createElement('div');
    wrapper.className = 'section-heading';

    element.parentNode.insertBefore(wrapper, element);

    wrapper.appendChild(element);
};

document.querySelectorAll('.package-docs__content h1').forEach((element) => {
    wrapWithHeadingContainer(element);
});

document.querySelectorAll('.package-docs__content h2').forEach((element) => {
    wrapWithHeadingContainer(element);
});

document.querySelectorAll('.package-docs__content h3').forEach((element) => {
    wrapWithHeadingContainer(element);
});

document.querySelectorAll('.package-docs__content h4').forEach((element) => {
    wrapWithHeadingContainer(element);
});

document.querySelectorAll('.package-docs__content table').forEach((element) => {
    makeTableResponsive(element);
});
