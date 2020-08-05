import $ from "jquery"
import HTTP from "./HTTP";
import Utilities from './Utilities';

const http = new HTTP();
const utilities = new Utilities();
class MyNotes {
    constructor() {
        this.dataMyNotes = document.querySelector('[data-my-notes]');
        this.editMyNotes = document.querySelectorAll('[ data-edit-note]');
        this.updateMyNotes = document.querySelectorAll('[data-update-note]');
        this.newMyNotes = document.querySelector('[data-submit-new-note]');
        this.deleteButton = document.querySelectorAll('[data-delete-button]');

        this.newPostTitle = document.querySelector('[data-new-title]');
        this.newPostBody = document.querySelector('[data-new-textarea]');
        this.events();
    }

    // Events listeners will go here
    events() {
        this.newMyNotes.addEventListener('click', this.createPost.bind(this));

        for (let i = 0; i < this.deleteButton.length; i++) {
            this.deleteButton[i].addEventListener('click', this.deleteNotes.bind(this));
        }

        for (let i = 0; i < this.editMyNotes.length; i++) {
            this.editMyNotes[i].addEventListener('click', this.editNotes.bind(this));
        }

        for (let i = 0; i < this.updateMyNotes.length; i++) {
            this.updateMyNotes[i].addEventListener('click', this.updateNote.bind(this));
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

    createPost(e) {
        // WP needs to look after the exact keys from the object
        const newPost = {
            'title': this.newPostTitle.value,
            'content': this.newPostBody.value,
            'status': 'publish' // Default is draft. Adding the publish will publish the post right away
        }

        http.post(kho_university_data.root_url + `/wp-json/wp/v2/note`, newPost)
            .then((res) => {
                const parser = new DOMParser();

                // Reset the title and body note
                this.newPostTitle.value = '';
                this.newPostBody.value = '';

                const outputNode = `
                    <li data-id="${res.id}">
                        <input readonly class="note-title-field" data-input-title value="${res.title.raw}">
                        <span class="edit-note" data-edit-note="true">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit
                        </span>
                        <span class="delete-note" data-delete-button>
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                            Delete
                        </span>

                        <textarea readonly class="note-body-field">${res.content.raw}</textarea>
                        
                        <span class="update-note btn btn--blue btn--small" data-update-note>
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            Save
                        </span>
                    </li>
                `;

                this.dataMyNotes.insertAdjacentHTML('afterbegin', outputNode);
            })
            .catch(err => console.log(err));
    }


    updateNote(e) {
        const li = e.target.parentElement;
        const title = li.children[0];
        const textArea = li.children[3];

        // WP needs to look after the exact keys from the object
        const updatePost = {
            'title': title.value,
            'content': textArea.value
        }

        http.update(kho_university_data.root_url + `/wp-json/wp/v2/note/${li.getAttribute('data-id')}`, updatePost)
            .then(() => {
                this.readNoteOnly(li);
            })
            .catch(err => console.log(err));
    }

    deleteNotes(e) {
        const li = e.target.parentElement;

        http.delete(kho_university_data.root_url + `/wp-json/wp/v2/note/${li.getAttribute('data-id')}`)
            .then(() => {
                $(li).slideUp();
            })
            .catch(err => console.log(err));
    }
}

export default MyNotes;