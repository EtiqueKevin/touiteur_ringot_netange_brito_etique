'use strict';

function saveScrollPosition() {
    const scrollPosition = window.scrollY || window.pageYOffset;
    localStorage.setItem('scrollPosition', scrollPosition.toString());
}

function restoreScrollPosition() {
    const savedScrollPosition = localStorage.getItem('scrollPosition');
    if (savedScrollPosition) {
        window.scrollTo(0, parseInt(savedScrollPosition, 10));
    }
}

window.addEventListener('beforeunload', saveScrollPosition);
window.addEventListener('load', restoreScrollPosition);