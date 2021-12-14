// import $ from '../plugins/jquery/dist/jquery.min';
import $ from 'cash-dom';
import Swiper from 'swiper';

if (navigator.serviceWorker) {
  navigator.serviceWorker
    .register('/plugins/sw.js')
    .then(function (registration) {
      console.log('ServiceWorker registration successful with scope:', registration.scope);
    })
    .catch(function (error) {
      console.log('ServiceWorker registration failed:', error);
    });
}

$(document).ready(() => {
  // eslint-disable-next-line no-console
  console.log(`document ready`);

  Array.from(document.getElementsByClassName('icon-burger')).forEach((el) => {
    el.addEventListener('click', () => {
      el.hidden = true;
      const menuType = el.classList.contains('ic-open') ? 'ic-close' : 'ic-open';
      const navCl = document.getElementById('nav-pages').classList;

      document.getElementsByClassName(menuType)[0].hidden = false;
      menuType !== 'ic-open' ? navCl.add('menu-open') : navCl.remove('menu-open');
    });
  });

  const sliderFeedback = new Swiper('.swiper-feedback', {
    slidesPerView: 1,
    spaceBetween: 0,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      769: {
        slidesPerView: 2,
        spaceBetween: 0,
      },
    },
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  const sliderBlog = new Swiper('.blog-slider', {
    slidesPerView: 1,
    spaceBetween: 15,
    breakpoints: {
      550: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      950: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
    },
    navigation: {
      nextEl: '.swiper-button-next',
    },
  });

  const sliderBottom = new Swiper('.swiper-slider', {
    slidesPerView: 'auto',
    loop: true,
  });

  Array.from(document.getElementsByClassName('blog-select-nav')).forEach((el) => {
    el.addEventListener('click', () => {
      document.getElementsByClassName('active')[0].classList.remove('active');
      el.classList.add('active');
      filterSelection(el.dataset.filter);
      window.dispatchEvent(new Event('resize'));
    });
  });

  const filterSelection = (c) => Array.from(document.getElementsByClassName('blog-item')).forEach((el) => (el.hidden = el.dataset.category === c ? false : c !== 'all'));

  const sliderPorfolio = new Swiper('.swiper-portfolio', {
    slidesPerView: 'auto',
    loop: true,
    spaceBetween: 15,
  });
});
