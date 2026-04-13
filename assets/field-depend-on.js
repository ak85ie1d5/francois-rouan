document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('[data-depend-on]')) {

        let dependOnFieldsArray = Array.from(document.querySelectorAll('[data-depend-on]'));

        dependOnFieldsArray.forEach((field) => {
            let dependOnField = field.getAttribute('data-depend-on');
            let dependOnValue = field.getAttribute('data-depend-on-value');

            // Correction : si le champ appartient à une collection (_1_, _2_...),
            // remplacer l'index dans data-depend-on par l'index réel du champ
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
    }
});
