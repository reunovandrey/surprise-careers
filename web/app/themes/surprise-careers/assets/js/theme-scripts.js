let openMenu = false;
let csCategory, csLocation;

Array.prototype.inArray = function(comparer) {
    for(var i=0; i < this.length; i++) {
        if(comparer(this[i])) return true;
    }
    return false;
};

Array.prototype.pushIfNotExist = function(element, comparer) {
    if (!this.inArray(comparer)) {
        this.push(element);
    }
};


const hideTabs = () => {
        let panels = document.querySelectorAll('.career__tabcontent');
        for (let panel of panels) {
            panel.classList.remove('active');
        }
}

// Tabs on single Career page
const jobsTabs = () => {
    let tab_nav = document.querySelector('.career__tabs'),
        tab_contents = document.querySelectorAll('.career__tabcontent');
    if (tab_nav) {
        let tabs = document.querySelectorAll('.career__tab');
        let clostBtns = document.querySelectorAll('.close-section');

        tabs.forEach((elem) => {
            elem.addEventListener('click', (e) => {
                e.preventDefault();

                tabs.forEach((link) => {
                    link.classList.remove('active');
                })

                elem.classList.add('active');
                tab_contents.forEach((tc) => {
                    tc.classList.remove('active');
                });

                let target_id = elem.children[0].getAttribute('href');
                let target = document.getElementById(target_id.substring(1)).classList.add('active');
            })
        });

        clostBtns.forEach(elem => {
            elem.addEventListener('click', (e)=> {
                console.log(elem.closest('.career__tabcontent'));
                elem.closest('.career__tabcontent').classList.remove('active');
            })
        });

        for (let singleTab of tab_contents) {
            singleTab.querySelector('h3').addEventListener('click', e => {
                e.preventDefault();
                hideTabs();
                singleTab.classList.add('active');
            });
        }
    }
}


document.addEventListener('wpcf7mailsent', event => {
    console.log(event);
    const form = event.path[0];
    const message = document.querySelector('.form-thank-you');

    form.style.display = 'none';
    message.style.display = 'block';

});


// MODAL MENU
const mobileMenu = () => {
    let btn = document.querySelector('.header__mobmenu-toggle'),
        mobmenu = document.querySelector('.header__mobile'),
        bgoverlay = document.querySelector('.sdc-overlay');
    if (btn) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            mobmenu.classList.toggle('active');
            btn.classList.toggle('active');
            openMenu = mobmenu.classList.contains('active');
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

const dropZone = () => {
    let dz = document.querySelector('.dropzone'),
        dzFile = document.querySelector('.wpcf7-file.candidate_cv'),
        dzText = document.querySelector('.dropzone__text');

    if (dz) {
        dz.addEventListener('dragover', (e) => {
            dz.classList.add('file-dropping');
        });
        dz.addEventListener('dragleave', (e) => {
            dz.classList.remove('file-dropping');
        });
        dzFile.addEventListener('change', (e) => {
            dz.classList.remove('file-dropping');
            dzText.innerHTML = '<strong>' + dzFile.files[0].name + '</strong>';
        });

    }
}

let benefitsSliderOptions = {
    autoHeight: true,
    slidesPerView: window.innerWidth < 992 ? 2 : 1,
    spaceBetween: window.innerWidth < 992 ? 16 : 0,
    centeredSlides: true,
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
}




const benefitsSlider = new Swiper(".benefits-slider", benefitsSliderOptions);



let thumbsSliderParams = {
    direction: window.innerWidth < 992 ? 'horizontal' : 'vertical',
    spaceBetween: 10,
    slidesPerView: 3,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
}


const swThumbs = new Swiper(".visuals__thumb-nav", thumbsSliderParams);

const swSlider = new Swiper(".visuals__slider", {
    effect: "fade",
    thumbs: {
        swiper: swThumbs,
    },
});

window.addEventListener('resize', ()=>{
    let curLayout = swThumbs.params.direction;
    if(curLayout === 'vertical' && window.innerWidth < 992){
        swThumbs.changeDirection('horizontal');
    }
    if(curLayout === 'horizontal' && window.innerWidth >= 992){
        swThumbs.changeDirection('vertical');
    }

});



const masonryTeam = () => {
    let teams = document.querySelector('.teams');
    if (teams) {
        const teamGrid = new Masonry('.teams', {
            itemSelector: '.team',
        });
    }
}
const customSelect = () => {
    let customSelect = document.querySelector('.wpcf7-surprise_joblist');
    if (customSelect) {
        new TomSelect('.wpcf7-surprise_joblist', {
            create: true,
        });
    }
    if (document.querySelector('#careers_category')) {
        csCategory = new TomSelect(document.querySelector('#careers_category'), {
            create: false,
            closeAfterSelect: false
        });
    }
    if (document.querySelector('#careers_location')) {
        csLocation = new TomSelect(document.querySelector('#careers_location'), {
            create: false,
            closeAfterSelect: false
        });
    }
}


const updateVacanciesCount = (number) => {
    let postCount = document.querySelector('.post_count');

    let countStr = (parseInt(number) == 0) ? 'no vacancies' :
        parseInt(number) + '&nbsp;' + ((number < 2) ? 'vacancy' : 'vacancies');
    postCount.innerHTML = countStr;
}

const searchForm = () => {

    if (!document.forms.vacancy_filter) return;

    let form = document.forms.vacancy_filter;
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let url = '/wp-json/wp/v2/career';
        let params = {};
        let catId = document.getElementById('careers_category').value;
        let locationId = document.getElementById('careers_location').value;
        let searchString = document.getElementById('search').value;
        let container = document.querySelector('.vacancy__results');

        let tagLine = document.querySelector('.search-tags');
        let $submit = form.querySelector('[type="submit"]');
        let skills = [];

        document.querySelector('.vacancy__tagline').style.display = 'block';
        tagLine.innerHTML = '';

        if (catId && catId !== '-1') {
            params.team = catId;
            tagLine.insertAdjacentHTML("beforeend", '<span class="search-tag category-tag">' + document.querySelector('#careers_category').selectedOptions[0].text + '</span>');
            let catTag = document.querySelector('.category-tag');
            catTag.addEventListener('click', (e) => {
                csCategory.setValue('-1');
                e.target.remove();
                $submit.click();
            });
        }

        if (locationId && locationId !== '-1') {
            params.location = locationId;
            tagLine.insertAdjacentHTML("beforeend", '<span class="search-tag location-tag">' + document.querySelector('#careers_location').selectedOptions[0].text + '</span>');
            let locTag = document.querySelector('.location-tag');
            locTag.addEventListener('click', (e) => {
                csLocation.setValue('-1');
                e.target.remove();
                $submit.click();
            });
        }

        if (searchString && searchString !== '') {
            params.search = searchString;
        }

        if(searchString === '' && locationId === '-1' && catId === '-1' ) {
            console.log(searchString);
            console.log(locationId);
            console.log(catId);
            console.log('EMPTY PARAMS');
            // return;
        }
        const urlParams = new URLSearchParams(params);

        fetch('/wp-json/wp/v2/career?' + urlParams)
            .then(response => response.json())
            .then(posts => {

                container.innerHTML = '';

                updateVacanciesCount(posts.length);

                posts.forEach(post => {

                    let cardClasses = '';

                    if (post.skills.length > 0){
                        post.skills.forEach(skill => {
                            cardClasses += skill.slug + ' ';
                            skills.pushIfNotExist(skill, function(e){
                                return e.name === skill.name;
                            });
                        });
                    }

                    let html = '<div class="vacancy__card ' + cardClasses + '">\n' +
                        '                        <h4 class="vacancy__title">' + post.title.rendered + '</h4>\n' +
                        '                        <div class="vacancy__location">\n' +
                        '                            <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                        '<path d="M6.99998 0.666748C3.49998 0.666748 0.333313 3.35008 0.333313 7.50008C0.333313 10.1501 2.37498 13.2667 6.44998 16.8584C6.76665 17.1334 7.24165 17.1334 7.55831 16.8584C11.625 13.2667 13.6666 10.1501 13.6666 7.50008C13.6666 3.35008 10.5 0.666748 6.99998 0.666748ZM6.99998 9.00008C6.08331 9.00008 5.33331 8.25008 5.33331 7.33342C5.33331 6.41675 6.08331 5.66675 6.99998 5.66675C7.91665 5.66675 8.66665 6.41675 8.66665 7.33342C8.66665 8.25008 7.91665 9.00008 6.99998 9.00008Z" fill="#147DFA"></path>\n' +
                        '</svg>\n' +
                        '                            <span>' + post.location[0].name + '</span>\n' +
                        '                        </div>\n' +
                        '                        <div class="vacancy__category">\n' +
                        '                            <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                        '<path d="M10 5.625C11.3583 5.625 12.5583 5.95 13.5333 6.375C14.4333 6.775 15 7.675 15 8.65V9.16667C15 9.625 14.625 10 14.1667 10H5.83333C5.375 10 5 9.625 5 9.16667V8.65833C5 7.675 5.56667 6.775 6.46667 6.38333C7.44167 5.95 8.64167 5.625 10 5.625ZM3.33333 5.83333C4.25 5.83333 5 5.08333 5 4.16667C5 3.25 4.25 2.5 3.33333 2.5C2.41667 2.5 1.66667 3.25 1.66667 4.16667C1.66667 5.08333 2.41667 5.83333 3.33333 5.83333ZM4.275 6.75C3.96667 6.7 3.65833 6.66667 3.33333 6.66667C2.50833 6.66667 1.725 6.84167 1.01667 7.15C0.4 7.41667 0 8.01667 0 8.69167V9.16667C0 9.625 0.375 10 0.833333 10H3.75V8.65833C3.75 7.96667 3.94167 7.31667 4.275 6.75ZM16.6667 5.83333C17.5833 5.83333 18.3333 5.08333 18.3333 4.16667C18.3333 3.25 17.5833 2.5 16.6667 2.5C15.75 2.5 15 3.25 15 4.16667C15 5.08333 15.75 5.83333 16.6667 5.83333ZM20 8.69167C20 8.01667 19.6 7.41667 18.9833 7.15C18.275 6.84167 17.4917 6.66667 16.6667 6.66667C16.3417 6.66667 16.0333 6.7 15.725 6.75C16.0583 7.31667 16.25 7.96667 16.25 8.65833V10H19.1667C19.625 10 20 9.625 20 9.16667V8.69167ZM10 0C11.3833 0 12.5 1.11667 12.5 2.5C12.5 3.88333 11.3833 5 10 5C8.61667 5 7.5 3.88333 7.5 2.5C7.5 1.11667 8.61667 0 10 0Z" fill="#147DFA"></path>\n' +
                        '</svg>\n' +
                        '                            <span>' + post.team[0].name + '</span>\n' +
                        '                            <a href="' + post.link + '" class="vacancy__link">Learn more</a>\n' +
                        '                        </div>\n' +
                        '                    </div>';
                    container.insertAdjacentHTML('beforeend', html);
                    // vacResults.reloadItems();
                });

                document.querySelector('.vacancy__skills').innerHTML = '';

                if(skills.length > 0 && catId && catId !== '-1'){
                    let html = '';
                    skills.forEach(skill => {
                        let icon = skill.icon ? `<img src="${skill.icon.url}" alt="${skill.name}">&nbsp;` : '';
                        html += `<button class="skill" data-slug="${skill.slug}">${icon} ${skill.name}</button>`;
                    });
                    document.querySelector('.vacancy__skills').insertAdjacentHTML("beforeend", html);
                }

                let vacResults = new Isotope(document.querySelector('.vacancy__results', {layoutMode: 'fitColumns'}), {
                    itemSelector: '.vacancy__card',
                });

                let $skill = document.querySelectorAll('.skill');
                let currentFilter = [];
                $skill.forEach(elem => {
                    elem.addEventListener('click', (e) => {
                        let slug = elem.dataset.slug;
                        let text = elem.innerText.trim();
                        if (elem.classList.contains('active')){
                            currentFilter = currentFilter.filter((value, index, arr) => {
                                return value !== '.' + slug;
                            })
                        }else{

                            let tagHtml = `<span class="search-tag skill-tag" data-slug="${slug}">${text}</span>`;
                            tagLine.insertAdjacentHTML('beforeend', tagHtml);
                            currentFilter.push('.' + slug);
                        }

                        let skillTags = document.querySelectorAll('.skill-tag');
                        skillTags.forEach(skillTag => {
                            skillTag.addEventListener('click', (e) => {
                                // console.log(currentFilter);
                                currentFilter = currentFilter.filter((value, index, arr) => {
                                    return value !== '.' + slug;
                                });
                                // console.log(currentFilter);
                                let filterLine = currentFilter.length > 0 ? currentFilter.join(', ') : '*';
                                vacResults.arrange({filter: filterLine});

                                skillTag.remove();

                                document.querySelector('.skill.active[data-slug="'+slug+'"]').classList.remove('active');
                            });
                        })

                        let filterLine = currentFilter.length > 0 ? currentFilter.join(', ') : '*';
                        vacResults.arrange({filter: filterLine});

                        updateVacanciesCount(vacResults.filteredItems.length);

                        elem.classList.toggle('active');
                    })
                });
            });
    });
}


mobileMenu();
jobsTabs();
dropZone();
masonryTeam();
customSelect();
searchForm();