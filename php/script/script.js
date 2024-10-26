// script.js
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const linkList = document.getElementById('linkList');

    // Adiciona um evento de escuta para o input de busca
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase().trim(); // Texto de busca em minúsculas
        const links = linkList.getElementsByTagName('li'); // Seleciona todos os <li> com links

        // Percorre todos os links e verifica se o atributo corresponde ao filtro
        for (let i = 0; i < links.length; i++) {
            const attributes = links[i].getAttribute('data-attributes').toLowerCase(); // Transforma atributos para minúsculas
            // Converte a string de atributos em um array usando vírgula como separador
            const attributesArray = attributes.split(',').map(attr => attr.trim()); // Remove espaços extras

            // Verifica se o filtro corresponde a algum atributo
            if (attributesArray.some(attr => attr.includes(filter))) {
                links[i].style.display = ''; // Mostra o link se o filtro corresponder
            } else {
                links[i].style.display = 'none'; // Oculta o link se o filtro não corresponder
            }
        }
    });
});
