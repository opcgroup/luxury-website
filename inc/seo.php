<?php
/** Lightweight built-in SEO for pages, posts and projects. Yields to specialist SEO plugins. */
if (!defined('ABSPATH')) { exit; }

function lw_external_seo_active() {
    return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION')
        || defined('SEOPRESS_VERSION') || class_exists('WPSEO_Frontend', false)
        || function_exists('aioseo') || function_exists('rank_math');
}
function lw_seo_active() { return (bool) lw_opt('seo_enabled', 1) && !lw_external_seo_active(); }
function lw_seo_fields() {
    return array(
        '_lw_seo_title'=>array('label'=>'SEO Title','type'=>'string','hint'=>'Suggested: a specific, descriptive title.'),
        '_lw_seo_description'=>array('label'=>'Meta Description','type'=>'string','hint'=>'Write a natural summary for search previews.'),
        '_lw_seo_focus'=>array('label'=>'Focus Keyword','type'=>'string','hint'=>'Editorial target phrase; not automatically a ranking factor.'),
        '_lw_seo_keywords'=>array('label'=>'Related Keywords','type'=>'string','hint'=>'Comma-separated internal keyword notes. Meta keywords output is OFF by default.'),
        '_lw_seo_canonical'=>array('label'=>'Canonical URL','type'=>'string','hint'=>'Optional: only override if canonical should point elsewhere.'),
        '_lw_seo_og_image'=>array('label'=>'Social Share Image URL','type'=>'string','hint'=>'Featured Image is used when blank.'),
        '_lw_seo_noindex'=>array('label'=>'Noindex (exclude from search)','type'=>'boolean','hint'=>'Search engines should not index this page.'),
        '_lw_seo_nofollow'=>array('label'=>'Nofollow (links)','type'=>'boolean','hint'=>'Ask crawlers not to follow links on this page.'),
    );
}
add_action('init', function() {
    foreach (array('post','page','lw_project') as $type) {
        add_post_type_support($type,'custom-fields');
        foreach (lw_seo_fields() as $key => $info) {
            register_post_meta($type,$key,array(
                'type'=>$info['type'], 'single'=>true, 'default'=>$info['type']==='boolean'?false:'',
                'show_in_rest'=>true,
                'sanitize_callback'=>$info['type']==='boolean'?'rest_sanitize_boolean':(
                    $key==='_lw_seo_canonical'||$key==='_lw_seo_og_image'?'esc_url_raw':'sanitize_text_field'),
                'auth_callback'=>function($allowed,$meta_key,$post_id) { return $post_id ? current_user_can('edit_post',$post_id) : current_user_can('edit_posts'); },
            ));
        }
    }
},11);

add_action('add_meta_boxes', function() {
    foreach (array('post','page','lw_project') as $type) {
        add_meta_box('lw-seo-editor','Luxury SEO - Search & Social Preview','lw_seo_metabox',$type,'normal','default');
    }
});
function lw_seo_metabox($post) {
    wp_nonce_field('lw_seo_save','lw_seo_nonce');
    echo '<p>Search title, snippet description, social image, canonical and indexing controls. In Block Editor also use <strong>Luxury SEO</strong> in the right-hand sidebar.</p><table class="form-table"><tbody>';
    foreach (lw_seo_fields() as $key=>$info) {
        $value = get_post_meta($post->ID,$key,true);
        echo '<tr><th><label for="'.esc_attr($key).'">'.esc_html($info['label']).'</label></th><td>';
        if ($info['type']==='boolean') {
            echo '<label><input type="checkbox" id="'.esc_attr($key).'" name="'.esc_attr($key).'" value="1" '.checked((bool)$value,true,false).'> Enable</label>';
        } elseif ($key==='_lw_seo_description') {
            echo '<textarea id="'.esc_attr($key).'" rows="3" class="large-text" name="'.esc_attr($key).'">'.esc_textarea($value).'</textarea>';
        } else {
            echo '<input class="large-text" type="'.($key==='_lw_seo_canonical'||$key==='_lw_seo_og_image'?'url':'text').'" id="'.esc_attr($key).'" name="'.esc_attr($key).'" value="'.esc_attr($value).'">';
        }
        echo '<p class="description">'.esc_html($info['hint']).'</p></td></tr>';
    }
    echo '</tbody></table>';
    if (lw_external_seo_active()) echo '<p><strong>SEO plugin detected:</strong> its own metadata output takes precedence to avoid duplicates.</p>';
}
add_action('save_post',function($id){
    if (!isset($_POST['lw_seo_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lw_seo_nonce'])),'lw_seo_save')) return;
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($id) || !current_user_can('edit_post',$id)) return;
    foreach(lw_seo_fields() as $key=>$info) {
        $raw=isset($_POST[$key]) ? wp_unslash($_POST[$key]) : '';
        if ($info['type']==='boolean') $value = $raw==='1';
        elseif($key==='_lw_seo_canonical'||$key==='_lw_seo_og_image') $value=esc_url_raw($raw);
        elseif($key==='_lw_seo_description') $value=sanitize_textarea_field($raw);
        else $value=sanitize_text_field($raw);
        update_post_meta($id,$key,$value);
    }
},20);

/** Editable SEO for categories, tags and project types. */
function lw_seo_term_fields() {
    return array('title'=>'SEO Title','description'=>'Meta Description','keywords'=>'Related Keywords','canonical'=>'Canonical URL','og_image'=>'Social Image URL','noindex'=>'Noindex');
}
add_action('init',function() {
    foreach(array('category','post_tag','lw_project_type','lw_city') as $tax) {
        foreach(lw_seo_term_fields() as $field=>$label) {
            register_term_meta($tax,'_lw_seo_'.$field,array('single'=>true,'type'=>'string','show_in_rest'=>true,
              'sanitize_callback'=>$field==='canonical'||$field==='og_image'?'esc_url_raw':'sanitize_text_field',
              'auth_callback'=>function(){return current_user_can('manage_categories');}));
        }
        add_action($tax.'_add_form_fields','lw_seo_term_add');
        add_action($tax.'_edit_form_fields','lw_seo_term_edit');
        add_action('created_'.$tax,'lw_seo_term_save');
        add_action('edited_'.$tax,'lw_seo_term_save');
    }
},13);
function lw_seo_term_add($taxonomy) {
    wp_nonce_field('lw_seo_term','lw_seo_term_nonce');
    foreach(lw_seo_term_fields() as $field=>$label) {
        if($field==='noindex') echo '<div class="form-field"><label><input type="checkbox" name="lw_tax_seo[noindex]" value="1"> Noindex this archive</label></div>';
        else echo '<div class="form-field"><label for="lw-tax-'.esc_attr($field).'">'.esc_html($label).'</label><input type="text" name="lw_tax_seo['.esc_attr($field).']" id="lw-tax-'.esc_attr($field).'"></div>';
    }
}
function lw_seo_term_edit($term) {
    wp_nonce_field('lw_seo_term','lw_seo_term_nonce');
    foreach(lw_seo_term_fields() as $field=>$label) {
        $value=get_term_meta($term->term_id,'_lw_seo_'.$field,true);
        if($field==='noindex') echo '<tr class="form-field"><th>'.esc_html($label).'</th><td><label><input type="checkbox" name="lw_tax_seo[noindex]" value="1" '.checked((bool)$value,true,false).'> Noindex this archive</label></td></tr>';
        else echo '<tr class="form-field"><th><label for="lw-tax-'.esc_attr($field).'">'.esc_html($label).'</label></th><td><input type="text" name="lw_tax_seo['.esc_attr($field).']" id="lw-tax-'.esc_attr($field).'" value="'.esc_attr($value).'"></td></tr>';
    }
}
function lw_seo_term_save($id) {
    if(!current_user_can('manage_categories') || !isset($_POST['lw_seo_term_nonce']) ||
      !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lw_seo_term_nonce'])),'lw_seo_term')) return;
    $submitted=isset($_POST['lw_tax_seo']) && is_array($_POST['lw_tax_seo']) ? wp_unslash($_POST['lw_tax_seo']) : array();
    foreach(lw_seo_term_fields() as $field=>$label) {
       $raw=isset($submitted[$field]) && is_scalar($submitted[$field]) ? (string)$submitted[$field] : '';
       $value=$field==='noindex'?($raw==='1'?'1':''):(($field==='canonical'||$field==='og_image')?esc_url_raw($raw):sanitize_text_field($raw));
       update_term_meta($id,'_lw_seo_'.$field,$value);
    }
}
function lw_seo_term_value($key) {
    if(!(is_category()||is_tag()||is_tax())) return '';
    $term=get_queried_object();
    return $term instanceof WP_Term ? get_term_meta($term->term_id,'_lw_seo_'.$key,true) : '';
}
function lw_seo_post_id() {
    if (is_front_page() && get_option('show_on_front')==='page') return (int)get_option('page_on_front');
    if (is_home() && get_option('show_on_front')==='page') return (int)get_option('page_for_posts');
    return is_singular() ? get_queried_object_id() : 0;
}
function lw_seo_value($key,$id=0) {
    $id=$id ?: lw_seo_post_id();
    return $id ? get_post_meta($id,'_lw_seo_'.$key,true) : '';
}
function lw_seo_title_value() {
    $title=lw_seo_value('title');
    if ($title) return $title;
    if (is_category()||is_tag()||is_tax()) return lw_seo_term_value('title');
    if (is_post_type_archive('lw_project')) return lw_opt('seo_projects_title','');
    if (is_front_page()) return lw_opt('seo_home_title','') ?: get_bloginfo('name') . ' | ' . get_bloginfo('description');
    return '';
}
add_filter('pre_get_document_title',function($title){
    if (!lw_seo_active() || is_admin()) return $title;
    return lw_seo_title_value() ?: $title;
},20);
function lw_seo_description_value() {
    $custom=lw_seo_value('description'); if ($custom) return $custom;
    if (is_front_page()) return lw_opt('seo_home_description','') ?: get_bloginfo('description');
    if (is_category()||is_tag()||is_tax()) return lw_seo_term_value('description') ?: wp_strip_all_tags(term_description());
    if (is_post_type_archive('lw_project')) return lw_opt('seo_projects_description','') ?: get_bloginfo('description');
    $id=lw_seo_post_id();
    if($id){$post=get_post($id);if($post){
        $content=$post->post_excerpt ?: $post->post_content;
        // Do not place Gutenberg block comments or shortcodes into the HTML meta description.
        $content=function_exists('excerpt_remove_blocks') ? excerpt_remove_blocks($content) : $content;
        $content=trim(preg_replace('/\s+/u',' ',wp_strip_all_tags(strip_shortcodes($content))));
        return wp_trim_words($content,27,'…');
    }}
    return is_category() || is_tag() || is_tax() ? term_description() : get_bloginfo('description');
}
function lw_seo_url() {
    $canonical=lw_seo_value('canonical'); if($canonical) return esc_url_raw($canonical);
    $paged=max(1,(int)get_query_var('paged'));
    if (is_category()||is_tag()||is_tax()) {
        $term_canonical=lw_seo_term_value('canonical');
        if ($term_canonical) return esc_url_raw($term_canonical);
        // Page 2+ of an archive is not a duplicate of page 1. Never canonicalize all pages to page 1.
        if ($paged>1) return get_pagenum_link($paged);
        $term_url=get_term_link(get_queried_object());
        return !is_wp_error($term_url)?$term_url:'';
    }
    if ((is_post_type_archive('lw_project')||is_home()||is_front_page()) && $paged>1) return get_pagenum_link($paged);
    if(is_front_page()) return home_url('/');
    $id=lw_seo_post_id(); if($id) return get_permalink($id);
    if(is_post_type_archive('lw_project')) return get_post_type_archive_link('lw_project');
    return '';
}
function lw_seo_image() {
    $image=lw_seo_value('og_image'); if($image) return $image;
    if(is_category()||is_tag()||is_tax()) return lw_seo_term_value('og_image');
    if(is_front_page() && lw_opt('seo_home_og_image')) return lw_opt('seo_home_og_image');
    $id=lw_seo_post_id(); return $id ? get_the_post_thumbnail_url($id,'full') : '';
}
add_action('wp',function(){
    if (!lw_seo_active()) return;
    if (lw_seo_value('canonical') && lw_seo_post_id()) remove_action('wp_head','rel_canonical');
});
add_filter('wp_robots',function($robots){
    if (!lw_seo_active()) return $robots;
    if (lw_seo_value('noindex') || lw_seo_term_value('noindex')) {unset($robots['index']);$robots['noindex']=true;}
    if (lw_seo_value('nofollow')) {unset($robots['follow']);$robots['nofollow']=true;}
    return $robots;
},30);
/** Basic navigation breadcrumb markup; does not assert unverified real-estate data. */
function lw_seo_breadcrumb_schema($id) {
    if (!$id || !is_singular()) return array();
    $items=array();
    $add=function($name,$url) use (&$items) {
        if ($name && $url) $items[]=array('@type'=>'ListItem','position'=>count($items)+1,'name'=>wp_strip_all_tags($name),'item'=>esc_url_raw($url));
    };
    $add(get_bloginfo('name'),home_url('/'));
    if (is_page()) {
        foreach(array_reverse(get_post_ancestors($id)) as $ancestor) $add(get_the_title($ancestor),get_permalink($ancestor));
    } elseif (is_singular('lw_project')) {
        $add(__('Properties','luxury-website'),get_post_type_archive_link('lw_project'));
    } elseif (is_singular('post') && get_option('show_on_front')==='page' && (int)get_option('page_for_posts')) {
        $blog_id=(int)get_option('page_for_posts');
        $add(get_the_title($blog_id),get_permalink($blog_id));
    }
    $add(get_the_title($id),get_permalink($id));
    if (count($items)<2) return array();
    return array('@type'=>'BreadcrumbList','@id'=>get_permalink($id).'#breadcrumbs','itemListElement'=>$items);
}
add_action('wp_head',function(){
    if (!lw_seo_active() || is_admin() || is_404() || is_search() || is_feed()) return;
    $title=lw_seo_title_value() ?: wp_get_document_title();
    $description=trim(wp_strip_all_tags((string) lw_seo_description_value()));
    $url=lw_seo_url();$image=lw_seo_image();
    if($description) echo '<meta name="description" content="'.esc_attr($description).'">' . "\n";
    // WordPress already outputs a canonical for singular pages; print only our override or non-singular home.
    if (lw_seo_value('canonical') || is_category() || is_tag() || is_tax() || is_post_type_archive('lw_project') || (is_front_page() && !lw_seo_post_id())) {
        if($url) echo '<link rel="canonical" href="'.esc_url($url).'">' . "\n";
    }
    if(lw_opt('seo_emit_keywords',0)) {
        $keywords=lw_seo_value('keywords') ?: lw_seo_term_value('keywords');
        if(!$keywords && is_front_page()) $keywords=lw_opt('seo_home_keywords','');
        if($keywords) echo '<meta name="keywords" content="'.esc_attr($keywords).'">' . "\n";
    }
    echo '<meta property="og:type" content="'.(is_singular('post')?'article':'website').'">' . "\n";
    echo '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'">' . "\n";
    echo '<meta property="og:title" content="'.esc_attr($title).'">' . "\n";
    if($description) echo '<meta property="og:description" content="'.esc_attr($description).'">' . "\n";
    if($url) echo '<meta property="og:url" content="'.esc_url($url).'">' . "\n";
    if($image) echo '<meta property="og:image" content="'.esc_url($image).'">' . "\n";
    echo '<meta name="twitter:card" content="'.($image?'summary_large_image':'summary').'">' . "\n";
    $schema=array('@context'=>'https://schema.org','@type'=>is_singular('post')?'BlogPosting':'WebPage',
        'name'=>$title,'description'=>$description,'url'=>$url ?: home_url('/'));
    $id=lw_seo_post_id(); if($id && is_singular('post')) {
        $post=get_post($id);
        $schema['datePublished']=get_the_date('c',$id);
        $schema['dateModified']=get_the_modified_date('c',$id);
        $schema['author']=array('@type'=>'Person','name'=>get_the_author_meta('display_name',$post->post_author));
    }
    if($image) $schema['image']=$image;
    $breadcrumb=lw_seo_breadcrumb_schema($id);
    if ($breadcrumb) $schema['breadcrumb']=array('@id'=>$breadcrumb['@id']);
    $graph=array($schema);
    if ($breadcrumb) $graph[]=$breadcrumb;
    // FAQ schema mirrors the questions actually rendered in the theme homepage.
    if(is_front_page() && lw_opt('faq_enable')) {
        $front_id=(int)get_option('page_on_front');
        $custom_home=$front_id && (lw_opt('use_page_content') || get_post_meta($front_id,'_elementor_edit_mode',true)==='builder' || strpos((string)get_post_field('post_content',$front_id),'<!-- wp:luxury/')!==false);
        if(!$custom_home) {
            $entities=array();
            foreach(lw_faq_items() as $faq) {
                if(empty($faq['answer'])) continue;
                $entities[]=array('@type'=>'Question','name'=>$faq['question'],'acceptedAnswer'=>array('@type'=>'Answer','text'=>$faq['answer']));
            }
            if($entities) $graph[]=array('@type'=>'FAQPage','@id'=>home_url('/').'#faq','mainEntity'=>$entities);
        }
    }

    // JSON_HEX_TAG prevents user-editable values from closing the JSON-LD script element.
    echo '<script type="application/ld+json">'.wp_json_encode(array('@context'=>'https://schema.org','@graph'=>$graph),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT).'</script>' . "\n";
},3);

add_action('enqueue_block_editor_assets',function(){
    $screen=function_exists('get_current_screen')?get_current_screen():null;
    if(!$screen || !in_array($screen->post_type,array('post','page','lw_project'),true)) return;
    wp_enqueue_script('lw-seo-sidebar',LW_URI.'/assets/js/seo-editor.js',array('wp-element','wp-components','wp-plugins','wp-edit-post','wp-data','wp-block-editor'),LW_VERSION,true);
    wp_enqueue_style('lw-seo-editor',LW_URI.'/assets/css/seo-editor.css',array(),LW_VERSION);
    wp_add_inline_script('lw-seo-sidebar','window.LWSEO=' . wp_json_encode(array('pluginActive'=>lw_external_seo_active())) . ';','before');
});
