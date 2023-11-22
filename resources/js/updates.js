function wrapWithHeadingContainer(element) {
    const wrapper = document.createElement('div');
    wrapper.className = 'section-heading';

    element.parentNode.insertBefore(wrapper, element);

    wrapper.appendChild(element);
}

document.querySelectorAll('.package-update__content h3').forEach(wrapWithHeadingContainer);
document.querySelectorAll('.package-update__content h4').forEach(wrapWithHeadingContainer);
