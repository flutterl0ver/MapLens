function closeDiff()
{
    const panel = document.getElementById('diffPanel');
    const bg = document.getElementById('darkBg');

    panel.style.opacity = '0';
    bg.style.opacity = '0';

    setTimeout(function() {
        panel.style.display = 'none';
        bg.style.display = 'none';
    }, 200);
}

function openDiff(x1, y1, x2, y2, area)
{
    const panel = document.getElementById('diffPanel');
    const bg = document.getElementById('darkBg');

    const img1 = document.getElementById('diffImg1');
    const img2 = document.getElementById('diffImg2');

    const x = -(x1 + x2) / 2 + 250;
    const y = -(y1 + y2) / 2 + 150;

    img1.style.backgroundPosition = img2.style.backgroundPosition = x + 'px ' + y + 'px';

    panel.style.display = 'initial';
    bg.style.display = 'initial';

    panel.style.opacity = '1';
    bg.style.opacity = '0.5';

    document.getElementById('diffText').innerHTML = `Размер изменения: ${area} пикс`;
}
