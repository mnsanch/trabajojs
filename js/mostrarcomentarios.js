document.addEventListener('DOMContentLoaded', function () {
    // Creamos las variables que usaremos
    let comentarios = ""
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="estrella"]');
    let estrellasSeleccionadas = [];
    // Se hace un llamado a la api para que nos de todos los comentarios de la base de datos
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
            // Se guardan los comentarios en la variable comentarios
            comentarios = valores;
            // Se llama a la funcion mostrarcomentarios
            mostrarcomentarios(valores);
        })

        // Funcion mostrarcomentarios
        function mostrarcomentarios(valores){
            if (valores.length==0) {
                // Si ningun comentario cumple los filtros establecidos se pone un mensaje 
                const seccion = document.getElementById('contenedor');
                seccion.innerHTML = '';
                const nombre = document.createElement('h3');
                nombre.className = "contenedorlogin col-10 mb-4";
                nombre.innerHTML = "No hay ningun comentario con estas caracteristicas";
                seccion.appendChild(nombre);
            }else{
                // Se limpia la pagina
                const seccion = document.getElementById('contenedor');
                seccion.innerHTML = '';
                
                // Se hace un bucle en los comentarios 
                valores.forEach(valores => {
                    // Se crea un article para coneter cada comentario
                    const div = document.createElement("article");
                    div.className = "contenedorlogin col-10 mb-4";
                    seccion.appendChild(div);

                    // Se crean los elementos donde se pondran cada parte del comentario
                    const nombre = document.createElement('h3');
                    nombre.className = "negrita";
                    const valoracionElemento = document.createElement('p');
                    const comentariosElemento = document.createElement('p');

                    // Se pone el valor dentro del elemento correspondiente
                    nombre.innerHTML = valores["Nombre_Usuario"];
                    valoracionElemento.innerHTML = valores["Valoracion"];
                    comentariosElemento.innerHTML = valores["Comentario"];

                    // Se añaden el nombre y el comentario
                    div.appendChild(nombre);
                    div.appendChild(comentariosElemento);

                    // Se crea un contenedor para las estrellas 
                    const imagenes = document.createElement("div");
                    div.appendChild(imagenes);

                    // se hace un bucle para insertar las estrellas que estaran coloreadas que seran tantas como valoracion tenga el comentario
                    for (let i = 0; i < valores["Valoracion"]; i++) {
                        const valoracionElemento = document.createElement('img');
                        valoracionElemento.src = "Imagenes/Iconos/estrellarellena.svg";
                        valoracionElemento.className = "estrella";
                        imagenes.appendChild(valoracionElemento);
                    }

                    // Se acaban de rellenar las estrellas con estrellas vacias hasta llegar a cinco
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
        
        // Funcion ordenar
        function ordenar(){
            // Obtiene el valor de orden seleccionado
            const ordenSeleccionado = document.querySelector('input[name="orden"]:checked').value;

            comentarios.sort(function (a, b) {
                // Se obtiene las valoraciones de los comentarios a comparar
                const valoracionA = a.Valoracion;
                const valoracionB = b.Valoracion;

                // Ordena ascendente o descendente según la opcion seleccionada
                if (ordenSeleccionado == 'ascendente') {
                    return valoracionA - valoracionB;
                } else if(ordenSeleccionado == 'descendente'){
                    return valoracionB - valoracionA;
                }
            });
        }
        document.getElementById('ascendente').addEventListener('click', function(){
            // Se llama a la funcion ordenar
            ordenar();
            // Se llama a la funcion mostrarcomentarios
            mostrarcomentarios(comentarios);
            if (estrellasSeleccionadas.length > 0) {
                // Se llama a la funcion filtrarporestrellas
                filtrarporestrellas();
            }        })
        document.getElementById('descendente').addEventListener('click', function(){
            // Se llama a la funcion ordenar
            ordenar();
            // Se llama a la funcion mostrarcomentarios
            mostrarcomentarios(comentarios);
            if (estrellasSeleccionadas.length > 0) {
                // Se llama a la funcion filtrarporestrellas
                filtrarporestrellas();
            }
        })

        document.getElementById('usuario').addEventListener('change', function () {
            // Si hay un cambio en el filtro de usuario se mira que usuario esta seleccionado para mostrar todos los comentarios con esas caracteristicas
            const usuario = document.getElementById('usuario').value;
            if (usuario == 'Todos') {
                // Si esta seleccionado el Todos se llama a la api para que mustre todos los comentarios
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
                    // Se llama a la funcion filtrarporestrellas
                    filtrarporestrellas();
                })
            }else if (usuario == 'Anonimo') {
                // Si esta seleccionado el Anonimo se llama a la api para que mustre todos los comentarios de los anonimos
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
                    // Se llama a la funcion filtrarporestrellas
                    filtrarporestrellas();
                })
            }else if (usuario == 'Validado') {
                // Si esta seleccionado el Validado se llama a la api para que mustre todos los comentarios de los no anonimos
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
                    // Se llama a la funcion filtrarporestrellas
                    filtrarporestrellas();
                })
            }
        });

        function filtrarporestrellas() {
            valores = comentarios.filter(comentario => estrellasSeleccionadas.includes(parseInt(comentario.Valoracion)));
            // Se llama a la funcion mostrarcomentarios
            mostrarcomentarios(valores);
            if (estrellasSeleccionadas.length == 0) {
                // Si la array de estrellas esta vacia se mira que usuario esta seleccionado para mostrar todos los comentarios con esas caracteristicas
                const usuario = document.getElementById('usuario').value;
                if (usuario == 'Todos') {
                    // Si esta seleccionado el Todos se llama a la api para que mustre todos los comentarios
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
                        // Se llama a la funcion mostrarcomentarios
                        mostrarcomentarios(valores);
                    })
                }else if (usuario == 'Anonimo') {
                    // Si esta seleccionado el Anonimo se llama a la api para que mustre todos los comentarios de los anonimos
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
                        // Se llama a la funcion mostrarcomentarios
                        mostrarcomentarios(valores);
                    })
                }else if (usuario == 'Validado') {
                    // Si esta seleccionado el Validado se llama a la api para que mustre todos los comentarios de los no anonimos
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
                        // Se llama a la funcion mostrarcomentarios  
                        mostrarcomentarios(valores);
                    })
                }              
            }
        }
        // Se hace un bucle de los checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Si algun checkbox se selecciona o se deselecciona se guarda en la variable
                const valor = parseInt(this.value);
                if (this.checked) {
                    // Si se selecciona se añade su valor a la array de estrellas
                    estrellasSeleccionadas.push(valor);
                } else {
                    // Si se deseleccina se quita su valor de la array de estrellas
                    estrellasSeleccionadas = estrellasSeleccionadas.filter(item => item != valor);
                }
                // Se llama a la funcion filtrarporestrellas
                filtrarporestrellas();
                
            });
        });
        
});