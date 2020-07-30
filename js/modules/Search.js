class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = document.querySelector('.js-search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.events();
    }

    // 2. events 
    events() {
        this.openButton.addEventListener('click', this.openOverlay.bind(this));
        this.closeButton.addEventListener('click', this.closeOverlay.bind(this));
    }

    // 3. methods
    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
    }
}

export default Search;