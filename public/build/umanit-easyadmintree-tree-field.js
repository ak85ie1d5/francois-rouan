document.addEventListener('DOMContentLoaded', (event) => {
    const activeItems = document.querySelectorAll('.umanit_easyadmintree_tree_field-item--active');



    const parentItem = activeItems[0].parentElement.parentElement.previousElementSibling;

    parentItem.classList.add('umanit_easyadmintree_tree_field-item--active');
});