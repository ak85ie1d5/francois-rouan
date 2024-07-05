document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('new-location-modal-action')) {
        new ModalNewLocation()
    }
});

class ModalNewLocation {
    constructor() {
        this.#onModalActionClick()
    }

    #onModalActionClick() {
        document.querySelector('#new-location-modal-action').addEventListener('click', function(event) {
            event.preventDefault();

            let modalInstance = document.querySelector('#modal-new-location')

            fetch('/admin/new_location')
                .then(response => response.text())
                .then(html => {
                    let modalBody = document.querySelector('#modal-new-location-body');

                    if (modalBody) {
                        // Clear the modal body
                        modalBody.innerHTML = '';

                        // Create a new div element
                        let div = document.createElement('div');

                        // Set its innerHTML to the fetched HTML
                        div.innerHTML = html;

                        // Append the new div element to the modal body
                        modalBody.appendChild(div);

                        // Handle form submission
                        let form = modalBody.querySelector('form');
                        if (form) {
                            form.addEventListener('submit', function(event) {
                                event.preventDefault();

                                fetch('/admin/new_location', {
                                    method: 'POST',
                                    body: new FormData(event.target)
                                })
                                .finally(() => {
                                    // Close the modal and refresh the page, regardless of whether the fetch call succeeded or failed
                                    let modalInstance = new bootstrap.Modal(document.getElementById('modal-new-location'), {});
                                    modalInstance.hide();
                                    location.reload();
                                });
                            });
                        }

                        // Show the modal after the new HTML has been added to the modal body
                        modalInstance.show();
                    }
                });
        });
    }
}
