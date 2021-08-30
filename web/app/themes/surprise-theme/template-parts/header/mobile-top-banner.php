<?php
$show_top_banner = get_field( 'mobile_top_banner', 'options' );

if ( $show_top_banner == false )
	return;
?>
<div class="mobile-top-banner">
	<p><?php echo get_field('mobile_top_banner_text', 'options'); ?></p>
</div>