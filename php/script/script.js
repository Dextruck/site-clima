document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const linkLists = [...document.querySelectorAll(".linkList")]; // Array para otimizar
  const titles = [...document.querySelectorAll('h2')]; // Pegando todos os títulos de coleção

  searchInput.addEventListener("input", () => {
    const filter = searchInput.value.toLowerCase().trim();

    linkLists.forEach((linkList, index) => {
      let hasVisibleItems = false; // Flag para verificar se há itens visíveis

      [...linkList.children].forEach((link) => {
        const attributes = link.getAttribute("data-attributes").toLowerCase();
        const attributesArray = attributes.split(",").map((attr) => attr.trim());

        // Se o campo de pesquisa estiver vazio, exibe todos os itens
        const shouldDisplay = filter === "" || attributesArray.some((attr) => attr.includes(filter));

        // Usa uma classe CSS para controlar a visibilidade
        link.style.display = shouldDisplay ? "" : "none";

        // Atualiza a flag se encontrar ao menos um item visível
        if (shouldDisplay) {
          hasVisibleItems = true;
        }
      });

      // Se não houver itens visíveis, oculta o título da coleção
      titles[index].style.display = hasVisibleItems ? "" : "none";
    });
  });
});
