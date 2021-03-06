class Search {
    // 1. Describe and create/initiate our object
    constructor() {
        this.resultDiv = document.querySelector('.search-overlay__results');
        this.spinner = document.querySelector('[data-spinner-loader]');
        this.dataSectionGeneralInfo = document.querySelector('[data-section-general-info]');
        this.dataSectionProgram = document.querySelector('[data-section-program]');
        this.dataSectionProfessors = document.querySelector('[data-section-professors]');
        this.dataSectionCampuses = document.querySelector('[data-section-campuses]');
        this.dataSectionEvents = document.querySelector('[data-section-events]');
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
    openOverlay(e) {
        e.preventDefault();
        this.searchOverlay.classList.add('search-overlay--active');
        this.body.classList.add('body-no-scroll');
        // This will reset the searchField value if the user closing the overlay
        this.searchField.value = '';
        // The searchfield will be automatically autofocus and user can type on the searchfield right away
        // reason it's 301 ms is due to the CSS animation that takes 300 ms to load up. 301 ms is a safe-guard
        setTimeout(() => this.searchField.focus(), 301);
        this.isOverlayOpen = true;
        return false;
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
                this.typingtimer = setTimeout(this.getResults.bind(this), 750);

            } else {
                this.resultDiv.textContent = '';
                this.isSpinnerVisible = false;
            }

        }
        this.previousValue = this.searchField.value;
    }

    async getResults() {
        const res = await fetch(kho_university_data.root_url + `/wp-json/kho_university/v1/search?term=${this.searchField.value}`);
        const data = await res.json();
        data.then(results => {
            if (results) this.spinner.classList.remove('spinner-loader');

            const { campuses, events, general_info, professors, programs } = results;

            if (!results) {
                this.resultDiv.textContent = 'No Result found!'
            } else {
                document.querySelector('[data-container-search]').style.display = 'block';
                general_info.map(result => {
                    console.log(result)
                    this.dataSectionGeneralInfo.innerHTML = `
                        <li>
                            <a href="${result?.permalink}">
                                ${result?.title}
                            </a> 
                            ${result?.post_type === 'post' && `by ${result?.author_name}`
                        }
                        </li`;
                });

                programs.map(result => {
                    this.dataSectionProgram.innerHTML = `
                        <li>
                            <a href="${result?.permalink}">${result?.title}</a> 
                        </li`;
                })

            }
            // As soon the user typing on the search field, the spinner will load
            this.isSpinnerVisible = true;

        }).catch(err => {
            this.resultDiv.textContent = err;
            console.log(err);
        });
    }
}

export default Search;