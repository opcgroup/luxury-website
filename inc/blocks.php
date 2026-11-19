<?php
/** No-code block builder. Native Gutenberg handles drag-drop, text editing and revisions. */
if (!defined('ABSPATH')) exit;

add_action('init',function() {
    register_block_type('luxury/property-grid',array(
        'api_version'=>2,
        'attributes'=>array('count'=>array('type'=>'number','default'=>6),'type'=>array('type'=>'string','default'=>''),
            'filters'=>array('type'=>'boolean','default'=>true)),
        'render_callback'=>'lw_property_grid_block',
    ));
});
function lw_property_grid_block($attributes) {
    $count=isset($attributes['count'])?max(1,min(24,(int)$attributes['count'])):6;
    $type=isset($attributes['type'])?sanitize_title($attributes['type']):'';
    $filters=isset($attributes['filters'])?(bool)$attributes['filters']:true;
    $args=array('post_type'=>'lw_project','post_status'=>'publish','posts_per_page'=>$count);
    if($type) $args['tax_query']=array(array('taxonomy'=>'lw_project_type','field'=>'slug','terms'=>$type));
    $query=new WP_Query($args);
    ob_start();
    echo '<section class="lw-builder-properties '.(!empty($attributes['className'])?esc_attr($attributes['className']):'').'">';
    if($query->have_posts()) {
        if($filters && !$type) {
            $terms=get_terms(array('taxonomy'=>'lw_project_type','hide_empty'=>true));
            if(!is_wp_error($terms) && $terms) {
                echo '<div class="lw-filter-bar" role="group" aria-label="Filter properties"><button type="button" class="is-active" data-filter="all" aria-pressed="true">All</button>';
                foreach($terms as $term) echo '<button type="button" data-filter="'.esc_attr($term->slug).'" aria-pressed="false">'.esc_html($term->name).'</button>';
                echo '</div>';
            }
        }
        echo '<div class="lw-project-grid">';
        while($query->have_posts()) {$query->the_post();lw_project_card(get_the_ID());}
        echo '</div>';
    } else echo '<p>No published projects yet. Add projects from the Projects menu.</p>';
    echo '</section>';wp_reset_postdata();
    return ob_get_clean();
}
add_action('enqueue_block_editor_assets',function(){
    wp_enqueue_script('lw-blocks',LW_URI.'/assets/js/blocks.js',
        array('wp-blocks','wp-element','wp-components','wp-block-editor','wp-hooks','wp-compose','wp-i18n'),LW_VERSION,true);
    wp_enqueue_style('lw-blocks-editor',LW_URI.'/assets/css/builder.css',array(),LW_VERSION);
});
add_action('wp_enqueue_scripts',function(){
    wp_enqueue_style('lw-builder',LW_URI.'/assets/css/builder.css',array('lw-main'),LW_VERSION);
    wp_enqueue_script('lw-builder-motion',LW_URI.'/assets/js/motion.js',array(),LW_VERSION,true);
});
