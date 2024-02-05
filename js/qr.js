var url = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${localStorage.getItem('pedido')}`;

// Crear elemento img directamente
const imgElement = document.createElement('img');
imgElement.src = url;
document.getElementById('qrCodeContainer').appendChild(imgElement);


