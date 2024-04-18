const eaTableHandler = function (event) {
    document.querySelectorAll('button.field-table-add-button').forEach((addButton) => {
        const table = addButton.closest('[data-ea-table-field]');

        if (!table || table.classList.contains('processed')) {
            return;
        }

        EaTableProperty.handleAddButton(addButton, table);
        EaTableProperty.updateTableItemCssClasses(table);
    });

    document.querySelectorAll('button.field-table-delete-button').forEach((deleteButton) => {
        deleteButton.addEventListener('click', () => {
            const table = deleteButton.closest('[data-ea-table-field]');
            const item = deleteButton.closest('.field-table-item');

            item.remove();
            document.dispatchEvent(new Event('ea.table.item-removed'));

            EaTableProperty.updateTableItemCssClasses(table);
        });
    });
}

window.addEventListener('DOMContentLoaded', eaTableHandler);
document.addEventListener('ea.table.item-added', eaTableHandler);

const EaTableProperty = {
    handleAddButton: (addButton, table) => {
        addButton.addEventListener('click', function() {
            const isArrayTable = table.classList.contains('field-array');
            // Use a counter to avoid having the same index more than once
            let numItems = parseInt(table.dataset.numItems);

            // Remove the 'Empty Table' badge, if present
            const emptyTableBadge = this.parentElement.querySelector('.table-empty');
            if (null !== emptyTableBadge) {
                emptyTableBadge.outerHTML = isArrayTable ? '<div class="ea-form-table-items"></div>' : '<div class="ea-form-table-items"><div class="accordion"><div class="form-widget-compound"><div data-empty-table></div></div></div></div>';
            }

            const formTypeNamePlaceholder = table.dataset.formTypeNamePlaceholder;
            const labelRegexp = new RegExp(formTypeNamePlaceholder + 'label__', 'g');
            const nameRegexp = new RegExp(formTypeNamePlaceholder, 'g');

            let newItemHtml = table.dataset.prototype
                .replace(labelRegexp, ++numItems)
                .replace(nameRegexp, numItems);

            table.dataset.numItems = numItems;
            const newItemInsertionSelector = isArrayTable ? '.ea-form-table-items' : '.ea-form-table-items .accordion > .form-widget-compound [data-empty-table]';
            const tableItemsWrapper = table.querySelector(newItemInsertionSelector);

            tableItemsWrapper.insertAdjacentHTML('beforeend', newItemHtml);

            // Execute JS scripts embedded in prototype
            const tableItems = tableItemsWrapper.querySelectorAll('.field-table-item');
            const lastElement = tableItems[tableItems.length - 1];
            lastElement.querySelectorAll('script').forEach(script => eval(script.innerHTML));

            // for complex tables of items, show the newly added item as not collapsed
            if (!isArrayTable) {
                EaTableProperty.updateTableItemCssClasses(table);
                const lastElementCollapseButton = lastElement.querySelector('.accordion-button');
                lastElementCollapseButton.classList.remove('collapsed');
                const lastElementBody = lastElement.querySelector('.accordion-collapse');
                lastElementBody.classList.add('show');
            }

            document.dispatchEvent(new Event('ea.table.item-added'));
        });

        table.classList.add('processed');
    },

    updateTableItemCssClasses: (table) => {
        if (null === table) {
            return;
        }

        const tableItems = table.querySelectorAll('.field-table-item');
        tableItems.forEach((item) => item.classList.remove('field-table-item-first', 'field-table-item-last'));

        const firstElement = tableItems[0];
        if (undefined === firstElement) {
            return;
        }
        firstElement.classList.add('field-table-item-first');

        const lastElement = tableItems[tableItems.length - 1];
        if (undefined === lastElement) {
            return;
        }
        lastElement.classList.add('field-table-item-last');
    }
};
