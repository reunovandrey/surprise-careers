<?php

/**
 * Categories Grid Template
 */

$categories = get_categories();

?>

<section class="blog-categories">
  <div class="blog-categories-wrapper">
    <div class="container">
      <h2 class="h3 blog-categories-title"><?php _e('Browse', 'surprise'); ?></h2>
      <div class="category-grid">
        <?php foreach ($categories as $category) :
          $cat_id     = $category->cat_ID;
          $cat_name   = $category->name;
          $cat_link   = get_category_link($cat_id);
          $cat_icon   = get_term_meta($cat_id, 'surprise_category_image', true);
          $cat_color  = get_term_meta($cat_id, 'surprise_category_color', true) ? : '#147dfa';
        ?>
          <div class="category-item">
            <a href="<?php echo $cat_link; ?>" class="category-card" style="background-color: <?php echo $cat_color; ?>;">
              <?php echo surprise_get_icon($cat_icon); ?>
              <h4 class="category-name h5"><?php echo $cat_name; ?></h4>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>