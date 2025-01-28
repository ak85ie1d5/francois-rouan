document.addEventListener('DOMContentLoaded', (event) => {
    const activeItems = document.querySelectorAll('.umanit_easyadmintree_tree_field-item--active');
    if (activeItems.length > 0) {
        const parentItem = activeItems[0].parentElement.parentElement.previousElementSibling;
        if (parentItem) {
            parentItem.classList.add('umanit_easyadmintree_tree_field-item--active');
        }
    }
});