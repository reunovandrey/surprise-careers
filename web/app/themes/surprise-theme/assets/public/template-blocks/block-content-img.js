const lottieAnimation=()=>{let t=document.getElementsByClassName("lottie");0!=t.length&&null!=t&&Array.prototype.map.call(t,t=>{let o=t.dataset.animation;t.dataset.animation="",console.log(o);fetch(o).then(t=>t.json()).then(o=>{let e={container:t,renderer:"svg",loop:!0,autoplay:!0,animationData:o};lottie.loadAnimation(e)}).catch(t=>{console.error("Error:",t)})})};lottieAnimation();
//# sourceMappingURL=block-content-img.js.map