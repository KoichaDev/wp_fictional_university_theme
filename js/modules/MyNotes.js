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

        const dataNote = li.children[1].getAttribute('data-edit-note');

        dataNote === 'true' ? this.makeNoteEditable(li) : this.readNoteOnly(li);

    }

    makeNoteEditable(element) {
        const li = element;
        const title = li.children[0];
        const editBtn = li.children[1];
        const textArea = li.children[3];
        const saveBtn = li.children[4];

        title.removeAttribute('readonly');
        textArea.removeAttribute('readonly');

        editBtn.setAttribute('data-edit-note', 'false');

        // Adding a new class to give a better UX focus that when user click on edit, they can change
        title.classList.add('note-active-field');
        textArea.classList.add('note-active-field')

        // Changing edit button to different icon and cancel text
        editBtn.classList.add('fa', 'fa-times');
        editBtn.textContent = 'Cancel';

        saveBtn.classList.add('update-note--visible');
    }

    readNoteOnly(element) {
        const li = element;

        const title = li.children[0];
        const editBtn = li.children[1];
        const textArea = li.children[3];
        const saveBtn = li.children[4];

        title.setAttribute('readonly', '');
        textArea.setAttribute('readonly', '');

        editBtn.setAttribute('data-edit-note', 'true');

        // Adding a new class to give a better UX focus that when user click on edit, they can change
        title.classList.remove('note-active-field');
        textArea.classList.remove('note-active-field')

        // Changing edit button to different icon and cancel text
        editBtn.classList.add('fa', 'fa-pencil');
        editBtn.textContent = 'Edit';

        saveBtn.classList.remove('update-note--visible');
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