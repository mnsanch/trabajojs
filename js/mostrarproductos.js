// Se hace un bucle con todos los checkbox
document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
    // Cuando se nota una cambio en uno de ellos se ejecuta el codigo
    checkbox.addEventListener('change', function () {
        // Se crea una variable por si no hay ninguno pulsado
        let alMenosUnCheckboxSeleccionado = false;
        // Se miran los checkbox que se han pulsado
        document.querySelectorAll('input[type=checkbox]').forEach(function (currentCheckbox) {
            // Se guarda el valor del checkbox
            const nombreCheckbox = currentCheckbox.value;
            // Se guarda los elementos de la pagina que tengaun una classe con el nombre del valor del checkbox
            const elementos = document.getElementsByClassName(nombreCheckbox);
            // Si el checkbox que se mira esta pulsado se pone en true
            const mostrar = currentCheckbox.checked;
            // Si el checkbox que esta mirando esta activado hara el if
            if (mostrar== true) {
                // transforma la variable creada en true porque hay un elemento seleccionado
                alMenosUnCheckboxSeleccionado = true;
            }
            // Hace un bucle para que mire todos los elementos guardados en la variable elementos
            for (i = 0; i < elementos.length; i++) {
                // Si el checkbox con el valor mismo valor que los elementos esta activo les quita el estilo que los vuelve invisible
                if (mostrar==true) {
                    elementos[i].style.display = '';
                    // Si el checkbox con el valor mismo valor que los elementos esta desactivado vuelve los elementos invisibles
                } else {
                    elementos[i].style.display = 'none';
                }
            }
        });
        // Si todos los checkbox estan desactivados a todos los elementos de la pagina les quita el estilo que los vuelve invisible
        if (alMenosUnCheckboxSeleccionado == false) {
            document.querySelectorAll('*').forEach(elemento => { elemento.style.display = ''; });
        }
    });
});