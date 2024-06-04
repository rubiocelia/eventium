document.querySelector('.hamburger').addEventListener('click', function () {
    const menu = document.querySelector('.menu');
    this.classList.toggle('active');
    menu.classList.toggle('active');
  });
  