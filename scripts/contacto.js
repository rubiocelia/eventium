document.addEventListener("DOMContentLoaded", function () {
  const categories = document.querySelectorAll(".category");
  const faqsContent = document.getElementById("faqsContent");
  const faqCategories = document.querySelectorAll(".faq-category");
  const backToCategoriesBtn = document.getElementById("backToCategories");

  categories.forEach((category) => {
    category.addEventListener("click", function () {
      const selectedCategory = category.getAttribute("data-category");

      categories.forEach((cat) => (cat.style.display = "none")); // Ocultar todas las categorías
      faqsContent.style.display = "block"; // Mostrar la sección de FAQs

      faqCategories.forEach((faq) => {
        if (faq.id === selectedCategory) {
          faq.style.display = "block"; // Mostrar la FAQ de la categoría seleccionada
        } else {
          faq.style.display = "none"; // Ocultar las demás FAQs
        }
      });
    });
  });

  backToCategoriesBtn.addEventListener("click", function () {
    faqsContent.style.display = "none"; // Ocultar la sección de FAQs
    categories.forEach((cat) => (cat.style.display = "block")); // Mostrar todas las categorías
  });
});
