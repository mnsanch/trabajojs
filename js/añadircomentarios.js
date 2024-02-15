document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost/trabajojs/index.php?controller=API&action=cogernombreusuario', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json; charset=UTF-8',
            },
        })
        .then(response => {
            return response.json();
        })
        .then(valores => {
            if (valores!=false) {
                const select = document.getElementById('nombre');
                const option = document.createElement('option');
                option.innerHTML = valores;
                select.appendChild(option);
            }           

        })

    
})

document.getElementById("botonaceptar").addEventListener("click", function () {
    // Obtener los valores del formulario
    const nombre = document.getElementById("nombre").value;
    const comentario = document.getElementById("comentario").value;
    const valoracion = document.querySelector('input[name="puntuacion"]:checked').value;

    
        // Validaremos que todos los campos estén completos antes de procesar el comentario:
        if (!nombre || !comentario || !valoracion) {
       
          // Mostraremos un mensaje de error en el caso de que no complete todos los campos del formulario:
          notie.alert({
              type: 'error',
              text: 'Completa todos los campos antes de agregar el comentario',
              time: 3
          });
          return;
      }

    
    // Crear objeto con los datos del formulario
    const data = {
      nombre: nombre,
      comentario: comentario,
      valoracion: valoracion 
    };
    console.log(data);

    // Enviar los datos al servidor
    fetch('http://localhost/trabajojs/index.php?controller=API&action=añadircomentarios', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify(data)
    });

    notie.alert({
        type: 'success',
        text: 'Comentario agregado exitosamente',
        time: 3
    });
  });