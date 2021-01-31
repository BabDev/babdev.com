class BDUpdates {
    static init() {
        document.querySelectorAll('.package-update__content h3').forEach(BDUpdates.#wrapWithHeadingContainer);
        document.querySelectorAll('.package-update__content h4').forEach(BDUpdates.#wrapWithHeadingContainer);
    }

    static #wrapWithHeadingContainer(element) {
        const wrapper = document.createElement('div');
        wrapper.className = 'section-heading';

        element.parentNode.insertBefore(wrapper, element);

        wrapper.appendChild(element);
    }
}

BDUpdates.init();
