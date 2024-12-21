document.addEventListener('DOMContentLoaded', () => {
    new ScrollAuto();
});

class ScrollAuto {
    constructor() {
        this.#getPreviousURL();
    }

    #getPreviousURL() {
        let previousURL = document.referrer;
        let urlParams = new URLSearchParams(previousURL);
        let entityIdParam = urlParams.get('entityId');

        if (entityIdParam) {
            this.#getRow(entityIdParam);
        }
    }

    #getRow(entityId) {
        let row = document.querySelector(`[data-id="${entityId}"]`);

        if (row) {
            setTimeout(() => {
                row.scrollIntoView({ behavior: 'instant' });
            }, 500);
        }
    }
}