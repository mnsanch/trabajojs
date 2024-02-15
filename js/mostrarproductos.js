// array

document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        let alMenosUnCheckboxSeleccionado = false;
        document.querySelectorAll('input[type=checkbox]').forEach(function (currentCheckbox) {
            const nombreCheckbox = currentCheckbox.value;
            const elementos = document.querySelectorAll('.' + nombreCheckbox);
            const mostrar = currentCheckbox.checked;
            if (mostrar) {
                alMenosUnCheckboxSeleccionado = true;
            }
            for (i = 0; i < elementos.length; i++) {
                if (mostrar) {
                    elementos[i].style.display = '';
                } else {
                    elementos[i].style.display = 'none';
                }
            }
        });
        if (alMenosUnCheckboxSeleccionado == false) {
            document.querySelectorAll('*').forEach(elemento => { elemento.style.display = ''; });
        }
    });
});