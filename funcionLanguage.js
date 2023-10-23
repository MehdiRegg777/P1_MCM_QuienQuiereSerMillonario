// Función para jugar con el idioma seleccionado
function selectLanguage(lan) {
    if (isset(lan)) {
        language = lan; // Obtener el idioma seleccionado
        //return $_SESSION['language'] = language;
    }
}
//Funcion ocultar todos los idiomas y mostrar el seleccionado
function changeLanguage(language) {
    // Ocultar todos los idiomas
    document.getElementById('spanish').style.display = 'none';
    document.getElementById('catalan').style.display = 'none';
    document.getElementById('english').style.display = 'none';

    // Mostrar el idioma seleccionado
    document.getElementById(language).style.display = 'block';
    sessionStorage.setItem('selectedLanguage', language);
}