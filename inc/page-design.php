<?php
/** Individual page design settings: kept separate from fixed homepage rendering. */
if (!defined('ABSPATH')) exit;

function lw_page_design_fields() {
    return array(
        '_lw_page_layout' => array('default'=>'auto','allowed'=>array('auto','narrow','contained','wide','full'), 'label'=>'Content layout'),
        '_lw_page_hero' => array('default'=>'auto','allowed'=>array('auto','show','hide'), 'label'=>'Page title banner'),
        '_lw_page_hero_style' => array('default'=>'solid','allowed'=>array('solid','gradient','photo'), 'label'=>'Banner style'),
        '_lw_page_subtitle' => array('default'=>'', 'label'=>'Subtitle'),
    );
}
function lw_page_setting($id,$key) {
    $fields=lw_page_design_fields();
    if(!isset($fields[$key])) return '';
    $v=(string)get_post_meta($id,$key,true);
    if($v==='') $v=$fields[$key]['default'];
    if(isset($fields[$key]['allowed']) && !in_array($v,$fields[$key]['allowed'],true)) $v=$fields[$key]['default'];
    return $v;
}
add_action('init',function(){
    foreach(lw_page_design_fields() as $key=>$f) {
        register_post_meta('page',$key,array(
            'single'=>true,'type'=>'string','default'=>$f['default'],'show_in_rest'=>true,
            'sanitize_callback'=>function($value,$meta_key) use($key,$f) {
                $value=sanitize_text_field($value);
                return isset($f['allowed']) && !in_array($value,$f['allowed'],true) ? $f['default'] : $value;
            },
            'auth_callback'=>function(){return current_user_can('edit_pages');},
        ));
    }
},12);

add_action('add_meta_boxes_page',function(){
    add_meta_box('lw-page-design','Luxury Page Design','lw_page_design_metabox','page','side','high',array('__back_compat_meta_box'=>true));
});
function lw_page_design_metabox($post) {
    wp_nonce_field('lw_page_design_save','lw_page_design_nonce');
    $choice=array(
      '_lw_page_layout'=>array('auto'=>'Automatic','narrow'=>'Narrow (reading)','contained'=>'Standard','wide'=>'Wide','full'=>'Full Width'),
      '_lw_page_hero'=>array('auto'=>'Automatic','show'=>'Show title banner','hide'=>'Hide title banner'),
      '_lw_page_hero_style'=>array('solid'=>'Solid','gradient'=>'Gradient','photo'=>'Featured image'),
    );
    foreach($choice as $key=>$options) {
        echo '<p><label for="'.esc_attr($key).'"><strong>'.esc_html(lw_page_design_fields()[$key]['label']).'</strong></label><select style="width:100%" name="lw_page_settings['.esc_attr($key).']" id="'.esc_attr($key).'">';
        $current=lw_page_setting($post->ID,$key);
        foreach($options as $value=>$label) echo '<option value="'.esc_attr($value).'" '.selected($current,$value,false).'>'.esc_html($label).'</option>';
        echo '</select></p>';
    }
    echo '<p><label for="lw-page-subtitle"><strong>Banner subtitle</strong></label><textarea rows="2" style="width:100%" name="lw_page_settings[_lw_page_subtitle]" id="lw-page-subtitle">'.esc_textarea(lw_page_setting($post->ID,'_lw_page_subtitle')).'</textarea></p>';
    echo '<p>For the visual editor, open the <strong>Luxury Page Design</strong> sidebar. Existing pages are unchanged until you choose a setting.</p>';
}
add_action('save_post_page',function($post_id){
    if(!isset($_POST['lw_page_design_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lw_page_design_nonce'])),'lw_page_design_save'))return;
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)return;
    if(wp_is_post_revision($post_id) || !current_user_can('edit_post',$post_id))return;
    $submitted=isset($_POST['lw_page_settings']) && is_array($_POST['lw_page_settings']) ? wp_unslash($_POST['lw_page_settings']) : array();
    foreach(lw_page_design_fields() as $key=>$f){
        if(!isset($submitted[$key]) || !is_string($submitted[$key]))continue;
        $v=sanitize_text_field($submitted[$key]);
        if(isset($f['allowed'])&&!in_array($v,$f['allowed'],true))$v=$f['default'];
        update_post_meta($post_id,$key,$v);
    }
});

function lw_page_has_visual_layout($post){
    if(!$post)return false;
    if(get_post_meta($post->ID,'_elementor_edit_mode',true)==='builder')return true;
    $content=(string)$post->post_content;
    return strpos($content,'<!-- wp:luxury/')!==false ||
       strpos($content,'"align":"full"')!==false ||
       strpos($content,'"align":"wide"')!==false ||
       strpos($content,'class="alignfull')!==false ||
       strpos($content,'<!-- wp:core/cover')!==false;
}
function lw_page_resolved_design($post){
    $layout=lw_page_setting($post->ID,'_lw_page_layout');
    $hero=lw_page_setting($post->ID,'_lw_page_hero');
    $template=get_page_template_slug($post->ID);
    $visual=lw_page_has_visual_layout($post);
    if($template==='templates/page-full-width.php')$layout='full';
    elseif($template==='templates/page-landing.php') { $layout='full';$hero='hide'; }
    if($layout==='auto')$layout=$visual?'full':'contained';
    if($hero==='auto')$hero=$visual?'hide':'show';
    return array('layout'=>$layout,'hero'=>$hero,'style'=>lw_page_setting($post->ID,'_lw_page_hero_style'),'subtitle'=>lw_page_setting($post->ID,'_lw_page_subtitle'));
}
function lw_page_design_banner($post,$design){
    $class='lw-page-banner lw-page-banner-'.sanitize_html_class($design['style']);
    $style='';
    if($design['style']==='photo' && has_post_thumbnail($post->ID)){
        $url=get_the_post_thumbnail_url($post->ID,'full');
        if($url)$style='background-image:linear-gradient(90deg,rgba(10,21,25,.8),rgba(10,21,25,.3)),url('.esc_url($url).')';
    }
    echo '<section class="'.esc_attr($class).'"'.($style?' style="'.esc_attr($style).'"':'').'><div class="lw-container"><span class="lw-page-banner-kicker">'.esc_html(get_bloginfo('name')).'</span><h1>'.esc_html(get_the_title($post)).'</h1>';
    if($design['subtitle'])echo '<p>'.esc_html($design['subtitle']).'</p>';
    echo '</div></section>';
}
add_action('enqueue_block_editor_assets',function(){
    $screen=function_exists('get_current_screen')?get_current_screen():null;
    if(!$screen || $screen->post_type!=='page')return;
    wp_enqueue_script('lw-page-design-editor',LW_URI.'/assets/js/page-design-editor.js',array('wp-element','wp-components','wp-plugins','wp-edit-post','wp-data','wp-core-data'),LW_VERSION,true);
    // Inner page patterns are registered server-side on init for reliable visibility.
    wp_enqueue_style('lw-inner-page-editor',LW_URI.'/assets/css/inner-pages.css',array(),LW_VERSION);
});
add_action('wp_enqueue_scripts',function(){
    if(is_page())wp_enqueue_style('lw-inner-pages',LW_URI.'/assets/css/inner-pages.css',array('lw-main','lw-builder'),LW_VERSION);
});

add_action('init',function(){
    if(!function_exists('register_block_style'))return;
    $styles=array(
        'core/group'=>array('lw-card'=>'Luxury Card','lw-glass'=>'Glass Panel','lw-soft'=>'Soft Background','lw-dark'=>'Dark Panel','lw-border'=>'Bordered Panel'),
        'core/columns'=>array('lw-equal-cards'=>'Equal Height Cards'),
        'core/image'=>array('lw-rounded'=>'Rounded Image','lw-shadow'=>'Premium Shadow'),
        'core/button'=>array('lw-outline'=>'Luxury Outline'),
    );
    foreach($styles as $block=>$choices)foreach($choices as $name=>$label)register_block_style($block,array('name'=>$name,'label'=>$label));
},21);
