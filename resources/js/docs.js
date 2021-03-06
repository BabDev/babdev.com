import hljs from 'highlight.js/lib/core';

import bash from 'highlight.js/lib/languages/bash';
import css from 'highlight.js/lib/languages/css';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import markdown from 'highlight.js/lib/languages/markdown';
import php from 'highlight.js/lib/languages/php';
import twig from 'highlight.js/lib/languages/twig';
import xml from 'highlight.js/lib/languages/xml';
import yaml from 'highlight.js/lib/languages/yaml';

class BDDocs {
    static init() {
        hljs.registerLanguage('bash', bash);
        hljs.registerLanguage('css', css);
        hljs.registerLanguage('javascript', javascript);
        hljs.registerLanguage('json', json);
        hljs.registerLanguage('markdown', markdown);
        hljs.registerLanguage('php', php);
        hljs.registerLanguage('twig', twig);
        hljs.registerLanguage('xml', xml);
        hljs.registerLanguage('yaml', yaml);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
        });

        document.querySelectorAll('.package-docs__content h1').forEach(BDDocs.#wrapWithHeadingContainer);
        document.querySelectorAll('.package-docs__content h2').forEach(BDDocs.#wrapWithHeadingContainer);
        document.querySelectorAll('.package-docs__content h3').forEach(BDDocs.#wrapWithHeadingContainer);
        document.querySelectorAll('.package-docs__content h4').forEach(BDDocs.#wrapWithHeadingContainer);

        document.querySelectorAll('.package-docs__content table').forEach(BDDocs.#makeTableResponsive);
    }

    static #makeTableResponsive(element) {
        element.classList.add('table');

        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive';

        element.parentNode.insertBefore(wrapper, element);

        wrapper.appendChild(element);
    }

    static #wrapWithHeadingContainer(element) {
        const wrapper = document.createElement('div');
        wrapper.className = 'section-heading';

        element.parentNode.insertBefore(wrapper, element);

        wrapper.appendChild(element);
    }
}

BDDocs.init();
