const initDependOnFields = () => {
    let dependOnFieldsArray = Array.from(document.querySelectorAll('[data-depend-on]'));
    if (dependOnFieldsArray.length === 0) return;

    dependOnFieldsArray.forEach((field) => {
        // Éviter d'initialiser deux fois le même champ
        if (field.dataset.dependOnInitialized) return;
        field.dataset.dependOnInitialized = 'true';

        let dependOnField = field.getAttribute('data-depend-on');
        let dependOnValue = field.getAttribute('data-depend-on-value');

        let indexMatch = field.id.match(/_(\d+)_/);
        if (indexMatch) {
            let index = indexMatch[1];
            dependOnField = dependOnField.replace(/_\d+_/, `_${index}_`);
        }

        let inputCondition = document.getElementById(dependOnField);

        if (!inputCondition) {
            console.warn(`Élément introuvable : ${dependOnField}`);
            return;
        }

        const toggleFieldVisibility = () => {
            let inputValue = inputCondition.value;

            if (inputValue !== dependOnValue) {
                field.style.display = 'none';

                if (field.nodeName === 'DIV') {
                    let inputs = field.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.removeAttribute('required');
                        input.value = '';
                    });
                } else {
                    field.value = '';
                }
            } else {
                field.style.display = 'block';

                let inputs = field.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.setAttribute('required', 'required');
                    input.disabled = false;
                });
            }
        };

        toggleFieldVisibility();
        inputCondition.addEventListener('change', toggleFieldVisibility);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    // Tentative initiale (pour les formulaires classiques)
    initDependOnFields();

    // Observer pour EasyAdmin qui injecte les filtres dynamiquement
    const observer = new MutationObserver(() => {
        initDependOnFields();
    });

    observer.observe(document.body, { childList: true, subtree: true });
});