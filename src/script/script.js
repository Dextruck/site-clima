document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const linkLists = [...document.querySelectorAll(".linkList")];
  const titles = [...document.querySelectorAll("h2")];

  function debounce(func, wait) {
      let timeout;
      return function (...args) {
          clearTimeout(timeout);
          timeout = setTimeout(() => func.apply(this, args), wait);
      };
  }

  function shouldLinkBeDisplayed(link, filter) {
      const attributes = link.getAttribute("data-attributes").toLowerCase();
      const attributesArray = attributes.split(",").map((attr) => attr.trim());
      const filters = filter.split(" ").filter(Boolean);
      return filters.every((f) => attributesArray.some((attr) => attr.includes(f)));
  }

  function filterLinks(filter) {
      linkLists.forEach((linkList, index) => {
          let hasVisibleItems = false;
          [...linkList.children].forEach((link) => {
              const shouldDisplay = filter === "" || shouldLinkBeDisplayed(link, filter);
              link.classList.toggle("hidden", !shouldDisplay);
              if (shouldDisplay) hasVisibleItems = true;
          });
          titles[index].classList.toggle("hidden", !hasVisibleItems);
      });
  }

  searchInput.addEventListener("input", debounce(() => {
      const filter = searchInput.value.toLowerCase().trim();
      filterLinks(filter);
  }, 300));
});