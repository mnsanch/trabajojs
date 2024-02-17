// Usamos una api creadora de QR de internet donde como valor le damos el localstorage que hemos guardado al hacer el pedido
const url = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(localStorage.getItem('pedido'))}`;

// Creamos un elemento img
const imgElement = document.createElement('img');
// Le ponemos la url al elemento para que muestre el qr
imgElement.src = url;
// Aladimos el elemento a la pagina
document.getElementById('qrCodeContainer').appendChild(imgElement);


