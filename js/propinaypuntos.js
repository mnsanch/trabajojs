
const propinaRadios = document.querySelectorAll('input[name="propina"]');
let valorpropina = 0; // Variable para almacenar la propina
let total = 0; // Variable para almacenar el total
let puntos = 0;
let puntostotales = 0;
let puntosconseguidos = 0;





document.addEventListener('DOMContentLoaded', function () {

    fetch('http://localhost/trabajojs/index.php?controller=API&action=cogerpuntosusuario', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            },
        })
        .then(response => {
            return response.json();
        })
        .then(valores => {
            puntostotales = valores;
            document.getElementById('puntosbd').innerHTML = valores;

        })


    propinaRadios.forEach(radio => {
        if (radio.checked) {
            valorpropina = radio.value;
            propina(valorpropina);
        }
    });
});

propinaRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        valorpropina = this.value;
        propina(valorpropina);
        
        
    });
});

function propina(valorpropina){
    calcularPrecioFinal().then(precioFinal => {
        const propina = valorpropina * precioFinal;
        total = parseFloat(propina) + parseFloat(precioFinal)- puntos;
        document.getElementById('propina').innerText = propina.toFixed(2) + "€";
        document.getElementById('total').innerText = total.toFixed(2) + "€";

        if (puntos>puntostotales) {
            let formulario = document.getElementById("textopuntos");
            formulario.value = ""; 
            total = parseFloat(propina) + parseFloat(precioFinal);
            // document.getElementById('total').innerText = total.toFixed(2) + "€";
            total = parseFloat(propina) + parseFloat(precioFinal);
            document.getElementById('total').innerText = total.toFixed(2) + "€";
            document.getElementById('puntos').innerText = "-"+0+"€ ";
            puntos=0;
            puntosconseguidos = parseInt(total/10);
            document.getElementById('qwerty').innerhtml = "Vas a conseguir "+ puntosconseguidos+ " puntos";
        
            notie.alert({
                type: 'error',
                text: 'No puedes gastar mas puntos de los que tienes',
                time: 3
            });
            return;
        }
        // Actualiza el contenido del elemento con el ID "propina"
        document.getElementById('puntos').innerText = "-"+puntos+"€ ";
        if (puntos>precioFinal) {
            document.getElementById('total').innerText = 0+ "€";
            total=0;
            
        }else if ((isNaN(puntos))) {
            total = parseFloat(propina) + parseFloat(precioFinal);
            document.getElementById('total').innerText = total.toFixed(2) + "€";
            document.getElementById('puntos').innerText = "-"+0+"€ ";

            
        }else{
            document.getElementById('total').innerText = total.toFixed(2) + "€";
        }

            puntosconseguidos = parseInt(total/10);
            document.getElementById('qwerty').innerHTML =  "Vas a conseguir "+ puntosconseguidos+ " puntos";

    });
}

document.getElementById("botonComprar").addEventListener("click", function () {
    const data = {
        propina: valorpropina, // Aquí se utiliza la propina calculada
        total: total, // Aquí se utiliza el total calculado
        puntos: puntos,
        puntostotales: puntostotales, // Aquí se utiliza el total calculado
        puntosconseguidos: puntosconseguidos // Aquí se utiliza el total calculado
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

document.getElementById('si').addEventListener('click', function(){
    if (puntostotales==0) {
        notie.alert({
            type: 'error',
            text: 'No tienes puntos para gastar',
            time: 3
        });
        no = document.getElementById('no')
        no.checked = true;
        return;
    }
    let formulario = document.getElementById("textopuntos");
    formulario.removeAttribute("disabled");
})
document.getElementById('no').addEventListener('click', function(){
    let formulario = document.getElementById("textopuntos");
    formulario.value = ""; 
    formulario.setAttribute("disabled", true);
    document.getElementById('puntos').innerText = "-"+0+"€ ";
    puntos = 0;
    calcularPrecioFinal().then(precioFinal => {
        const propina = valorpropina * precioFinal;
        total = parseFloat(propina) + parseFloat(precioFinal);
        document.getElementById('propina').innerText = propina.toFixed(2) + "€";
        document.getElementById('total').innerText = total.toFixed(2) + "€";
        puntosconseguidos = parseInt(total/10);
        document.getElementById('qwerty').innerHTML = "Vas a conseguir "+ puntosconseguidos+ " puntos";

    })


    
})
document.getElementById('textopuntos').addEventListener('input', function() {
    // Obtiene el valor ingresado en el campo de texto
    puntos = parseInt(this.value);
    propina(valorpropina);

    

});


