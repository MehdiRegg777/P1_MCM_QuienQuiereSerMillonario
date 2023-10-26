//Funcion enviar el idioma seleccionado al servidor
function changeLanguage(language) {
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'language=' + encodeURIComponent(language),
    })
    .then(response => response.text())
    .then(data => {
        window.location.reload();
    });
}