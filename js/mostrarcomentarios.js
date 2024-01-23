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
        console.log(pepe);
        let seccion = document.getElementById('contenedor');
        pepe.forEach(comentario => {
            let div = document.createElement("div");
            div.className="contenedorlogin col-10 mb-4"
            seccion.appendChild(div);
            let nombre = document.createElement('h3');
            let valoracionElemento = document.createElement('p');
            let comentariosElemento = document.createElement('p');
            nombre.innerHTML=comentario["Nombre_Usuario"];
            valoracionElemento.innerHTML=comentario["Valoracion"];
            comentariosElemento.innerHTML=comentario["Comentario"];
            div.appendChild(nombre);
            div.appendChild(comentariosElemento);
            div.appendChild(valoracionElemento);
        });
    })
});
