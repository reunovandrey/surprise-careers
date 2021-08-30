<?php

/**
 * Displays the blog sidebar widget area.
 *
 * @package Surprise
 * @subpackage Surprise
 * @since Surprise 1.0
 */

if (is_active_sidebar('sidebar-1')) : ?>

  <div class="col-lg-4">
    <aside class="blog-sidebar">
      <?php dynamic_sidebar('sidebar-1'); ?>
    </aside><!-- .blog-sidebar -->
  </div>

<?php endif; ?>