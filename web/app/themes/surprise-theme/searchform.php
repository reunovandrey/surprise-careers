<?php

/**
 * The searchform.php template.
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link https://developer.wordpress.org/reference/functions/wp_unique_id/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

/*
 * Generate a unique ID for each form and a string containing an aria-label
 * if one was passed to get_search_form() in the args array.
 */
$surprise_unique_id = wp_unique_id('search-form-');
$surprise_aria_label = !empty($args['aria_label']) ? 'aria-label="' . esc_attr($args['aria_label']) . '"' : '';
?>

<div id="blogSearchform" class="searchform-box">
  <form role="search" <?php echo $surprise_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
                      ?> method="GET" id="searchform-blog" class="searchform searchform-blog" action="<?php echo home_url('/'); ?>" name="searchform">
    <div class="searchform-inner">
      <label class="searchform-label" for="<?php echo esc_attr($surprise_unique_id); ?>">
        <input id="<?php echo esc_attr($surprise_unique_id); ?>" class="searchform-field" type="search" name="s" value="<?php echo get_search_query(); ?>" minlength="3" size="40" placeholder="<?php esc_attr_e('Search blog...', 'surprise'); ?>" title="<?php echo esc_attr_e('Find:', 'surprise') ?>">
        <span class="searchform-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M17.0917 15.9085L14 12.8418C15.2001 11.3455 15.7813 9.44625 15.6241 7.53458C15.4668 5.62292 14.5831 3.84415 13.1546 2.56403C11.7262 1.28392 9.86155 0.599756 7.94414 0.652223C6.02674 0.70469 4.20231 1.4898 2.84599 2.84612C1.48968 4.20243 0.704568 6.02686 0.652101 7.94427C0.599634 9.86167 1.2838 11.7263 2.56391 13.1548C3.84403 14.5832 5.62279 15.4669 7.53446 15.6242C9.44612 15.7814 11.3454 15.2002 12.8417 14.0002L15.9084 17.0668C15.9858 17.1449 16.078 17.2069 16.1796 17.2492C16.2811 17.2915 16.39 17.3133 16.5 17.3133C16.6101 17.3133 16.719 17.2915 16.8205 17.2492C16.9221 17.2069 17.0142 17.1449 17.0917 17.0668C17.2419 16.9114 17.3259 16.7038 17.3259 16.4877C17.3259 16.2715 17.2419 16.0639 17.0917 15.9085ZM8.16671 14.0002C7.01298 14.0002 5.88517 13.658 4.92588 13.0171C3.9666 12.3761 3.21892 11.4651 2.77741 10.3992C2.3359 9.33325 2.22038 8.16036 2.44546 7.0288C2.67054 5.89725 3.22611 4.85785 4.04192 4.04204C4.85773 3.22624 5.89713 2.67066 7.02868 2.44558C8.16024 2.2205 9.33313 2.33602 10.399 2.77753C11.4649 3.21904 12.376 3.96672 13.0169 4.926C13.6579 5.88529 14 7.01311 14 8.16683C14 9.71393 13.3855 11.1977 12.2915 12.2916C11.1975 13.3856 9.71381 14.0002 8.16671 14.0002Z" fill="currentColor" />
          </svg>
        </span>
      </label>
      <input type="hidden" name="post_type" value="post" />
      <!-- <input type="hidden" name="post_type" value="events" /> -->
      <button class="bttn bttn-search screen-reader-text" name="submit" type="submit" id="searchsubmit" value="<?php esc_attr_e('Search', 'surprise'); ?>"></button>
    </div>
  </form>
</div>