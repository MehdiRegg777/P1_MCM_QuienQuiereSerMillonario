// Function to hide all languages and show the selected one.
function changeLanguage(language) {
    // Hide all languages.
    document.getElementById('spanish').style.display = 'none';
    document.getElementById('catalan').style.display = 'none';
    document.getElementById('english').style.display = 'none';

    // Display the selected language
    document.getElementById(language).style.display = 'block';

    // Send the selected language to the server using an AJAX request
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'language=' + encodeURIComponent(language),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Print the server's response
    });
}