document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentarios', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            },
        })
        .then(response => {
            return response.json();
        })
        .then(valores => {
            comentarios = valores;
            console.log(valores)
            const comentariosValoracion3 = comentarios.filter(valores => valores.Valoracion === "3");

// Mostrar los comentarios filtrados en la consola
console.log(comentariosValoracion3);
            mostrarcomentarios();
        })

        function mostrarcomentarios(){
            let seccion = document.getElementById('contenedor');
            seccion.innerHTML = '';

            // Agrega los comentarios ordenados a la sección 'contenedor'
            comentarios.forEach(comentario => {
                let div = document.createElement("article");
                div.className = "contenedorlogin col-10 mb-4";
                seccion.appendChild(div);

                let nombre = document.createElement('h3');
                nombre.className = "negrita";
                let valoracionElemento = document.createElement('p');
                let comentariosElemento = document.createElement('p');

                nombre.innerHTML = comentario["Nombre_Usuario"];
                valoracionElemento.innerHTML = comentario["Valoracion"];
                comentariosElemento.innerHTML = comentario["Comentario"];

                div.appendChild(nombre);
                div.appendChild(comentariosElemento);

                let imagenes = document.createElement("div");
                div.appendChild(imagenes);

                for (let i = 0; i < comentario["Valoracion"]; i++) {
                    let valoracionElemento = document.createElement('img');
                    valoracionElemento.src = "Imagenes/Iconos/estrellarellena.svg";
                    valoracionElemento.className = "estrella";
                    imagenes.appendChild(valoracionElemento);
                }

                let estrellavacia = 5 - comentario["Valoracion"];
                for (let i = 0; i < estrellavacia; i++) {
                    let valoracionElemento = document.createElement('img');
                    valoracionElemento.src = "Imagenes/Iconos/estrella.svg";
                    valoracionElemento.className = "estrella";
                    imagenes.appendChild(valoracionElemento);
                }
            });
        }
        
        function ordenar(){
            // Obtiene el valor de orden seleccionado
            const ordenSeleccionado = document.querySelector('input[name="orden"]:checked').value;

            // Ordena los comentarios según la opción seleccionada
            comentarios.sort(function (a, b) {
                const valoracionA = a.Valoracion;
                const valoracionB = b.Valoracion;

                // Ordena ascendente o descendente según la opción seleccionada
                if (ordenSeleccionado == 'ascendente') {
                    return valoracionA - valoracionB;
                } else if(ordenSeleccionado == 'descendente'){
                    return valoracionB - valoracionA;
                }
            });
        }
        document.getElementById('ascendente').addEventListener('click', function(){
            ordenar();
            mostrarcomentarios();
        })
        document.getElementById('descendente').addEventListener('click', function(){
            ordenar();
            mostrarcomentarios();
        })
});