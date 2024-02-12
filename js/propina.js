
const propinaRadios = document.querySelectorAll('input[name="propina"]');
var valorpropina = 0; // Variable para almacenar la propina
var total = 0; // Variable para almacenar el total



document.addEventListener('DOMContentLoaded', function () {
    propinaRadios.forEach(radio => {
        if (radio.checked) {
            valorpropina = radio.value;
            calcularPrecioFinal().then(precioFinal => {
                const propina = valorpropina * precioFinal;
                total = parseFloat(propina) + parseFloat(precioFinal);
                document.getElementById('propina').innerText = propina.toFixed(2) + "€";
                document.getElementById('total').innerText = total.toFixed(2) + "€";
            });
        }
    });
});

propinaRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        valorpropina = this.value;
        calcularPrecioFinal().then(precioFinal => {
            const propina = valorpropina * precioFinal;
            total = parseFloat(propina) + parseFloat(precioFinal);
            document.getElementById('propina').innerText = propina.toFixed(2) + "€";
            document.getElementById('total').innerText = total.toFixed(2) + "€";
        });
    });
});

document.getElementById("botonComprar").addEventListener("click", function () {
    const data = {
        propina: valorpropina, // Aquí se utiliza la propina calculada
        total: total // Aquí se utiliza el total calculado
    };

    fetch('http://localhost/trabajojs/index.php?controller=API&action=comprar', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify(data)
    });
});

function calcularPrecioFinal() {
    return fetch('http://localhost/trabajojs/index.php?controller=API&action=preciototal', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
        .then(response => {
            return response.json();
        })
        .then(valores => {
            return valores;
        });
};


