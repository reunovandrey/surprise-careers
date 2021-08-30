// Variables
let openMenu = false;

// PARSE POST DATA
function postData(url = '', data) {
	var boundary = String(Math.random()).slice(2); // needed for form data
	return fetch(url, {
			method: 'POST', // *GET, POST, PUT, DELETE, etc.
			mode: 'cors', // no-cors, cors, *same-origin
			cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
			credentials: 'same-origin', // include, *same-origin, omit
			headers: {
				// 'Content-Type': 'application/json',
				'Content-Type': 'application/x-www-form-urlencoded'
				//'Content-Type', 'multipart/form-data; boundary=' + boundary
			},
			redirect: 'follow', // manual, *follow, error
			referrer: 'no-referrer', // no-referrer, *client
			body: data, // the data type in the  body must match the value of the "Content-Type" header
		})
		.then(response => response.text()); // parses the JSON response into a Javascript object
}

// ELEMENT OFFSET COORDS
function getCoords(elem) { // not IE8-
  var box = elem.getBoundingClientRect();

  return {
    top: box.top + pageYOffset,
    left: box.left + pageXOffset
  };

}

// MODAL MENU
const mobileMenu = () => {
	let btn = document.querySelector('.site-header-mobmenu'),
  	mobmenu = document.querySelector('.site-header-mobile'),
	bgoverlay = document.querySelector('.sdc-overlay');
	if (btn) {
		btn.addEventListener('click', (e) => {
			e.preventDefault();
			mobmenu.classList.toggle('active');
      		btn.classList.toggle('active');
			if (mobmenu.classList.contains('active')) {
				openMenu = true;
			} else {
				openMenu = false;
			}
			document.body.classList.toggle('open');
		});
		bgoverlay.addEventListener('click', (e) => {
			openMenu = false;
			document.body.classList.remove('open');
			mobmenu.classList.remove('active');
			btn.classList.remove('active');
		})
	}
}

// SEARCHFORM
const searchform = () => {
	if ( ! document.forms.searchform ) return;
	let form = document.forms.searchform,		
		icon = form.querySelector('.searchform-icon');
	
	icon.addEventListener('click', () => form.classList.add('searchform-show'));

	document.addEventListener('click', (event) => {
		if ( ! form.contains(event.target)) {
			form.classList.remove('searchform-show');
		}
	})
}

const scrollPost = () => {
	if (! document.body.classList.contains('single-post')) return false;

	let postHeader = document.querySelector('.post-header-sticky'),
		postContainer = document.querySelector('.post-container'),
		postHero = document.querySelector('.post-hero'),
		scrollPosition = 0;

	window.addEventListener('scroll', () => {
		let dist = postContainer.offsetHeight - (window.innerHeight / 2),
		pos = window.scrollY - getCoords(content).top,
		progress = pos / dist,
    range = `${progress * 100}%`;

		if (progress > 0.1 && progress < 1) {

			postHeader.classList.add('sticky');
			scrollPos = document.body.getBoundingClientRect().top;

		} else {
			// Remove fix
			postHeader.classList.remove('sticky')

		}
	});
}

/**
 * Call Functions
 */
 mobileMenu();
 searchform();
 scrollPost();