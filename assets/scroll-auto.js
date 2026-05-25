document.addEventListener('DOMContentLoaded', () => {
    new ScrollAuto();
});

class ScrollAuto {
    constructor() {
        this.#getPreviousURL();
    }

    #getPreviousURL() {
        let previousURL = document.referrer;
        //let urlParams = new URLSearchParams(previousURL);
        //let entityIdParam = urlParams.get('entityId');

        let splitPreviewsURL = previousURL.split('/');
        let getSecondLastIndex = splitPreviewsURL.slice(-2)[0];

        this.#getRow(getSecondLastIndex);
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