<?php if(!defined('ABSPATH')) exit; $o=lw_options(); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="lw-skip-link" href="#lw-main">Skip to content</a>
<header id="lw-site-header" class="lw-site-header" role="banner">
 <div class="lw-desktop-header">
 <?php if($o['topbar_enable']): ?><div class="lw-header-top"><div class="lw-container lw-header-row"><?php lw_render_zone('header_top_left'); lw_render_zone('header_top_center'); lw_render_zone('header_top_right'); ?></div></div><?php endif; ?>
 <div class="lw-header-main"><div class="lw-container lw-header-row"><?php lw_render_zone('header_main_left'); lw_render_zone('header_main_center'); lw_render_zone('header_main_right'); ?></div></div>
 <?php if($o['bottomrow_enable']): ?><div class="lw-header-bottom"><div class="lw-container lw-header-row"><?php lw_render_zone('header_bottom_left'); lw_render_zone('header_bottom_center'); lw_render_zone('header_bottom_right'); ?></div></div><?php endif; ?>
 </div>
 <div class="lw-mobile-header"><div class="lw-container lw-mobile-header-inner"><?php lw_render_zone('header_mobile_left'); lw_render_zone('header_mobile_right');
  if(strpos($o['header_mobile_left'].','.$o['header_mobile_right'],'toggle')===false) lw_render_element('toggle');
 ?></div></div>
 <div id="lw-mobile-nav" class="lw-mobile-nav" hidden><?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'menu_class'=>'lw-mobile-menu','fallback_cb'=>'lw_fallback_menu')); ?></div>
</header>
<main id="lw-main" class="lw-main" role="main">
