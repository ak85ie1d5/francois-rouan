document.addEventListener('DOMContentLoaded', () => {
    window.EasyAdminApp = new ModalUncheckAll();
});

class ModalUncheckAll {

    constructor() {
        this.#createBatchActions();
    }

    #getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    #countSelectedArtworks() {
        const cookieValue = this.#getCookie('selectedArtworks');
        if (cookieValue) {
            try {
                const artworksArray = JSON.parse(cookieValue);
                return Array.isArray(artworksArray) ? artworksArray.length : 0;
            } catch (e) {
                console.error('Error parsing selectedArtworks cookie:', e);
                return 0;
            }
        }
        return 0;
    }

    #createBatchActions() {
        const modalTitle = document.querySelector('#batch-action-confirmation-title-uncheck-all');
        const titleContentWithPlaceholders = modalTitle.textContent;

        document.querySelectorAll('[data-action-batch]').forEach((dataActionBatch) => {
            dataActionBatch.addEventListener('click', (event) => {
                event.preventDefault();

                const actionElement = event.currentTarget;
                const actionName = actionElement.textContent.trim() || actionElement.getAttribute('title');
                const selectedItems = this.#countSelectedArtworks();
                modalTitle.textContent = titleContentWithPlaceholders
                    .replace('%action_name%', actionName)
                    .replace('%num_items%', selectedItems.toString());

                document.querySelector('#modal-batch-action-button-uncheck-all').addEventListener('click', () => {
                    actionElement.setAttribute('disabled', 'disabled');

                    const batchFormFields = {
                        'batchActionName': actionElement.getAttribute('data-action-name'),
                        'entityFqcn': actionElement.getAttribute('data-entity-fqcn'),
                        'batchActionUrl': actionElement.getAttribute('data-action-url'),
                        'batchActionCsrfToken': actionElement.getAttribute('data-action-csrf-token'),
                    };

                    selectedItems.forEach((item, i) => {
                        batchFormFields[`batchActionEntityIds[${i}]`] = item.value;
                    });

                    const batchForm = document.createElement('form');
                    batchForm.setAttribute('method', 'POST');
                    batchForm.setAttribute('action', actionElement.getAttribute('data-action-url'));
                    for (let fieldName in batchFormFields) {
                        const formField = document.createElement('input');
                        formField.setAttribute('type', 'hidden');
                        formField.setAttribute('name', fieldName);
                        formField.setAttribute('value', batchFormFields[fieldName]);
                        batchForm.appendChild(formField);
                    }

                    document.body.appendChild(batchForm);
                    batchForm.submit();
                });
            });
        });
    }
}