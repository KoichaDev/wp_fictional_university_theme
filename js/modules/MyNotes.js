import $ from "jquery"
import HTTP from "./HTTP";
const http = new HTTP();

class MyNotes {
    constructor() {
        this.dataMyNotes = document.querySelector('[data-my-notes]');
        this.editMyNotes = document.querySelectorAll('[ data-edit-note]');
        this.deleteButton = document.querySelectorAll('[data-delete-button]');
        this.events();
    }

    // Events listeners will go here
    events() {
        for (let i = 0; i < this.deleteButton.length; i++) {
            this.deleteButton[i].addEventListener('click', this.deleteNotes.bind(this));
        }

        for (let i = 0; i < this.editMyNotes.length; i++) {
            this.editMyNotes[i].addEventListener('click', this.editNotes.bind(this));
        }
    }

    // Triggering the events will go here

    editNotes(e) {
        const li = e.target.parentElement;
        const title = li.children[0];
        const textArea = li.children[3];
        const saveBtn = li.children[4];


        // Removing the attribute of readonly from the element
        title.removeAttribute('readonly');
        textArea.removeAttribute('readonly');

        // Adding a new class to give a better UX focus that when user click on edit, they can change
        title.classList.add('note-active-field');
        textArea.classList.add('note-active-field')

        // 
        saveBtn.classList.add('update-note--visible');
    }

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