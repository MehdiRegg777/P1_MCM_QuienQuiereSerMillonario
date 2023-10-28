let moscasMuertas = 0;

function matarMosca() {
    const mosca = document.getElementById('mosca');
    if (mosca) {
        mosca.style.display = 'none';
        moscasMuertas++;
        if (moscasMuertas === 1) {
            window.location.href = 'win.php?puntage=18';
        }
    }
}

function moverMosca() {
    const mosca = document.getElementById('mosca');
    if (mosca) {
        const maxX = window.innerWidth - 50;
        const maxY = window.innerHeight - 50;
        const randomX = Math.random() * maxX;
        const randomY = Math.random() * maxY;
        
        mosca.style.left = randomX + 'px';
        mosca.style.top = randomY + 'px';
    }
}

document.getElementById('mosca').addEventListener('click', () => matarMosca());

// Mueve la mosca cada 2 segundos
setInterval(() => moverMosca(), 2000);
