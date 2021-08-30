<?php

/**
 * The header for Surprise theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="sdc-overlay"></div>

  <div id="page" class="site site-page">
    <header id="masthead" class="site-header">
    <?php get_template_part('template-parts/header/site', 'mobnav'); ?>
      <?php get_template_part('template-parts/header/site', 'header'); ?>
    </header>

    <div id="content" class="site-content">