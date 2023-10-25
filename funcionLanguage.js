//Funcion ocultar todos los idiomas y mostrar el seleccionado
function changeLanguage(language) {
    // Ocultar todos los idiomas
    document.getElementById('spanish').style.display = 'none';
    document.getElementById('catalan').style.display = 'none';
    document.getElementById('english').style.display = 'none';

    // Mostrar el idioma seleccionado
    document.getElementById(language).style.display = 'block';

    // Enviar el idioma seleccionado al servidor mediante una solicitud AJAX
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'language=' + encodeURIComponent(language),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Imprime la respuesta del servidor
    });
}