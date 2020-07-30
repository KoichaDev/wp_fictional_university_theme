class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.resultDiv = document.querySelector('.search-overlay__results');
        this.spinner = document.querySelector('[data-spinner-loader]');
        this.openButton = document.querySelector('.js-search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.body = document.querySelector('body');
        this.searchField = document.querySelector('#search-term');
        this.events();
        this.isOverlayOpen = false; // We use this in context with keydown, to flag and reduce cost of the DOM CPU resource 
        this.isSpinnerVisible = false;
        this.previousValue;
        this.typingtimer;

    }

    // 2. Event Listener
    events() {
        this.openButton.addEventListener('click', this.openOverlay.bind(this));
        this.closeButton.addEventListener('click', this.closeOverlay.bind(this));
        // We use keydown instead of keyup. Keyup have to make sure user let go of the key to trigger the event, 
        // so keydown is more is better UX. It always guarantee the s-key will always work
        document.addEventListener('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.addEventListener('keyup', this.typingLogic.bind(this));
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

    typingLogic() {
        if (this.searchField.value !== this.previousValue) {
            // This will reset our setTimeout until the search field has completely stopped
            // Then it will trigger the setTimeout()
            clearTimeout(this.typingtimer);

            if (this.searchField.value) {
                if (!this.isSpinnerVisible) {
                    this.spinner.classList.add('spinner-loader');
                    this.isSpinnerVisible = true;
                }
            } else {
                this.resultDiv.textContent = '';
                this.isSpinnerVisible = false;
            }

            this.typingtimer = setTimeout(this.getResults.bind(this), 2000);
        }
        this.previousValue = this.searchField.value;
    }

    getResults() {
        this.resultDiv.textContent = 'Image real world';
        this.isSpinnerVisible = false;
    }

}

export default Search;