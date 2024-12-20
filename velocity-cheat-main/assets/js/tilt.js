document.addEventListener('DOMContentLoaded', () => {
    const tiltCard = document.querySelector('.tilt-card');

    tiltCard.addEventListener('mousemove', (e) => {
        const { offsetWidth: width, offsetHeight: height } = tiltCard;
        const { left, top } = tiltCard.getBoundingClientRect();
        const x = e.clientX - left;
        const y = e.clientY - top;
        const xPercent = (x / width) * 100;
        const yPercent = (y / height) * 100;
        const tiltX = ((xPercent - 50) / 50) * 10;
        const tiltY = ((yPercent - 50) / 50) * 10;

        tiltCard.style.transform = `rotateX(${tiltY}deg) rotateY(${tiltX}deg)`;
    });

    tiltCard.addEventListener('mouseleave', () => {
        tiltCard.style.transform = 'rotateX(0deg) rotateY(0deg)';
    });
});
