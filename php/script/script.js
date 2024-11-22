// script.js
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const linkList = document.getElementById("linkList");

  searchInput.addEventListener("input", () => {
    const filter = searchInput.value.toLowerCase().trim();
    const links = linkList.getElementsByTagName("li");
    for (const link of links) {
      console.log(link.getAttribute("data-attributes"));
      const attributes = link.getAttribute("data-attributes").toLowerCase();
      const attributesArray = attributes.split(",").map((attr) => attr.trim());

      if (attributesArray.some((attr) => attr.includes(filter))) {
        link.style.display = "";
      } else {
        link.style.display = "none";
      }
    }
  });
});
