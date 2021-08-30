<?php
$sign_in = $cta_button = $cta_form = $get_the_app = false;
$chevron_icon =  file_get_contents(get_template_directory() . '/assets/public/images/svg/arrow.svg');

if (function_exists('get_field')) :
  $sign_in    = get_field('sign_in_link', 'option') ?: false;
  $sign_up = get_field('sign_up_link', 'option') ?: false;  
  $get_the_app = get_field('get_the_app_link', 'option') ?: false;
endif;
?>

<div class="site-header-navbar">
  <nav class="site-header-nav">
    <?php
    wp_nav_menu(array(
      'theme_location'  => 'primary',
      'menu_id'         => 'primary-menu',
      'menu_class'      => 'primary-menu',
      'container'       => '',
    ));
    ?>
    <div class="site-header-cta">
      <?php if ($sign_in) :
        $si_url    = $sign_in['url'];
        $si_label  = $sign_in['title'];
        $si_target = $sign_in['target'] ?: '_self';
      ?>
        <a href="<?php echo $si_url; ?>" class="site-header-signin" target="<?php echo $si_target; ?>" rel="noopener"><?php echo $si_label; ?></a>
      <?php endif; ?>

      <?php if ($sign_up) : 
        $su_url    = $sign_up['url'];
        $su_label  = $sign_up['title'];
        $su_target = $sign_up['target'] ?: '_self';
        ?>
        <a href="<?php echo $su_url; ?>" class="bttn bttn-primary bttn-md" target="<?php echo $su_target; ?>" rel="noopener"><?php echo $su_label; ?></a>
      <?php endif; ?>
    </div>
  </nav>
	<?php if ($get_the_app) :
	$get_app_url    = $get_the_app['url'];
	$get_app_label  = $get_the_app['title'];
	$get_app_target = $get_the_app['target'] ?: '_self';
	?>
    <a href="<?php echo $get_app_url; ?>" rel="noopener" class="bttn bttn-primary bttn-sm bttn-try" target="<?php echo $get_app_target; ?>"><?php echo $get_app_label; ?></a>
	<?php endif; ?>
    <button type="button" class="site-header-mobmenu menu-toggle" aria-label="Menu">
    <svg class="burger-icon" viewBox="0 0 100 100" width="80" fill="currentColor">
      <path class="burger-line burger-line-top" d="m 30,33 h 40 c 13.100415,0 14.380204,31.80258 6.899646,33.421777 -24.612039,5.327373 9.016154,-52.337577 -12.75751,-30.563913 l -28.284272,28.284272"></path>
      <path class="burger-line burger-line-middle" d="m 70,50 c 0,0 -32.213436,0 -40,0 -7.786564,0 -6.428571,-4.640244 -6.428571,-8.571429 0,-5.895471 6.073743,-11.783399 12.286435,-5.570707 6.212692,6.212692 28.284272,28.284272 28.284272,28.284272"></path>
      <path class="burger-line burger-line-bottom" d="m 69.575405,67.073826 h -40 c -13.100415,0 -14.380204,-31.80258 -6.899646,-33.421777 24.612039,-5.327373 -9.016154,52.337577 12.75751,30.563913 l 28.284272,-28.284272"></path>
    </svg>
  </button>
</div>