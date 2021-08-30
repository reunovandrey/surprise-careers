<?php 
$copyright = get_field('footer_copyright', 'option') ? : get_bloginfo('name');

?>

<div class="site-footer-copy">
  <p class="site-footer-copyright">&#xA9; <?php echo date("Y") . ' ' . $copyright; ?></p>
</div>