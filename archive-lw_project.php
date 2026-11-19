<?php
if (!defined('ABSPATH')) exit;
get_header();
$lw_show_banner = (bool) lw_opt('archive_show_banner', 1);
$lw_archive_title = lw_opt('archive_title', 'Explore Real Estate');
$lw_archive_kicker = lw_opt('archive_kicker', '');
if ($lw_archive_kicker === '') $lw_archive_kicker = get_bloginfo('name');
if ($lw_show_banner) : ?>
<section class="lw-inner-hero lw-archive-hero lw-archive-align-<?php echo esc_attr(lw_opt('archive_align','left')); ?>"><div class="lw-container">
 <?php if ($lw_archive_kicker) : ?><span class="lw-eyebrow"><?php echo esc_html($lw_archive_kicker); ?></span><?php endif; ?>
 <h1><?php echo esc_html($lw_archive_title); ?></h1>
 <?php if (lw_opt('archive_description')) : ?><p><?php echo esc_html(lw_opt('archive_description')); ?></p><?php endif; ?>
</div></section>
<?php endif; ?>
<section class="lw-section lw-property-archive"><div class="lw-container">
 <?php if (!$lw_show_banner) : ?><h1 class="lw-archive-inline-title"><?php echo esc_html($lw_archive_title); ?></h1><?php endif; ?>
 <div class="lw-property-directory-head"><div>
 <?php if (lw_opt('archive_search_kicker')) : ?><span class="lw-eyebrow"><?php echo esc_html(lw_opt('archive_search_kicker')); ?></span><?php endif; ?>
 <h2><?php echo esc_html(lw_opt('archive_search_title','Search Available Properties')); ?></h2></div>
 <?php if (lw_opt('archive_show_results_count',1)) : ?><span class="lw-result-count"><?php global $wp_query; echo esc_html(number_format_i18n($wp_query->found_posts)); ?> results</span><?php endif; ?></div>
 <?php if (lw_opt('archive_show_search',1)) lw_render_property_search(); ?>
 <div class="lw-property-results"><div class="lw-project-grid">
 <?php if(have_posts()):while(have_posts()):the_post();lw_project_card(get_the_ID());endwhile;else: ?>
 <div class="lw-property-no-results"><h3>No matching properties found</h3><p>Try adjusting the property type, locality or budget.</p><a class="lw-button" href="<?php echo esc_url(get_post_type_archive_link('lw_project')); ?>">Clear Filters</a></div>
 <?php endif; ?></div></div><div class="lw-pagination"><?php the_posts_pagination(array('prev_text'=>'← Previous','next_text'=>'Next →')); ?></div>
 </div></section>
<?php get_footer(); ?>
