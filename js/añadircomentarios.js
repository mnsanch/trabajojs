document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la api para coger el nombre de usuario y saber si han iniciado sesion 
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
            // Si han iniciado session agregamos un option al select para que pudean escojer si en el comentario ponen su nombre o ponen anonimo
            if (valores!=false) {
                const select = document.getElementById('nombre');
                const option = document.createElement('option');
                option.innerHTML = valores;
                select.appendChild(option);
            }else{
                document.getElementById('aviso').innerHTML="Si quieres seleccionar tu nombre en el comentario inicia session";
            } 
        })
})

document.getElementById("botonaceptar").addEventListener("click", function () {
    // Obtenemos los valores del formulario
    const nombre = document.getElementById("nombre").value;
    const comentario = document.getElementById("comentario").value;
    const valoracion = document.querySelector('input[name="puntuacion"]:checked').value;

    
        // Validamos que todos los campos estén completos
        if (!nombre || !comentario || !valoracion) {
       
          // Si hay alun campo que este vacio hacemos un notie con error diciendo que no estan los campos llenos
          notie.alert({
              type: 'error',
              text: 'Completa todos los campos antes de agregar el comentario',
              time: 3
          });
          return;
      }
   
    // Crear el objeto con los datos del formulario
    const data = {
      nombre: nombre,
      comentario: comentario,
      valoracion: valoracion 
    };

    // Enviar el objeto creado a la api para añadir el comentario a la base de datos
    fetch('http://localhost/trabajojs/index.php?controller=API&action=añadircomentarios', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify(data)
    });
    // Hacenos un notie diciendo que el comentario se ha añadido correctamente
    notie.alert({
        type: 'success',
        text: 'Comentario agregado exitosamente',
        time: 3
    });
  });