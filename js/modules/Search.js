class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.openButton = document.querySelector('.js-search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.body = document.querySelector('body');
        this.events();
        this.isOverlayOpen = false; // We use this in context with keydown, to flag and reduce cost of the DOM CPU resource 
    }

    // 2. Event Listener
    events() {
        this.openButton.addEventListener('click', this.openOverlay.bind(this));
        this.closeButton.addEventListener('click', this.closeOverlay.bind(this));
        // We use keydown instead of keyup. Keyup have to make sure user let go of the key to trigger the event, 
        // so keydown is more is better UX. It always guarantee the s-key will always work
        document.addEventListener('keydown', this.keyPressDispatcher.bind(this));
    }

    // 3. Methods trigger for the Event Listener
    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
        this.body.classList.add('body-no-scroll');
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
        this.body.classList.remove('body-no-scroll');
        this.isOverlayOpen = false;
    }

    keyPressDispatcher(e) {
        e.keyCode === 83 && !this.isOverlayOpen && this.openOverlay();
        e.keyCode === 27 && this.isOverlayOpen && this.closeOverlay();
    }
}

export default Search;