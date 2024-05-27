document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".count");
  const duration = 2000; // Duración en milisegundos para que todos los contadores terminen al mismo tiempo

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const startTime = performance.now();

          counters.forEach((counter) => {
            const target = +counter.getAttribute("data-target");

            const updateCount = () => {
              const elapsedTime = performance.now() - startTime;
              const progress = Math.min(elapsedTime / duration, 1); // Asegurarse de que el progreso no supere 1
              const count = Math.floor(target * progress);

              counter.innerText = count + "+";

              if (progress < 1) {
                requestAnimationFrame(updateCount);
              } else {
                counter.innerText = target + "+";
              }
            };

            updateCount();
          });

          observer.disconnect(); // Dejar de observar una vez que los contadores empiezan
        }
      });
    },
    { threshold: 1.0 }
  );

  counters.forEach((counter) => {
    observer.observe(counter);
  });
});
