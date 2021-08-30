/**
 * Loadmore Posts Plugin
 */
document.addEventListener('DOMContentLoaded', () => {
  const postType = 'post';
  if (document.querySelector('.blog-latest-posts')) {
    clickLoadmore();
  } else {
    console.log('Tets')
  }

  // LOADMORE BUTTON
  function clickLoadmore() {
    let btn = document.getElementById('loadmore');
    if (btn) {
      btn.addEventListener('click', () => {
        ajaxLoadPosts(++surprise_ajax_params.current_page, btn.dataset.page, btn.dataset.cat);
      });
    }
  }

  // AJAX LOAD POSTS
  function ajaxLoadPosts(page = 1, url = '', cat = '') {
    let wrapp = document.getElementById('blog-latest-posts'),
      paginator = document.getElementById('post_pagination'),
      curLoc = window.location.pathname,
      nextLoc,
      taxonomy = (postType == 'post') ? 'blog' : postType;
    pageNum = document.querySelectorAll('a.page-number');
    // cat = postFilter.dataset.select;
    data = {
      'action': 'loadmore',
      'post_type': postType,
      'page': page,
      'cat' : cat,
      'first_page': surprise_ajax_params.first_page
    }
    params = new URLSearchParams(data);
    postData(surprise_ajax_params.ajaxurl, params)
      .then(data => {
        // Once a New Category Has Been Selected
        if (page == 1) {
          // Input Post Data into Page
          wrapp.innerHTML = data;
          // Set Current Page Number
          surprise_ajax_params.current_page = 1;
          // Change Browser Url

          window.history.pushState({}, "", window.location.href);
          // Change Page Pagination Link
          pageNum = document.querySelectorAll('a.page-number');
          pageNum.forEach(num => {
            let url = num.href,
              isQuery = url.indexOf('?') > 0 ? true : false;
            // If Recently We Have Query Parameters in Pagination Links,
            // We Have to Remove it in Page Number Link
            // Then Add New Category to Query Parameters
            if (isQuery) {
              num.href = url.substring(0, url.indexOf('?')) + window.location.search
            } else {
              num.href = url + '/' + window.location.search
            }
          });
          // Add Listener For Loadmore Button
          clickLoadmore();
          // Current page !== 1
        } else {
          // Remove Default Post Pagination
          paginator.remove();
          // Input Post Data into Page
          wrapp.insertAdjacentHTML('beforeEnd', data);
          if (page > 1) {
            window.history.pushState({}, "", url);
          }
          // Add Listener For Loadmore Button
          clickLoadmore();
        }
        // After all Posts Have Been Loaded Hide Preloader
        // document.getElementById('preloader').classList.add('hidden');
        // document.getElementById('preloader').classList.remove('visible');
      })
      .catch(error => console.error('Err', error));
  }

});