document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('[data-depend-on]')) {

        let dependOnFieldsArray = Array.from(document.querySelectorAll('[data-depend-on]'));

        dependOnFieldsArray.forEach((field) => {
            let dependOnField = field.getAttribute('data-depend-on');
            let dependOnValue = field.getAttribute('data-depend-on-value');

            let inputCondition = document.getElementById(dependOnField);

            const toggleFieldVisibility = () => {
                let inputValue = inputCondition.value;

                if (inputCondition && inputValue !== dependOnValue) {
                    field.style.display = 'none';

                    // Vider les inputs du champ masqué
                    if (field.nodeName === 'DIV') {
                        let inputs = field.querySelectorAll('input, select, textarea');
                        inputs.forEach(input => {
                            input.removeAttribute('required');
                            input.value = '';
                        });
                    } else {
                        //field.removeAttribute('required');
                        field.value = '';
                    }

                } else {
                    field.style.display = 'block';
                    //field.setAttribute('required', 'required');

                    // Réactiver les inputs
                    let inputs = field.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.setAttribute('required', 'required');
                        input.disabled = false;
                    });
                }
            };

            // Appliquer la visibilité initiale
            toggleFieldVisibility();

            // Écouter les changements de valeur
            if (inputCondition) {
                inputCondition.addEventListener('change', toggleFieldVisibility);
            }
        });
    }
});