<?php
/** Luxury Website bootstrap. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'LW_VERSION', '1.3.5' );
define( 'LW_DIR', get_template_directory() );
define( 'LW_URI', get_template_directory_uri() );

require_once LW_DIR . '/inc/options.php';
require_once LW_DIR . '/inc/customizer.php';
require_once LW_DIR . '/inc/projects.php';
require_once LW_DIR . '/inc/forms.php';
require_once LW_DIR . '/inc/updater.php';
require_once LW_DIR . '/inc/seo.php';
require_once LW_DIR . '/inc/blocks.php';
require_once LW_DIR . '/inc/page-design.php';
require_once LW_DIR . '/inc/patterns.php';

function lw_setup() {
    load_theme_textdomain( 'luxury-website', LW_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 330, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );
    register_nav_menus( array( 'primary' => __( 'Primary Menu', 'luxury-website' ), 'footer' => __( 'Footer Menu', 'luxury-website' ) ) );
    add_image_size( 'lw-project', 780, 560, true );
}
add_action( 'after_setup_theme', 'lw_setup' );

function lw_assets() {
    wp_enqueue_style( 'lw-main', get_stylesheet_uri(), array(), LW_VERSION );
    wp_enqueue_script( 'lw-front', LW_URI . '/assets/js/front.js', array(), LW_VERSION, true );
    $o = lw_options(); $p = lw_presets()[$o['preset']] ?? lw_presets()['utopia'];
    $colors = array( 'primary','accent','background','surface','ink','muted' );
    $css = ':root{';
    foreach ( $colors as $key ) { $css .= '--lw-' . $key . ':' . esc_html( $o[$key] ) . ';'; }
    $css .= '--lw-anim-speed:' . absint( $o['animation_speed'] ) . 'ms;';
    $css .= '--lw-container:' . absint( $o['container_width'] ) . 'px;--lw-radius:' . absint( $o['radius'] ) . 'px;--lw-header-height:' . absint( $o['header_height'] ) . 'px;--lw-section-gap:' . absint( $o['section_gap'] ) . 'px;';
    $fonts = lw_fonts(); $font = isset($fonts[$o['font']]) ? $fonts[$o['font']]['css'] : $fonts['modern']['css'];
    $css .= '--lw-font:' . $font . ';';
    $css .= '--lw-topbar-bg:' . esc_html( $o['topbar_bg'] ) . ';--lw-topbar-color:' . esc_html( $o['topbar_color'] ) . ';';
    $css .= '--lw-header-gap:' . absint( $o['header_gap'] ) . 'px;--lw-menu-gap:' . absint( $o['menu_gap'] ) . 'px;--lw-menu-font:' . absint( $o['menu_font_size'] ) . 'px;--lw-mobile-height:' . absint( $o['header_mobile_height'] ) . 'px;';
    $css .= '--lw-header-bg:' . esc_html( $o['header_bg'] ) . ';--lw-header-color:' . esc_html( $o['header_color'] ) . ';';
    $css .= '}';
    $css .= '.lw-header-main{padding-block:' . absint( $o['header_padding'] ) . 'px;}';
    $css .= '.lw-hero{min-height:' . absint( $o['hero_height'] ) . 'px;}';
    $css .= '.lw-logo img{max-height:' . absint( $o['logo_height'] ) . 'px;}';
    if ( is_post_type_archive('lw_project') ) {
        $pad = absint($o['archive_banner_padding']);
        $css .= '.lw-archive-hero{padding-block:'.$pad.'px;}';
        if ($o['archive_bg_color']) $css .= '.lw-archive-hero{background-color:'.esc_attr($o['archive_bg_color']).';}';
        if ($o['archive_bg_image']) {
            $url = esc_url_raw($o['archive_bg_image']);
            // A JSON-quoted URL prevents a supplied filename from breaking the CSS string.
            $css .= '.lw-archive-hero{background-image:linear-gradient(rgba(8,24,43,.70),rgba(8,24,43,.70)),url('.wp_json_encode($url).');background-size:cover;background-position:center;}';
        }
    }
    if ( $o['custom_css'] ) { $css .= wp_strip_all_tags( $o['custom_css'] ); }
    wp_add_inline_style( 'lw-main', $css );
}
add_action( 'wp_enqueue_scripts', 'lw_assets' );

function lw_body_classes( $classes ) {
    $o = lw_options();
    $classes[] = 'lw-theme';
    $classes[] = 'lw-preset-' . sanitize_html_class( $o['preset'] );
    $classes[] = 'lw-card-' . sanitize_html_class( $o['card_style'] );
    $classes[] = 'lw-card-hover-' . sanitize_html_class( $o['card_hover'] );
    $classes[] = 'lw-mode-' . sanitize_html_class( $o['site_mode'] );
    $classes[] = 'lw-hero-' . sanitize_html_class( $o['hero_style'] );
    $classes[] = 'lw-animation-' . sanitize_html_class( $o['animation'] );
    $classes[] = $o['header_shadow'] ? 'lw-header-shadow' : 'lw-header-no-shadow';
    $classes[] = $o['header_width_full'] ? 'lw-header-fullwidth' : 'lw-header-contained';
    $classes[] = $o['header_sticky'] ? 'lw-is-sticky' : 'lw-not-sticky';
    $classes[] = $o['header_transparent'] ? 'lw-header-transparent' : 'lw-header-solid';
    $classes[] = $o['buttons_round'] ? 'lw-rounded-buttons' : 'lw-square-buttons';
    return $classes;
}
add_filter( 'body_class', 'lw_body_classes' );

function lw_excerpt_length() { return 24; }
add_filter( 'excerpt_length', 'lw_excerpt_length', 99 );

function lw_active_link( $url, $fallback = '#' ) { return $url ? esc_url( $url ) : esc_url( $fallback ); }
function lw_phone_href( $value ) { return 'tel:' . preg_replace( '/[^0-9+]/', '', $value ); }
function lw_whatsapp_href() { $o = lw_options(); $number = preg_replace( '/[^0-9]/', '', $o['whatsapp'] ?: $o['phone'] ); return $number ? 'https://wa.me/' . $number : ''; }

function lw_page_hero( $title, $subtitle = '' ) {
    echo '<section class="lw-inner-hero"><div class="lw-container"><span class="lw-eyebrow">' . esc_html( get_bloginfo('name') ) . '</span><h1>' . esc_html( $title ) . '</h1>';
    if ( $subtitle ) echo '<p>' . esc_html( $subtitle ) . '</p>';
    echo '</div></section>';
}

function lw_project_card( $id ) {
    $type = get_the_terms( $id, 'lw_project_type' );
    $terms = ( $type && !is_wp_error($type) ) ? wp_list_pluck( $type, 'slug' ) : array();
    $location = get_post_meta($id,'_lw_location',true);
    $bhk = get_post_meta($id,'_lw_configuration',true);
    $area = get_post_meta($id,'_lw_area',true);
    $price = get_post_meta($id,'_lw_price',true);
    $status = get_post_meta($id,'_lw_status',true);
    $listing = get_post_meta($id,'_lw_listing_kind',true);
    $featured = get_post_meta($id,'_lw_featured',true);
    echo '<article class="lw-property-card lw-reveal" data-type="'.esc_attr(implode(' ',$terms)).'">';
    echo '<a class="lw-property-image" href="'.esc_url(get_permalink($id)).'">';
    if(has_post_thumbnail($id)) echo get_the_post_thumbnail($id,'lw-project',array('loading'=>'lazy','alt'=>get_the_title($id)));
    else echo '<span class="lw-property-placeholder"><span>LW</span><small>'.esc_html(get_bloginfo('name')).'</small></span>';
    if($status) echo '<span class="lw-property-badge">'.esc_html($status).'</span>';
    elseif($listing) echo '<span class="lw-property-badge">'.esc_html(ucwords(str_replace('-',' ',$listing))).'</span>';
    if($featured) echo '<span class="lw-property-featured">Featured</span>';
    echo '</a><div class="lw-property-info">';
    if($location) echo '<span class="lw-property-location">⌖ '.esc_html($location).'</span>';
    echo '<h3><a href="'.esc_url(get_permalink($id)).'">'.esc_html(get_the_title($id)).'</a></h3>';
    if($bhk || $area) echo '<p class="lw-property-spec">'.esc_html(implode('  •  ',array_filter(array($bhk,$area)))).'</p>';
    echo '<div class="lw-property-bottom"><strong>'.esc_html($price ?: __('Price on request','luxury-website')).'</strong><a href="'.esc_url(get_permalink($id)).'" aria-label="'.esc_attr(sprintf(__('View details: %s','luxury-website'),get_the_title($id))).'">↗</a></div>';
    echo '<a class="lw-card-view" href="'.esc_url(get_permalink($id)).'">View Property & Enquire ↗</a></div></article>';
}

function lw_fallback_menu() {
    echo '<ul class="lw-menu"><li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home','luxury-website') . '</a></li>';
    if ( post_type_exists('lw_project') ) echo '<li><a href="' . esc_url(get_post_type_archive_link('lw_project')) . '">' . esc_html__('Projects','luxury-website') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#contact')) . '">' . esc_html__('Contact','luxury-website') . '</a></li></ul>';
}

function lw_render_element( $name, $mobile = false ) {
    $o = lw_options();
    switch ( $name ) {
        case 'logo':
            echo '<div class="lw-logo">'; if ( has_custom_logo() ) the_custom_logo(); else echo '<a href="'.esc_url(home_url('/')).'" class="lw-text-logo">'.esc_html(get_bloginfo('name')).'</a>'; echo '</div>';
            break;
        case 'menu':
            wp_nav_menu(array('theme_location'=>'primary','container'=>false,'menu_class'=>'lw-menu','fallback_cb'=>'lw_fallback_menu','depth'=>3));
            break;
        case 'phone': if ($o['phone']) echo '<a class="lw-header-contact" href="'.esc_url(lw_phone_href($o['phone'])).'">☎ <span>'.esc_html($o['phone']).'</span></a>'; break;
        case 'email': if ($o['email']) echo '<a class="lw-header-contact" href="mailto:'.esc_attr($o['email']).'">✉ <span>'.esc_html($o['email']).'</span></a>'; break;
        case 'cta': echo '<a class="lw-button lw-button-small" href="'.lw_active_link($o['cta_url'],'#contact').'">'.esc_html($o['cta_text']).'</a>'; break;
        case 'whatsapp': if (lw_whatsapp_href()) echo '<a class="lw-header-contact" href="'.esc_url(lw_whatsapp_href()).'" rel="noopener noreferrer" target="_blank">WhatsApp</a>'; break;
        case 'tagline': echo '<span class="lw-tagline">'.esc_html($o['tagline'] ?: get_bloginfo('description')).'</span>'; break;
        case 'social':
            echo '<div class="lw-socials">';foreach (array('instagram'=>'IG','facebook'=>'FB','youtube'=>'YT') as $social=>$label) if (!empty($o[$social])) echo '<a href="'.esc_url($o[$social]).'" target="_blank" rel="noopener noreferrer" aria-label="'.esc_attr($social).'">'.esc_html($label).'</a>';echo '</div>';break;
        case 'search': get_search_form(); break;
        case 'spacer': echo '<span class="lw-spacer"></span>';break;
        case 'toggle': echo '<button type="button" class="lw-menu-toggle" aria-label="'.esc_attr__('Toggle navigation','luxury-website').'" aria-expanded="false" aria-controls="lw-mobile-nav"><span></span><span></span><span></span></button>';break;
    }
}
function lw_render_zone( $id ) {
    $o = lw_options(); $items = array_filter(array_map('trim',explode(',', $o[$id] ?? '')));
    echo '<div class="lw-header-zone lw-zone-'.esc_attr($id).'">';
    foreach ($items as $item) if (in_array($item, lw_header_elements(), true)) lw_render_element($item);
    echo '</div>';
}

add_action( 'widgets_init', function() {
    register_sidebar(array('name'=>'Footer Widgets','id'=>'lw-footer','before_widget'=>'<div class="lw-footer-widget">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>'));
});
