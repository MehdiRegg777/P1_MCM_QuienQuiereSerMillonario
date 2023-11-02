let moscasMuertas = 0;

function matarMosca() {
    const mosca = document.getElementById('mosca');
    if (mosca) {

        mosca.style.animation = 'none';

        mosca.style.animation = 'rotar 2s linear';

        setTimeout(() => {
            mosca.style.animation = 'none';
            moverMosca();
        }, 2000);
        
        moscasMuertas++;
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


setInterval(() => moverMosca(), 4000);
