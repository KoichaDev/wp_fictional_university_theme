import $ from "jquery"
import HTTP from "./HTTP";
const http = new HTTP();

class MyNotes {
    constructor() {
        this.dataMyNotes = document.querySelector('[data-my-notes]');
        this.deleteButton = document.querySelectorAll('[data-delete-button]');
        this.events();
    }

    // Events listeners will go here
    events() {
        for (let i = 0; i < this.deleteButton.length; i++) {
            this.deleteButton[i].addEventListener('click', this.deleteNotes.bind(this));
        }
    }

    // Triggering the events will go here
    deleteNotes(e) {
        const li = e.target.parentElement;

        http.delete(kho_university_data.root_url + `/wp-json/wp/v2/note/${li.getAttribute('data-id')}`)
            .then(data => {
                $(li).slideUp();
            })
            .catch(err => console.log(err));
    }
}

export default MyNotes;