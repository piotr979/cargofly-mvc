document.addEventListener('DOMContentLoaded', () => {

    const searchButton = document.getElementById('search-button');
    const searchForm = document.querySelector('.search-form--responsive');
    const searchCloseButton = document.getElementById('search-form--close');

    const toggleSearchFormClass = (className) => {
        searchForm.classList.toggle(className);
    }
    searchButton.addEventListener('click', (e) => {
        toggleSearchFormClass('search-open');

    })
    searchCloseButton.addEventListener('click', () => {
        toggleSearchFormClass('search-open');
    })
})