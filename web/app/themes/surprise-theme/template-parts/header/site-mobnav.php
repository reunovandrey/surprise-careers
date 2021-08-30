<?php
global $is_iphone;

$app_store_button = get_template_directory() . '/assets/public/images/svg/app-store-inverted.svg';
$app_store_link = get_field('app_store_link');

$google_play_button = get_template_directory() . '/assets/public/images/svg/google-play-inverted.svg';
$google_play_link = get_field('google_play_link');

?>

<div class="site-header-mobile">
  <div class="container">
    <nav class="site-header-mobnav">
      <?php
      wp_nav_menu(array(
        'theme_location'  => 'primary',
        'menu_id'          => 'mobile-menu',
        'menu_class'      => 'mobile-menu',
        'container'        => '',
      ));
      ?>
      <div class="site-header-mobcta">
        <div class="signin">
          <a href="/" class="signin-link"><?php _e('Sign In', 'surprise'); ?></a>
        </div>
      </div>
        <div class="site-header-appbuttons">
            <?php
            // App store button
            if(wp_is_mobile() && $is_iphone || !wp_is_mobile()){
                    $html = wp_is_mobile() ? "<a class='get-the-app' href='{$app_store_link['url']}' target='{$app_store_link['target']}'>" : "<div class='get-the-app'>";
                    $html .= file_get_contents($app_store_button);
                    $html .= wp_is_mobile() ? "</a>" : "</div>";

                    echo $html;
            }

            // Google Play button
            if(wp_is_mobile() && !$is_iphone || !wp_is_mobile()) {
	            $html = wp_is_mobile() ? "<a class='get-the-app' href='{$google_play_link['url']}' target='{$google_play_link['target']}'>" : "<div class='get-the-app'>";
	            $html .= file_get_contents($google_play_button);
	            $html .= wp_is_mobile() ? "</a>" : "</div>";

	            echo $html;
            }
             ?>
        </div>
    </nav>
  </div>
</div>