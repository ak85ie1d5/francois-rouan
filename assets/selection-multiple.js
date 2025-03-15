document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.batch-actions')) {
        new SelectionMultiple();
    }
});

class SelectionMultiple {
    constructor() {
        this.selectedArtworks = JSON.parse(this.#getCookie('selectedArtworks') || '[]');

        this.#loadSelections();
        this.#getSelection();
        this.#displayBatchActions();
        this.#attachUncheckAllHandler();
    }

    // Function to load selected checkboxes from cookies
    #loadSelections() {
        this.selectedArtworks.forEach(id => {
            let checkbox = document.querySelector(`.form-batch-checkbox[value="${id}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    // Function to handle selection
    #getSelection() {
        let checkboxes = document.querySelectorAll('.form-batch-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.#updateSelection(checkbox.value, checkbox.checked);
            });
        });
    }

    // Function to update selection in the session
    #updateSelection(id, isSelected) {
        if (isSelected) {
            this.selectedArtworks.push(id);
        } else {
            this.selectedArtworks = this.selectedArtworks.filter(item => item !== id);
        }
        this.#setCookie('selectedArtworks', JSON.stringify(this.selectedArtworks), 1);
    }

    #getCookie(name) {
        let value = `; ${document.cookie}`;
        let parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    #setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = `; expires=${date.toUTCString()}`;
        }
        document.cookie = `${name}=${value || ""}${expires}; path=/`;
    }

    #displayBatchActions() {
        let batchActions = document.querySelector('.batch-actions');
        let dataGridFilters = document.querySelector('.datagrid-filters');
        let globalActions = document.querySelector('.global-actions');

        if (this.selectedArtworks.length > 0) {
            batchActions.classList.remove('d-none');
            batchActions.classList.add('d-block');

            dataGridFilters.classList.add('d-none');
            dataGridFilters.classList.remove('d-block');
            globalActions.classList.add('d-none');
            globalActions.classList.remove('d-block');

        } else {
            batchActions.classList.add('d-none');
        }
    }

    // Function to attach the uncheck all handler
    #attachUncheckAllHandler() {
        let uncheckAllButton = document.querySelector('#modal-batch-action-button-uncheck-all');
        if (uncheckAllButton) {
            uncheckAllButton.addEventListener('click', () => {
                this.#clearSelection();
            });
        }
    }

    // Function to clear the selection
    #clearSelection() {
        this.selectedArtworks = [];
        this.#setCookie('selectedArtworks', JSON.stringify(this.selectedArtworks), 1);

        let checkboxes = document.querySelectorAll('.form-batch-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        this.#displayBatchActions();
    }
}
