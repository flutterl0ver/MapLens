function chooseFile(id)
{
    document.getElementById(id).click();
}

function applyImage(id)
{
    const map = document.getElementById('map' + id);

    if(map.value !== null && map.value !== '')
    {
        const imageUrl = URL.createObjectURL(map.files[0]);
        const img = document.getElementById('map'+ id + 'Preview');
        img.src = imageUrl;
        img.style.display = 'initial';
        document.getElementById('map' + id + 'Hint').style.display = 'none';
    }
    else
    {
        const img = document.getElementById('map'+ id + 'Preview');
        img.src = '#';
        img.style.display = 'none';
        document.getElementById('map' + id + 'Hint').style.display = 'flex';
    }
}

function deleteImage(id)
{
    document.getElementById('map' + id).value = null;
    applyImage(id);
}


document.getElementById('map1').addEventListener('change', function(event) {
    applyImage(1);
});
document.getElementById('map2').addEventListener('change', function(event) {
    applyImage( 2);
});
