/**
 *
 * @param {String} selector
 * @param {Object} options
 * @returns
 */

const defaults = {
  animationDuration: 200,
  rewindDuration: 1000
}
class Sdc_Carousel {
  constructor(selector, options = {}) {
    this.selector = selector;
    this.selectorInner = selector.querySelector('.sdc-carousel-inner');
    this.settings = this.mergeOptions(defaults, options);
  }

  init() {
    this.transitionProperty()
    this.start();
  }

  /**
   *
   * @param {Object} defaults
   * @param {Object} settings
   * @returns Object
   */
  mergeOptions(defaults, settings) {
    let options = Object.assign({}, defaults, settings)
    return options;
  }

  /**
   *
   * @param {Object} elem
   * @returns Object
   */
  siblings(elem) {
    return Array.prototype.filter.call(elem.parentNode.children, sibling => {
      return sibling !== elem;
    });
  }

  /**
   * Set transition value for each item
   */
  transitionProperty() {
    Array.prototype.filter.call(this.selector.querySelector('.sdc-carousel-inner').children, element => {
      element.style.transitionDuration = `${this.settings.animationDuration}ms`;
    });
  }


  /**
   * Rewind to the next slide
   */
  change() {
    let activeSlide = this.selector.querySelector('.active'),
      nextSlide = !activeSlide.nextElementSibling ? this.selectorInner.children[0] : activeSlide.nextElementSibling;
    activeSlide.classList.remove('active');
    nextSlide.classList.add('active');
  }

  /**
   * Start animation
   */
  start() {
    setTimeout(() => {
      this.change()
      this.move();
    }, this.settings.rewindDuration);
  }

  /**
   * Loop
   */
  move() {
    setInterval(() => {
      this.change()
    }, this.settings.rewindDuration)
  }
}


const imageCarousel = () => {
  if ( !document.querySelector('.sdc-carousel')) return false;
  new Sdc_Carousel(document.querySelector('.sdc-carousel'), {
    rewindDuration: 2000,
    animationDuration: 500,
  }).init();
}
imageCarousel()