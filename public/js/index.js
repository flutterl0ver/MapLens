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

function startChangingColor(id)
{
    const input = document.getElementById(id);
    input.hidden = false;
    input.focus();
}

function applyColor(id, colorId)
{
    const input = document.getElementById(id);
    input.hidden = true;
    document.getElementById(colorId).style.backgroundColor = input.value;
}

function startSearch()
{
    document.getElementById('form').style.display = 'none';
    document.getElementById('loading').style.display = 'initial';
}

function addLegendEntry()
{
    const legendContainer = document.getElementById('legendContainer');
    legendContainer.innerHTML += `
        <div class="legendEntry">
            <div class="color" id="firstColor${colorsCount}" onclick="startChangingColor('legendFirstColor${colorsCount}')"></div>
            <input value="#AAAAAA" type="text" hidden name="legendFirstColor${colorsCount}" id="legendFirstColor${colorsCount}" onfocusout="applyColor('legendFirstColor${colorsCount}', 'firstColor${colorsCount}')">

            <textarea name="legendName${colorsCount}"></textarea>

            <input value="#AAAAAA" type="text" hidden name="legendSecondColor${colorsCount}" id="legendSecondColor${colorsCount}" onfocusout="applyColor('legendSecondColor${colorsCount}', 'secondColor${colorsCount}')">
            <div class="color" id="secondColor${colorsCount}" onclick="startChangingColor('legendSecondColor${colorsCount}')"></div>
        </div>
    `;
    colorsCount++;
    document.getElementById('colorsCount').value = colorsCount;
}

document.getElementById('map1').addEventListener('change', function(event) {
    applyImage(1);
});
document.getElementById('map2').addEventListener('change', function(event) {
    applyImage( 2);
});
