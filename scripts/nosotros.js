document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".count");
  const speed = 200; // Ajusta la velocidad según sea necesario

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          const updateCount = () => {
            const target = +counter.getAttribute("data-target");
            const count = +counter.innerText.replace("+", "");

            // Incremento por paso
            const increment = target / speed;

            if (count < target) {
              counter.innerText = Math.ceil(count + increment) + "+";
              setTimeout(updateCount, 10);
            } else {
              counter.innerText = target + "+";
            }
          };
          updateCount();
          observer.unobserve(counter);
        }
      });
    },
    { threshold: 1.0 }
  );

  counters.forEach((counter) => {
    observer.observe(counter);
  });
});
