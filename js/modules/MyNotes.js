import HTTP from "./HTTP";
const http = new HTTP();

class MyNotes {
    constructor() {
        this.deleteButton = document.querySelector('[data-delete-button]');
        this.events();
    }

    // Events listeners will go here
    events() {
        this.deleteButton.addEventListener('click', this.deleteNotes);
    }

    // Triggering the events will go here
    deleteNotes() {
        http.delete(kho_university_data.root_url + '/wp-json/wp/v2/note/129')
            .then(data => console.log(data))
            .catch(err => console.log(err));
    }
}

export default MyNotes;