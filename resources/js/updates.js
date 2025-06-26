document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.package-update-content code').forEach((element) => {
        element.classList.add('not-prose');
    });
});
