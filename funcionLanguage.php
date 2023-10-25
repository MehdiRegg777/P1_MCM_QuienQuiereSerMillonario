<?php
session_start();
$_SESSION['language'] = $_GET['lang'] ?? 'spanish';
header( "Location: /");
?>
<script>
    //Funcion ocultar todos los idiomas y mostrar el seleccionado
    function changeLanguage(language) {
        // Ocultar todos los idiomas
        document.getElementById('spanish').style.display = 'none';
        document.getElementById('catalan').style.display = 'none';
        document.getElementById('english').style.display = 'none';

        // Mostrar el idioma seleccionado
        document.getElementById(language).style.display = 'block';
    }
</script>