document.addEventListener('DOMContentLoaded', function() {
    fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentarios',{
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
    .then(response => {
        return response.json();
    })
    .then(pepe => {
        // Puedes hacer algo con los datos aquí
        let seccion = document.getElementById('contenedor');
        pepe.forEach(comentario => {
            let div = document.createElement("article");
            div.className="contenedorlogin col-10 mb-4"
            seccion.appendChild(div);
            let nombre = document.createElement('h3');
            nombre.className="negrita"
            let valoracionElemento = document.createElement('p');
            let comentariosElemento = document.createElement('p');
            nombre.innerHTML=comentario["Nombre_Usuario"];
            valoracionElemento.innerHTML=comentario["Valoracion"];
            comentariosElemento.innerHTML=comentario["Comentario"];
            div.appendChild(nombre);
            div.appendChild(comentariosElemento);
            let imagenes = document.createElement("div");
            div.appendChild(imagenes);
            for (let i = 0; i < comentario["Valoracion"]; i++) {
                let valoracionElemento = document.createElement('img');
                valoracionElemento.src = "Imagenes/Iconos/estrellarellena.svg";
                valoracionElemento.className="estrella"
                imagenes.appendChild(valoracionElemento);
            }
            let estrellavacia = 5-comentario["Valoracion"];
            for (let i = 0; i < estrellavacia; i++) {
                let valoracionElemento = document.createElement('img');
                valoracionElemento.src = "Imagenes/Iconos/estrella.svg";
                valoracionElemento.className="estrella"
                imagenes.appendChild(valoracionElemento);
            }

            
        });
    })
});
