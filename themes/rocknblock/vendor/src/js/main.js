import $ from '../plugins/jquery/dist/jquery.min';
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
});
