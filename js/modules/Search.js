class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.resultDiv = document.querySelector('.search-overlay__results');
        this.spinner = document.querySelector('[data-spinner-loader]');
        this.openButton = document.querySelector('.js-search-trigger');
        this.closeButton = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.ul = document.querySelector('.search-overlay__results > ul');
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
            clearTimeout(this.typingTimer);

            if (this.searchField.value) {
                if (!this.isSpinnerVisible) {
                    this.spinner.classList.add('spinner-loader');
                    this.isSpinnerVisible = true;
                }
                this.typingtimer = setTimeout(this.getResults.bind(this), 2000);

            } else {
                this.ul.innerHTML = '';
                this.isSpinnerVisible = false;
            }

        }
        this.previousValue = this.searchField.value;
    }

    async getResults() {
        try {
            const res = await fetch(`${window.location.href}wp-json/wp/v2/posts?search=${this.searchField.value}`);
            const posts = await res.json();

            if (posts) this.spinner.classList.remove('spinner-loader');

            if (this.isSpinnerVisible) {
                if (posts.length) {
                    posts.map(post => {
                        if (post) this.isSpinnerVisible = false;
                        const { title, link } = post;

                        const li = document.createElement('li');
                        const a = document.createElement('a');

                        a.setAttribute('href', link);
                        a.textContent = title.rendered;

                        this.resultDiv.appendChild(this.ul);
                        this.ul.appendChild(li);
                        li.appendChild(a);
                    });
                } else {
                    this.resultDiv.textContent = '';
                    const p = document.createElement('p');
                    p.textContent = 'No Results Found';
                    this.resultDiv.appendChild(p);
                }
                this.spinner.classList.add('spinner-loader');
            }
        } catch (err) {
            console.log(err);
        }
    }

}

export default Search;