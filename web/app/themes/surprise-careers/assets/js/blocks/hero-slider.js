const heroSlider = () => {
    const previews = document.querySelectorAll('.preview');

    const heroImages = new Swiper(".slides__images", {
        // allowTouchMove: false,
        slidesPerView: 1,
        centeredSlides: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
        },
        // freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,

        // spaceBetween: 40,
    });
    const heroTexts = new Swiper(".slides__text", {
        // slidesPerView: 1,
        // centeredSlides: true,
        // allowTouchMove: false,
        // watchSlidesVisibility: true,
        // watchSlidesProgress: true,
        // direction: 'vertical',
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        thumbs: {
            swiper: heroImages,
        },
    });






    previews.forEach(elem => {
        elem.addEventListener('click', () => {
            let allPreviews = document.getElementsByClassName('preview');
            for (let _prev of allPreviews){
                 _prev.classList.remove('active');
            }
            elem.classList.add('active');
            let slideIndex = elem.dataset.slide;
            heroImages.slideTo(slideIndex);
            heroTexts.slideTo(slideIndex);
        });
    });

}

heroSlider();