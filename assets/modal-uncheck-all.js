document.addEventListener('DOMContentLoaded', () => {
    window.EasyAdminApp = new ModalUncheckAll();
});

class ModalUncheckAll {

    constructor() {
        this.#createBatchActions();
    }

    #createBatchActions() {
        const modalTitle = document.querySelector('#batch-action-confirmation-title-uncheck-all');
        const titleContentWithPlaceholders = modalTitle.textContent;

        document.querySelectorAll('[data-action-batch]').forEach((dataActionBatch) => {
            dataActionBatch.addEventListener('click', (event) => {
                event.preventDefault();

                const actionElement = event.currentTarget;
                const actionName = actionElement.textContent.trim() || actionElement.getAttribute('title');
                const selectedItems = document.querySelectorAll('input[type="checkbox"].form-batch-checkbox:checked');
                modalTitle.textContent = titleContentWithPlaceholders
                    .replace('%action_name%', actionName)
                    .replace('%num_items%', selectedItems.length.toString());

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