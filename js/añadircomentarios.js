document.getElementById("botonaceptar").addEventListener("click", function () {
    // Obtener los valores del formulario
    const nombre = document.getElementById("nombre").value;
    const comentario = document.getElementById("comentario").value;
    const valoracion = document.querySelector('input[name="puntuacion"]:checked').value;
    
    // Crear objeto con los datos del formulario
    const data = {
      nombre: nombre,
      comentario: comentario,
      valoracion: valoracion 
    };
    console.log(data)
    console.log(nombre)
    console.log(data.nombre)

    // Enviar los datos al servidor
    fetch('http://localhost/trabajojs/index.php?controller=API&action=añadircomentarios', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
        body: JSON.stringify(data)
    });
  });