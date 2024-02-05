document.getElementById("botonComprar").addEventListener("click", function () {
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
        // Concatenating the required fields into a string
        const simplifiedData = valores.map(({ ID_Categoria_Producto, Nombre_Producto, cantidad }) => (
            `Nombre_Producto:${Nombre_Producto}, Categoria_Producto:${ID_Categoria_Producto}, Cantidad:${cantidad}\n`
        ));

        console.log('dataString', dataString);

        // Storing the concatenated data string in local storage
        localStorage.setItem('pedido', dataString);
    });
});