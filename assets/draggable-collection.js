import Sortable from 'sortablejs';

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('draggable-collection')) {
        new DraggableCollection
    }

});

class DraggableCollection {
    constructor() {
        this.#sortableJSInit(this.#getParentElement())
        this.#updatePositions(this.#getDraggableElements(this.#getParentElement()))
        this.#onParentMutation(this.#getParentElement())
    }

    #sortableJSInit(el) {
        return new Sortable(el, {
            animation: 150,
            ghostClass: 'blue-background-class'
        });
    }

    #onParentMutation(draggableElements) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList') {
                    this.#handleDragEnd(draggableElements);
                }
            })
        })
        observer.observe(draggableElements, { childList: true });
    }

    #updatePositions(draggableElements) {
        for (let i = 0; i < draggableElements.length; i++) {
            const element = draggableElements[i];
            element.addEventListener('dragend', this.#handleDragEnd);
        }
    }

    #handleDragEnd(event) {
        //let DraggableElements = event.target.parentElement.children
        let DraggableElements = this.#getDraggableElements(this.#getParentElement())

        for (let i = 0; i < DraggableElements.length; i++) {
            const element = DraggableElements[i];
            const inputPosition = element.querySelector('input[id$="_position"]')
            inputPosition.value = i;
        }
    }

    #getParentElement() {
        return document.getElementById('draggable-collection').children[0].children[0];
    }

    #getDraggableElements(ParentElement) {
        return ParentElement.children;
    }
}