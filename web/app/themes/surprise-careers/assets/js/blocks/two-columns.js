const lottieAnimation = () => {
  // Get all elements with class .lottie
  let selectors = document.getElementsByClassName('lottie');

  if (selectors.length == 0 || selectors == null) return;

  Array.prototype.map.call(selectors, selector => {
    let jsonPath = selector.dataset.animation;
    selector.dataset.animation = '';
    console.log(jsonPath)
    const response = fetch(jsonPath)
      .then(response => response.json())
      .then(data => {
        let params = {
          container: selector,
          renderer: 'svg',
          loop: true,
          autoplay: true,
          animationData: data
        };
    
        lottie.loadAnimation(params)
      })
      .catch(error => {
        console.error('Error:', error);
      });
  })

}

lottieAnimation();