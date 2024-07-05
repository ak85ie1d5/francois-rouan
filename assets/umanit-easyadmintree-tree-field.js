document.addEventListener('DOMContentLoaded', function() {
    const treeFields = document.querySelectorAll('.umanit-easyadmintree-tree-field');
    treeFields.forEach(treeField => {
        const treeFieldInput = treeField.querySelector('input[type="hidden"]');
        const treeFieldSelect = treeField.querySelector('select');
        const treeFieldSelectOptions = treeFieldSelect.querySelectorAll('option');
        const treeFieldSelectOptionsArray = Array.from(treeFieldSelectOptions);
        treeFieldSelectOptionsArray.forEach(option => {
            option.value = option.getAttribute('data-id');
        });
        treeFieldSelect.addEventListener('change', function() {
            treeFieldInput.value = treeFieldSelect.value;
        });
    });
}