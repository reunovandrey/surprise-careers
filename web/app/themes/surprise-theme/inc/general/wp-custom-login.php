<?php

/**
 * Functions & Hooks which change default Wordpress login page
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */


/**
 * This class is changes login page
 */
class Surprise_Custom_Login
{
  /**
	 * Singleton pattern
	 */
	public static function getInstance() {
		static $instance;
		if( !isset( $instance ) ){
			$instance = new self();
		}
		return $instance;
	}
  /**
   * Instantiate the object.
   *
   * @access public
   *
   * @since Surprise 1.0
   */
  protected function __construct()
  {
    add_action('login_head', array($this, 'surprise_redirect_to_nonexistent_page'));
    add_action('init', array($this, 'surprise_redirect_to_actual_login'));
  }

  public function surprise_redirect_to_nonexistent_page()
  {

    $new_login =  'newlogin';
    if (strpos($_SERVER['REQUEST_URI'], $new_login) === false) {
      wp_safe_redirect(home_url('404'), 302);
      exit();
    }
  }


  public function surprise_redirect_to_actual_login()
  {
    $new_login =  'newlogin';
    if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) == $new_login && ($_GET['redirect'] !== false)) {
      wp_safe_redirect(home_url("wp-login.php?$new_login&redirect=false"));
      exit();
    }
  }
}
Surprise_Custom_Login::getInstance();