<?php
/** Real-estate project directory, editable listing data and property discovery. */
if (!defined('ABSPATH')) exit;

add_action('init', function () {
 register_post_type('lw_project', array(
  'labels'=>array('name'=>'Properties & Projects','singular_name'=>'Property / Project','add_new_item'=>'Add Property / Project','edit_item'=>'Edit Property / Project','all_items'=>'All Properties','menu_name'=>'Properties'),
  'public'=>true,'has_archive'=>true,'rewrite'=>array('slug'=>'projects'),
  'show_in_rest'=>true,'menu_icon'=>'dashicons-building','menu_position'=>23,
  'supports'=>array('title','editor','thumbnail','excerpt','revisions','custom-fields'),
  'taxonomies'=>array('lw_project_type','lw_city'),
  'show_in_nav_menus'=>true,
  ));
 register_taxonomy('lw_project_type','lw_project',array(
  'hierarchical'=>true,'labels'=>array('name'=>'Property Types','singular_name'=>'Property Type'),
  'public'=>true,'show_in_rest'=>true,'rewrite'=>array('slug'=>'project-type')));
 register_taxonomy('lw_city','lw_project',array(
  'hierarchical'=>true,'labels'=>array('name'=>'Cities / Localities','singular_name'=>'City / Locality'),
  'public'=>true,'show_in_rest'=>true,'rewrite'=>array('slug'=>'property-location')));
});
add_action('after_switch_theme', function () { flush_rewrite_rules(); });

function lw_project_meta_fields() {
 return array(
  '_lw_location'=>array('label'=>'Address / Micro-market (e.g. Eco City 2, New Chandigarh)'),
  '_lw_configuration'=>array('label'=>'Configuration (e.g. 3 BHK + Utility)'),
  '_lw_area'=>array('label'=>'Area displayed (e.g. 2,890 sq. ft.)'),
  '_lw_price'=>array('label'=>'Display price (e.g. From ₹1.25 Cr / Price on Request)'),
  '_lw_price_amount'=>array('label'=>'Numeric price in INR, for budget filter (e.g. 12500000)','type'=>'number'),
  '_lw_status'=>array('label'=>'Display badge / project status (e.g. New Launch)'),
  '_lw_listing_kind'=>array('label'=>'Listing Category','type'=>'select','choices'=>array(''=>'Select category','new-launch'=>'New Launch','resale'=>'Resale','rental'=>'Rental')),
  '_lw_developer'=>array('label'=>'Developer / Builder'),
  '_lw_possession'=>array('label'=>'Possession / Construction Status'),
  '_lw_bathrooms'=>array('label'=>'Bathrooms'),
  '_lw_parking'=>array('label'=>'Parking'),
  '_lw_furnishing'=>array('label'=>'Furnishing'),
  '_lw_rera'=>array('label'=>'RERA Registration Number'),
  '_lw_brochure'=>array('label'=>'Brochure PDF URL','type'=>'url'),
  '_lw_floor_plan'=>array('label'=>'Floor Plan Image / PDF URL','type'=>'url'),
  '_lw_map'=>array('label'=>'Google Maps / Location URL','type'=>'url'),
  '_lw_video'=>array('label'=>'Property Walkthrough Video URL','type'=>'url'),
  '_lw_amenities'=>array('label'=>'Amenities (one per line)','type'=>'textarea'),
  '_lw_gallery_ids'=>array('label'=>'Property Gallery Image IDs','type'=>'gallery'),
  '_lw_featured'=>array('label'=>'Featured / Highlighted Property','type'=>'checkbox'),
 );
}
add_action('add_meta_boxes', function () { add_meta_box('lw-project-info','Real Estate Property Information','lw_project_meta_box','lw_project','normal','high'); });
function lw_project_meta_box($post) {
 wp_nonce_field('lw_project_save','lw_project_nonce');
 echo '<p>Upload an elevation/property photo using <strong>Featured Image</strong>. Select Property Type and City / Locality in the editor sidebar. All optional fields can be left blank.</p><table class="form-table"><tbody>';
 foreach(lw_project_meta_fields() as $key=>$field) {
  $type=$field['type'] ?? 'text';$value=get_post_meta($post->ID,$key,true);
  echo '<tr><th><label for="'.esc_attr($key).'">'.esc_html($field['label']).'</label></th><td>';
  if ($type==='select') {
   echo '<select id="'.esc_attr($key).'" name="'.esc_attr($key).'">';
   foreach($field['choices'] as $k=>$name) echo '<option value="'.esc_attr($k).'" '.selected($value,$k,false).'>'.esc_html($name).'</option>';
   echo '</select>';
  } elseif($type==='textarea') {
   echo '<textarea class="large-text" rows="5" id="'.esc_attr($key).'" name="'.esc_attr($key).'">'.esc_textarea($value).'</textarea>';
  } elseif($type==='checkbox') {
   echo '<label><input type="checkbox" value="1" name="'.esc_attr($key).'" id="'.esc_attr($key).'" '.checked((bool)$value,true,false).'> Highlight this property</label>';
  } elseif($type==='gallery') {
   echo '<input class="regular-text" id="'.esc_attr($key).'" name="'.esc_attr($key).'" value="'.esc_attr($value).'" readonly><button type="button" class="button" id="lw-gallery-select">Choose Images</button> <button type="button" class="button" id="lw-gallery-clear">Clear</button><p class="description">Select multiple images in the WordPress Media Library. Saved image attachment IDs: '.esc_html($value).'</p><div id="lw-gallery-preview" class="lw-gallery-preview-admin">';
   foreach(lw_project_gallery_ids($post->ID) as $attachment_id) echo wp_get_attachment_image($attachment_id,'thumbnail');
   echo '</div>';
  } else echo '<input class="regular-text" type="'.esc_attr($type).'" '.($type==='number'?'min="0" step="1"':'').' id="'.esc_attr($key).'" name="'.esc_attr($key).'" value="'.esc_attr($value).'">';
  echo '</td></tr>';
 }
 echo '</tbody></table>';
}
function lw_project_gallery_ids($id) {
 $value=(string)get_post_meta($id,'_lw_gallery_ids',true);
 return array_values(array_filter(array_unique(array_map('absint',explode(',',$value))),function($id){return $id && wp_attachment_is_image($id);}));
}
add_action('admin_enqueue_scripts',function($hook){
 if (!in_array($hook,array('post.php','post-new.php'),true) || get_current_screen()->post_type!=='lw_project') return;
 wp_enqueue_media();
 wp_enqueue_script('lw-property-admin',LW_URI.'/assets/js/property-admin.js',array('jquery'),LW_VERSION,true);
 wp_enqueue_style('lw-property-admin',LW_URI.'/assets/css/property-admin.css',array(),LW_VERSION);
});
add_action('save_post_lw_project',function($id){
 if (!isset($_POST['lw_project_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lw_project_nonce'])),'lw_project_save')) return;
 if ((defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) || wp_is_post_revision($id) || !current_user_can('edit_post',$id)) return;
 foreach(lw_project_meta_fields() as $key=>$field) {
  $type=$field['type'] ?? 'text';
  $raw=isset($_POST[$key]) && is_scalar($_POST[$key]) ? (string)wp_unslash($_POST[$key]) : '';
  if ($type==='checkbox') $value=$raw==='1'?'1':'';
  elseif ($type==='number') $value=(string)max(0,(int)$raw);
  elseif ($type==='url') $value=esc_url_raw($raw);
  elseif ($type==='textarea') $value=sanitize_textarea_field($raw);
  elseif ($type==='gallery') $value=implode(',',array_values(array_filter(array_unique(array_map('absint',explode(',',$raw))),function($i){return $i && wp_attachment_is_image($i);}))); 
  elseif($type==='select') $value=array_key_exists($raw,$field['choices']) ? $raw : '';
  else $value=sanitize_text_field($raw);
  update_post_meta($id,$key,$value);
 }
});

function lw_property_filter($key) {
 return isset($_GET[$key]) && is_scalar($_GET[$key]) ? sanitize_text_field(wp_unslash($_GET[$key])) : '';
}
function lw_render_property_search($compact=false) {
 $type=lw_property_filter('lw_type');$city=lw_property_filter('lw_city');$listing=lw_property_filter('lw_listing');
 $min=lw_property_filter('lw_min_price');$max=lw_property_filter('lw_max_price');$s=lw_property_filter('s');
 $terms=get_terms(array('taxonomy'=>'lw_project_type','hide_empty'=>true));
 $cities=get_terms(array('taxonomy'=>'lw_city','hide_empty'=>true));
 echo '<form method="get" action="'.esc_url(get_post_type_archive_link('lw_project')).'" role="search" class="lw-property-search'.($compact?' lw-property-search-compact':'').'">';
 echo '<div class="lw-property-search-field"><label for="lw-p-search">Search Property</label><input id="lw-p-search" name="s" type="search" value="'.esc_attr($s).'" placeholder="Project, sector or keyword"></div>';
 echo '<input type="hidden" name="post_type" value="lw_project">';
 echo '<div class="lw-property-search-field"><label for="lw-p-type">Property Type</label><select id="lw-p-type" name="lw_type"><option value="">All Types</option>';
 if(!is_wp_error($terms)) foreach($terms as $term) echo '<option value="'.esc_attr($term->slug).'" '.selected($type,$term->slug,false).'>'.esc_html($term->name).'</option>';
 echo '</select></div>';
 echo '<div class="lw-property-search-field"><label for="lw-p-city">City / Locality</label><select id="lw-p-city" name="lw_city"><option value="">All Locations</option>';
 if(!is_wp_error($cities)) foreach($cities as $term) echo '<option value="'.esc_attr($term->slug).'" '.selected($city,$term->slug,false).'>'.esc_html($term->name).'</option>';
 echo '</select></div>';
 echo '<div class="lw-property-search-field"><label for="lw-p-listing">Listing</label><select id="lw-p-listing" name="lw_listing">';
 foreach(array(''=>'All Listings','new-launch'=>'New Launch','resale'=>'Resale','rental'=>'Rental') as $key=>$name) echo '<option value="'.esc_attr($key).'" '.selected($listing,$key,false).'>'.esc_html($name).'</option>';
 echo '</select></div>';
 if(!$compact) {
  echo '<div class="lw-property-search-field"><label for="lw-p-min">Min Budget (₹)</label><input id="lw-p-min" type="number" min="0" step="100000" name="lw_min_price" value="'.esc_attr($min).'" placeholder="Any"></div>';
  echo '<div class="lw-property-search-field"><label for="lw-p-max">Max Budget (₹)</label><input id="lw-p-max" type="number" min="0" step="100000" name="lw_max_price" value="'.esc_attr($max).'" placeholder="Any"></div>';
 }
 echo '<button class="lw-button lw-property-search-submit" type="submit">Find Properties ↗</button></form>';
}
add_shortcode('luxury_property_search',function($atts){$a=shortcode_atts(array('compact'=>'no'),$atts,'luxury_property_search');ob_start();lw_render_property_search($a['compact']==='yes');return ob_get_clean();});
add_shortcode('luxury_projects',function($atts){
 $a=shortcode_atts(array('count'=>6,'type'=>'','featured'=>'no'),$atts,'luxury_projects');
 $qargs=array('post_type'=>'lw_project','posts_per_page'=>max(1,min(24,(int)$a['count'])));
 if($a['type']) $qargs['tax_query']=array(array('taxonomy'=>'lw_project_type','field'=>'slug','terms'=>sanitize_title($a['type'])));
 if($a['featured']==='yes') $qargs['meta_query']=array(array('key'=>'_lw_featured','value'=>'1'));
 $q=new WP_Query($qargs);ob_start();echo '<div class="lw-project-grid">';while($q->have_posts()){$q->the_post();lw_project_card(get_the_ID());}echo '</div>';wp_reset_postdata();return ob_get_clean();
});

/** Filter the WordPress main query so searches and pagination remain server-side and shareable. */
add_action('pre_get_posts',function($query){
 if(is_admin() || !$query->is_main_query()) return;
 $post_type=$query->get('post_type');
 if(!$query->is_post_type_archive('lw_project') && !($query->is_search() && ($post_type==='lw_project' || lw_property_filter('post_type')==='lw_project'))) return;
 $query->set('post_type','lw_project');
 $query->set('posts_per_page',12);
 $tax=array('relation'=>'AND');
 if(($type=sanitize_title(lw_property_filter('lw_type')))!=='') $tax[]=array('taxonomy'=>'lw_project_type','field'=>'slug','terms'=>array($type));
 if(($city=sanitize_title(lw_property_filter('lw_city')))!=='') $tax[]=array('taxonomy'=>'lw_city','field'=>'slug','terms'=>array($city));
 if(count($tax)>1) $query->set('tax_query',$tax);
 $meta=array('relation'=>'AND');
 $listing=lw_property_filter('lw_listing');
 if(in_array($listing,array('new-launch','resale','rental'),true)) $meta[]=array('key'=>'_lw_listing_kind','value'=>$listing);
 $min=lw_property_filter('lw_min_price');$max=lw_property_filter('lw_max_price');
 if($min!==''&&is_numeric($min)) $meta[]=array('key'=>'_lw_price_amount','value'=>max(0,(float)$min),'type'=>'NUMERIC','compare'=>'>=');
 if($max!==''&&is_numeric($max)) $meta[]=array('key'=>'_lw_price_amount','value'=>max(0,(float)$max),'type'=>'NUMERIC','compare'=>'<=');
 if(count($meta)>1) $query->set('meta_query',$meta);
});
