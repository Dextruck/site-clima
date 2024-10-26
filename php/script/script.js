document.addEventListener('DOMContentLoaded', async function() {
    const searchInput = document.getElementById('searchInput');
    const linkList = document.getElementById('linkList');

    // Fetch data from PHP API
    const response = await fetch('http://localhost:8080/api.php');
    const links = await response.json();

    linkList.innerHTML = ''; // Clear existing content

    // Render each link dynamically
    links.forEach(link => {
        const li = document.createElement('li');
        li.setAttribute('data-attributes', link.attributes);
        li.innerHTML = `<a href="${link.url}" target="_blank">${link.name}</a>`;
        linkList.appendChild(li);
    });

    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        const listItems = linkList.getElementsByTagName('li');

        for (let i = 0; i < listItems.length; i++) {
            const attributes = listItems[i].getAttribute('data-attributes').toLowerCase();
            listItems[i].style.display = attributes.includes(filter) ? '' : 'none';
        }
    });
});
