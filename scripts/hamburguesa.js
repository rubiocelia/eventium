//Funcion para que la hamburguesa despliegue el menu cuando esta responsive
document.querySelector('.hamburger').addEventListener('click', function () {
    const menu = document.querySelector('.menu');
    this.classList.toggle('active');
    menu.classList.toggle('active');
  });
  