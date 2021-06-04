//Script Zona -> Distrito -> Subprefeitura
const url = `../api/api_distrito_subprefeitura.php`;
let zona = document.querySelector('#zona');

zona.addEventListener('change', async e => {
    let idZona = $('#zona option:checked').val();

    fetch(`${url}?zona_id=${idZona}`)
        .then(response => response.json())
        .then(distritos => {
            $('#distrito option').remove();
            $('#distrito').append('<option value="">Selecione uma opção...</option>');

            for (const distrito of distritos) {
                $('#distrito').append(`<option value='${distrito.id}'>${distrito.distrito}</option>`).focus();
            }
        })
})

let distrito = document.querySelector('#distrito');

distrito.addEventListener('change', async e => {
    let idDistrito = $('#distrito option:checked').val();

    fetch(`${url}?distrito_id=${idDistrito}`)
        .then(response => response.json())
        .then(subprefeituras => {
            $('#subprefeitura option').remove();

            for (const subprefeitura of subprefeituras) {
                $('#subprefeitura').append(`<option value='${subprefeitura.id}'>${subprefeitura.subprefeitura}</option>`)
            }

        })
})