document.addEventListener('DOMContentLoaded', function () {
    let comentarios = ""
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="estrella"]');
    let estrellasSeleccionadas = [];
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
            mostrarcomentarios(valores);
        })

        function mostrarcomentarios(valores){
            if (valores.length==0) {
            const seccion = document.getElementById('contenedor');
            seccion.innerHTML = '';
            const nombre = document.createElement('h3');
            nombre.className = "contenedorlogin col-10 mb-4";
            nombre.innerHTML = "No hay ningun comentario con estas caracteristicas";
            seccion.appendChild(nombre);
            }else{
                const seccion = document.getElementById('contenedor');
                seccion.innerHTML = '';

                // Agrega los comentarios ordenados a la sección 'contenedor'
                valores.forEach(valores => {
                    const div = document.createElement("article");
                    div.className = "contenedorlogin col-10 mb-4";
                    seccion.appendChild(div);

                    const nombre = document.createElement('h3');
                    nombre.className = "negrita";
                    const valoracionElemento = document.createElement('p');
                    const comentariosElemento = document.createElement('p');

                    nombre.innerHTML = valores["Nombre_Usuario"];
                    valoracionElemento.innerHTML = valores["Valoracion"];
                    comentariosElemento.innerHTML = valores["Comentario"];

                    div.appendChild(nombre);
                    div.appendChild(comentariosElemento);

                    const imagenes = document.createElement("div");
                    div.appendChild(imagenes);

                    for (let i = 0; i < valores["Valoracion"]; i++) {
                        const valoracionElemento = document.createElement('img');
                        valoracionElemento.src = "Imagenes/Iconos/estrellarellena.svg";
                        valoracionElemento.className = "estrella";
                        imagenes.appendChild(valoracionElemento);
                    }

                    const estrellavacia = 5 - valores["Valoracion"];
                    for (let i = 0; i < estrellavacia; i++) {
                        const valoracionElemento = document.createElement('img');
                        valoracionElemento.src = "Imagenes/Iconos/estrella.svg";
                        valoracionElemento.className = "estrella";
                        imagenes.appendChild(valoracionElemento);
                    }
                });
            }
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
            mostrarcomentarios(comentarios);
            if (estrellasSeleccionadas.length > 0) {
                filtrarporestrellas();
            }        })
        document.getElementById('descendente').addEventListener('click', function(){
            ordenar();
            mostrarcomentarios(comentarios);
            if (estrellasSeleccionadas.length > 0) {
                filtrarporestrellas();
            }
        })

        document.getElementById('usuario').addEventListener('change', function () {
            const usuario = document.getElementById('usuario').value;
            if (usuario == 'Todos') {
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

                    mostrarcomentarios(valores);
                    filtrarporestrellas();
                })
            }else if (usuario == 'Anonimo') {
                fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentariosanonimos', {
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
                    
                    mostrarcomentarios(valores);
                    // filtrarporestrellas();
                })
            }else if (usuario == 'Validado') {
                fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentariosvalidados', {
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
                    
                    mostrarcomentarios(valores);
                    filtrarporestrellas();
                })
            }
        });

        function filtrarporestrellas() {
            valores = comentarios.filter(sol => estrellasSeleccionadas.includes(parseInt(sol.Valoracion)));
            
                mostrarcomentarios(valores);
                if (estrellasSeleccionadas.length == 0) {
                    const usuario = document.getElementById('usuario').value;
            if (usuario == 'Todos') {
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

                    mostrarcomentarios(valores);
                })
            }else if (usuario == 'Anonimo') {
                fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentariosanonimos', {
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
                    
                    mostrarcomentarios(valores);
                })
            }else if (usuario == 'Validado') {
                fetch('http://localhost/trabajojs/index.php?controller=API&action=mostrarcomentariosvalidados', {
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
                    
                    mostrarcomentarios(valores);
                })
            }              
                }
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const valor = parseInt(this.value);
                if (this.checked) {
                    estrellasSeleccionadas.push(valor);
                } else {
                    estrellasSeleccionadas = estrellasSeleccionadas.filter(item => item !== valor);
                }
                estrellasSeleccionadas.sort((a, b) => a - b); // Ordenar el array
                filtrarporestrellas();
                // Aquí aplicamos el filtrado de comentarios con la nueva array de estrellas seleccionadas
                
            });
        });
        
});