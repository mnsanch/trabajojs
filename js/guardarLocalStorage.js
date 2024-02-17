document.getElementById("botonComprar").addEventListener("click", function () {
    // Cuando se pulse el boton de comprar se hace una llamada a la api para poder coger los datos del pedido 
    fetch('http://localhost/trabajojs/index.php?controller=API&action=datosultimopedido', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json; charset=UTF-8',
        },
    })
    .then(response => {
        return response.json();
    })
    .then(valores => {
        // Usamos los datos del pedido para hacer una cadena de texto con los valores de la api
        const producto = valores.map(({ ID_Categoria_Producto, Nombre_Producto, cantidad }) => (
            `Nombre:${Nombre_Producto}, Categoria:${ID_Categoria_Producto}, Cantidad:${cantidad} \n`
        ));
        const productos = producto.join('\n');
        
        // Guardamos los datos en el local storage
        localStorage.setItem('pedido', productos);
    });
});