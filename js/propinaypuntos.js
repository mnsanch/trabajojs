// Creamos variables para guardar los datos que usaremos
const propinaRadios = document.querySelectorAll('input[name="propina"]');
let valorpropina = 0;
let total = 0;
let puntos = 0;
let puntostotales = 0;
let puntosconseguidos = 0;

document.addEventListener('DOMContentLoaded', function () {
    // Llamamos a la api para recoger los puntos que tiene el usuario 
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
            // Guardamos los puntos en una variable
            puntostotales = valores;
            // Mostramos los puntos del usuario
            document.getElementById('puntosbd').innerHTML = valores;

        })

        // Miramos que propina está seleccionada y guardamos su valor
    propinaRadios.forEach(radio => {
        if (radio.checked) {
            valorpropina = radio.value;
            // Llamamos a la funcion propina 
            propina(valorpropina);
        }
    });
});

// Cada vez que la propina seleccionada se modifica se cambia el valor de la propina 
propinaRadios.forEach(radio => {
    radio.addEventListener('change', function () {
        valorpropina = this.value;
        // llamamos a la funcion propina 
        propina(valorpropina);
        
        
    });
});

// Funcion para hacer los calculos y imprimir los valores de puntos, propina y total
function propina(valorpropina){
    calcularPrecioFinal().then(precioFinal => {
        // Se calcula la propina
        const propina = valorpropina * precioFinal;
        // Se calcula el precio final
        total = parseFloat(propina) + parseFloat(precioFinal)- puntos;
        // Se inserta la propina y el precio final
        document.getElementById('propina').innerText = propina.toFixed(2) + "€";
        document.getElementById('total').innerText = total.toFixed(2) + "€";
        // Si los puntos que quiere gastar el usuario son negativos
        if (puntos<0) {
            // Se limpia el sitio de escribir los puntos para que este vacio
            let formulario = document.getElementById("textopuntos");
            formulario.value = ""; 
            // Se calcula el precio total sin puntos
            total = parseFloat(propina) + parseFloat(precioFinal);
            // Se modifica el valor total y se ponen los puntos a 0
            document.getElementById('total').innerText = total.toFixed(2) + "€";
            document.getElementById('puntos').innerText = "-"+0+"€ ";
            puntos=0;
            // Se hace el calculo de los puntos conseguidos y se insereta en la pagina
            puntosconseguidos = parseInt(total/10);
            document.getElementById('puntosconseguidos').innerHTML = "Vas a conseguir "+ puntosconseguidos+ " puntos";
            // Mensaje de error 
            notie.alert({
                type: 'error',
                text: 'No puedes gastar puntos negativos',
                time: 3
            });
            return;
        }
        // Si los puntos que quiere gastar son mas de los que tiene entrara aqui
        if (puntos>puntostotales) {
            // Se limpia el sitio de escribir los puntos para que este vacio
            let formulario = document.getElementById("textopuntos");
            formulario.value = ""; 
            // Se calcula el precio total sin puntos
            total = parseFloat(propina) + parseFloat(precioFinal);
            // Se modifica el valor total y se ponen los puntos a 0
            document.getElementById('total').innerText = total.toFixed(2) + "€";
            document.getElementById('puntos').innerText = "-"+0+"€ ";
            puntos=0;
            // Se hace el calculo de los puntos conseguidos y se insereta en la pagina
            puntosconseguidos = parseInt(total/10);
            document.getElementById('puntosconseguidos').innerHTML = "Vas a conseguir "+ puntosconseguidos+ " puntos";
            // Mensaje de error
            notie.alert({
                type: 'error',
                text: 'No puedes gastar mas puntos de los que tienes',
                time: 3
            });
            return;
        }
        // Se insertan los puntos que se gastan
        document.getElementById('puntos').innerText = "-"+puntos+"€ ";
        // Si los puntos gastados es mayor a el precio + la propina  entrara aqui
        if (puntos>(parseFloat(propina) + parseFloat(precioFinal))) {
            // Se modifica el precio final a cero y se inserta en la pagina
            document.getElementById('total').innerText = 0+ "€";
            total=0;
        // Si se borra los puntos que quieres gastar
        }else if ((isNaN(puntos))) {
            // Se calcula el precio final sin puntos y se inserta el la web
            total = parseFloat(propina) + parseFloat(precioFinal);
            document.getElementById('total').innerText = total.toFixed(2) + "€";
            document.getElementById('puntos').innerText = "-"+0+"€ ";

            
        }
            // Se hace el calculo de los puntos conseguidos y se insereta en la pagina
            puntosconseguidos = parseInt(total/10);
            document.getElementById('puntosconseguidos').innerHTML =  "Vas a conseguir "+ puntosconseguidos+ " puntos";

    });
}

document.getElementById("botonComprar").addEventListener("click", function () {
    // Si se pulsa el boton de comrar se guardan todas las variables y se envian por JSON a la api
    const data = {
        propina: valorpropina, 
        total: total, 
        puntos: puntos,
        puntostotales: puntostotales,
        puntosconseguidos: puntosconseguidos 
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
    // Llamamos a la api para recibir el precio total que cuesta el pedido 
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

// Esto se hará cuando pulses el boton de si en los puntos
document.getElementById('si').addEventListener('click', function(){
    // Si quieres gastar puntos y no tienes salta un notie diciendote que no puedes
    if (puntostotales==0) {
        notie.alert({
            type: 'error',
            text: 'No tienes puntos para gastar',
            time: 3
        });
        // Se vuelve a selccionar el no
        no = document.getElementById('no')
        no.checked = true;
        return;
    }
    // Se habilita la opcion de esribir los puntos que quieres gastar 
    let formulario = document.getElementById("textopuntos");
    formulario.removeAttribute("disabled");
})

// Esto se hará cuando pulses el boton de si en los puntos
document.getElementById('no').addEventListener('click', function(){
    // Limpiamos lo que hay dentro del si y lo desabilitamos
    let formulario = document.getElementById("textopuntos");
    formulario.value = ""; 
    formulario.setAttribute("disabled", true);
    // Ponemos los puntos a cero
    document.getElementById('puntos').innerText = "-"+0+"€ ";
    puntos = 0;
    // Se imprimen en sus diferentes lugares los puntos que se gastan, la propina y el precio total
    calcularPrecioFinal().then(precioFinal => {
        // Se calcula la propina
        const propina = valorpropina * precioFinal;
        // Se calcula el precio final sin los puntos
        total = parseFloat(propina) + parseFloat(precioFinal);
        // Se insertan los valores en su lugar correspondiente
        document.getElementById('propina').innerText = propina.toFixed(2) + "€";
        document.getElementById('total').innerText = total.toFixed(2) + "€";
        // Se hace el calculo de los puntos conseguidos y se insereta en la pagina
        puntosconseguidos = parseInt(total/10);
        document.getElementById('puntosconseguidos').innerHTML = "Vas a conseguir "+ puntosconseguidos+ " puntos";

    })   
})

document.getElementById('textopuntos').addEventListener('input', function() {
    // Obtiene el valor ingresado en el campo de texto
    puntos = parseInt(this.value);
    // Llamamos a la funcion propina 
    propina(valorpropina);
});


