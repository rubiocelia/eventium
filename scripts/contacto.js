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

function toggleFaq(faqElement) {
  const allAnswers = document.querySelectorAll(".faq-answer");
  allAnswers.forEach((answer) => {
    if (answer.previousElementSibling !== faqElement) {
      answer.style.display = "none";
      answer.previousElementSibling.classList.remove("active");
    }
  });

  const answer = faqElement.nextElementSibling;
  if (faqElement.classList.contains("active")) {
    faqElement.classList.remove("active");
    answer.style.display = "none";
  } else {
    faqElement.classList.add("active");
    answer.style.display = "block";
  }
}
