document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        var alMenosUnCheckboxSeleccionado = false;
        document.querySelectorAll('input[type=checkbox]').forEach(function (currentCheckbox) {
            var nombreCheckbox = currentCheckbox.value;
            var elementos = document.querySelectorAll('.' + nombreCheckbox);
            var mostrar = currentCheckbox.checked;
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