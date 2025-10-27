function chooseFile(id)
{
    document.getElementById(id).click();
}

function applyImage(event, id)
{
    const imageUrl = URL.createObjectURL(event.target.files[0]);
    const img = document.getElementById('map'+ id + 'Preview');
    img.src = imageUrl;
    img.style.display = 'initial';
    document.getElementById('map' + id + 'Hint').style.display = 'none';
}

document.getElementById('map1').addEventListener('change', function(event) {
    applyImage(event, 1);
});
document.getElementById('map2').addEventListener('change', function(event) {
    applyImage(event, 2);
});
