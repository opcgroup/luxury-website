<?php
/** Inner pages use independent design controls. Homepage uses front-page.php unchanged. */
get_header();
if(have_posts()):while(have_posts()):the_post();
$post=get_post();
$design=lw_page_resolved_design($post);
if($design['hero']==='show')lw_page_design_banner($post,$design);
?>
<article <?php post_class('lw-inner-page lw-layout-'.sanitize_html_class($design['layout'])); ?>>
 <div class="lw-page-inner">
  <?php the_content();wp_link_pages(); ?>
 </div>
</article>
<?php endwhile;endif;get_footer();
