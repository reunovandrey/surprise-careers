<?php
/**
 * Features that improve the functionality of the blog pagination
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */
/**
 * SURPRISE LOADMORE & FILTER AJAX
 */
function surprise_loadmore_ajax_handler($cat = '', $page = 1, $type = '', $post_type = '') {
  $showposts = get_option('posts_per_page');
  $sticky = get_option('sticky_posts');
	$ignore_sticky = array_slice($sticky, 0, 4);
  if ($cat == '') :
    $cat = $_POST['cat'];
  endif;
  if ($post_type == '') :
    $post_type = $_POST['post_type'];
  endif;
  $args = array(
    'post_type'       => $post_type,
    'post_status'     => 'publish',
    'posts_per_page'  => $showposts,
    'orderby'         => 'date',
    'order'           => 'DESC',
    'paged'           => $page,
    'post__not_in'    => $ignore_sticky
  );
  //$args = json_decode(stripslashes($_POST['query']), true);
  if ($type == '') :
    if ($_POST['page'] != 1) {
      $args['paged'] = $_POST['page']; // we need next page to be loaded
    }
  endif;
  if (!empty($cat)) {
    $args['cat'] = array($cat);
  }
  $query = new WP_Query($args);
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      get_template_part('template-parts/content/content', get_theme_mod('display_excerpt_or_full_post', 'excerpt'));
    endwhile;
    // echo get_the_posts_pagination();
    surprise_paginator($_POST['first_page'], $query, $cat);
    print_r(get_query_var('cat'));
  //echo $_POST['first_page'];
  endif;
  if ($type == '') :
    wp_reset_postdata();
    wp_die();
  endif;
  echo '<span class="max-pages">' . $query->max_num_pages . '</span>';
}
add_action('wp_ajax_loadmore', 'surprise_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'surprise_loadmore_ajax_handler');
// Post Pagination & Loadmore
function surprise_paginator($first_page_url, $query = '', $cat = '') {

  // Show Pagination List
  $show_post_pagination = get_field('show_post_pagination', 'option') ? : false;
  // the function works only with $wp_query that's why we must use query_posts() instead of WP_Query()
  if ($query != '') :
    $wp_query = $query;
  else :
    global $wp_query;
  endif;
  // remove the trailing slash if necessary
  $first_page_url = untrailingslashit($first_page_url);
  // it is time to separate our URL from search query
  $first_page_url_exploded = array(); // set it to empty array
  $first_page_url_exploded = explode("/?", $first_page_url);
  // by default a search query is empty
  $cat = (int) $wp_query->query_vars['cat'] ? : '';
  $search_query = '';
  // if the second array element exists
  if (isset($first_page_url_exploded[1])) {
    //$search_query = "/?" . $first_page_url_exploded[1];
    $first_page_url = $first_page_url_exploded[0];
  }
  // get parameters from $wp_query object
  // how much posts to display per page (DO NOT SET CUSTOM VALUE HERE!!!)
  $posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
  //$posts_per_page = get_option('posts_per_page');
  // current page
  $current_page = (int) $wp_query->query_vars['paged'];
  // the overall amount of pages
  $max_page = $wp_query->max_num_pages;
  // we don't have to display pagination or load more button in this case
  if ($max_page <= 1) return;
  // set the current page to 1 if not exists
  if (empty($current_page) || $current_page == 0) $current_page = 1;
  // you can play with this parameter - how much links to display in pagination
  $links_in_the_middle = 4;
  $links_in_the_middle_minus_1 = $links_in_the_middle - 1;
  // the code below is required to display the pagination properly for large amount of pages
  // I mean 1 ... 10, 12, 13 .. 100
  // $first_link_in_the_middle is 10
  // $last_link_in_the_middle is 13
  $first_link_in_the_middle = $current_page - floor($links_in_the_middle_minus_1 / 2);
  $last_link_in_the_middle = $current_page + ceil($links_in_the_middle_minus_1 / 2);
  // some calculations with $first_link_in_the_middle and $last_link_in_the_middle
  if ($first_link_in_the_middle <= 0) $first_link_in_the_middle = 1;
  if (($last_link_in_the_middle - $first_link_in_the_middle) != $links_in_the_middle_minus_1) {
    $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1;
  }
  if ($last_link_in_the_middle > $max_page) {
    $first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1;
    $last_link_in_the_middle = (int) $max_page;
  }
  if ($first_link_in_the_middle <= 0) $first_link_in_the_middle = 1;
  // begin to generate HTML of the pagination
  $pagination = '<nav id="post_pagination" class="posts-pagination-wrapper" role="navigation">';

  if ($show_post_pagination) {

    $pagination .= '<div class="pagin-page-block">
    <ul class="page-numbers">';
    // when to display "..." and the first page before it
    if ($first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page) {
      $pagination .= '<a href="' . $first_page_url . $search_query . '" class="page-number">1</a>';
      if ($first_link_in_the_middle != 2)
        $pagination .= '<span class="page-number extend">...</span>';
    }
    // arrow left (previous page)
    if ($current_page != 1)
      $pagination .= '<a href="' . $first_page_url . '/page/' . ($current_page - 1) . $search_query . '"  class="prev page-number"><</a>';
    // loop page links in the middle between "..." and "..."
    for ($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
      if ($i == $current_page) {
        $pagination .= '<li><span class="page-number current">' . $i . '</span></li>';
      } else {
        $pagination .= '<li><a href="' . $first_page_url . '/page/' . $i . $search_query . '"   class="page-number">' . $i . '</a></li>';
      }
    }
    // arrow right (next page)
    if ($current_page != $last_link_in_the_middle)
      $pagination .= '<li><a href="' . $first_page_url . '/page/' . ($current_page + 1) . $search_query   . '" class="next page-number">></a></li>';
    // when to display "..." and the last page after it
    if ($last_link_in_the_middle < $max_page) {
      if ($last_link_in_the_middle != ($max_page - 1))
        $pagination .= '<li><span class="page-number extend">...</span><li>';
      $pagination .= '<li><a href="' . $first_page_url . '/page/' . $max_page . $search_query . '"  class="page-number">' . $max_page . '</a><li>';
    }
    $pagination .= "</ul></div>";
  }
  // haha, this is our load more posts link
  if ($current_page < $max_page)
    $pagination .= '<div class="loadmore-block"><button id="loadmore" data-page="'.$first_page_url.'/page/' . ($current_page + 1) . $search_query . '" data-cat="'.$cat.'" class="bttn bttn-sm bttn-primary">' .  __('See More', 'surprise') . '</button></div>';
  // end HTML
  $pagination .= "</nav>";
  // replace first page before printing it
  echo str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
}