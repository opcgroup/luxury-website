<?php
if (!defined('ABSPATH')) exit;
function lw_fonts() { return array(
 'editorial'=>array('label'=>'Editorial / Georgia','css'=>'Georgia, "Times New Roman", serif'),
 'modern'=>array('label'=>'Modern / Inter-style','css'=>'Inter, ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'),
 'classic'=>array('label'=>'Classic / Helvetica','css'=>'"Helvetica Neue", Helvetica, Arial, sans-serif'),
 'luxe'=>array('label'=>'Luxury / Palatino','css'=>'Palatino, "Palatino Linotype", "Book Antiqua", serif'),
);}
function lw_presets() { return array(
 'utopia'=>array('name'=>'Utopia · Editorial Luxury','desc'=>'Deep charcoal, champagne gold, cinematic hero and elegant cards','primary'=>'#171d20','accent'=>'#b99865','background'=>'#f7f5f0','surface'=>'#ffffff','ink'=>'#1a2427','muted'=>'#697475','header_bg'=>'#ffffff','header_color'=>'#1a2427','topbar_bg'=>'#171d20','font'=>'editorial','hero_style'=>'split','card_style'=>'lift','radius'=>12,'section_gap'=>94,'header_height'=>82,'buttons_round'=>0),
 'opc'=>array('name'=>'OPC · Premium Corporate','desc'=>'Navy, electric blue accents, project grids and conversion-first design','primary'=>'#142c4b','accent'=>'#d5aa55','background'=>'#f3f6fa','surface'=>'#ffffff','ink'=>'#1a2b40','muted'=>'#65768a','header_bg'=>'#ffffff','header_color'=>'#142c4b','topbar_bg'=>'#142c4b','font'=>'modern','hero_style'=>'full','card_style'=>'border','radius'=>16,'section_gap'=>82,'header_height'=>80,'buttons_round'=>1),
 'ecocity'=>array('name'=>'Ecocity · Green Estate','desc'=>'Forest green, organic earth accents, garden-style property cards','primary'=>'#183d32','accent'=>'#b99a5d','background'=>'#f3f7f1','surface'=>'#ffffff','ink'=>'#213d34','muted'=>'#6c8077','header_bg'=>'#ffffff','header_color'=>'#183d32','topbar_bg'=>'#183d32','font'=>'modern','hero_style'=>'split','card_style'=>'soft','radius'=>20,'section_gap'=>86,'header_height'=>84,'buttons_round'=>1),
);}
function lw_header_elements() {return array('logo','menu','phone','email','cta','whatsapp','tagline','social','search','spacer','toggle');}
function lw_defaults() {
 $p=lw_presets()['utopia']; return array_merge($p,array(
  'preset'=>'utopia','site_mode'=>'agency','container_width'=>1200,'logo_height'=>62,'header_padding'=>8,'header_gap'=>22,'menu_gap'=>26,'menu_font_size'=>13,'header_mobile_height'=>75,'header_shadow'=>1,'header_width_full'=>0,'topbar_bg'=>'#171d20','topbar_color'=>'#ffffff',
  'header_sticky'=>1,'header_transparent'=>0,'topbar_enable'=>1,'bottomrow_enable'=>0,
  'header_top_left'=>'tagline','header_top_center'=>'','header_top_right'=>'email,phone',
  'header_main_left'=>'logo','header_main_center'=>'menu','header_main_right'=>'cta',
  'header_bottom_left'=>'','header_bottom_center'=>'','header_bottom_right'=>'',
  'header_mobile_left'=>'logo','header_mobile_right'=>'phone,toggle',
  'tagline'=>'Luxury Real Estate · New Chandigarh',
  'phone'=>'','email'=>'','whatsapp'=>'','instagram'=>'','facebook'=>'','youtube'=>'',
  'cta_text'=>'Book a Site Visit','cta_url'=>'#contact',
  'hero_kicker'=>'WELCOME TO LUXURY LIVING','hero_title'=>'Elevated Living. Extraordinary Addresses.','hero_description'=>'Explore thoughtfully selected homes, exclusive residences and premium properties designed for a remarkable life.','hero_image'=>'','hero_overlay'=>55,
  'hero_button'=>'Explore Projects','hero_button_url'=>'#projects','hero_secondary'=>'Contact Our Team','hero_secondary_url'=>'#contact','hero_height'=>625,
  'home_search_kicker'=>'FIND A PROPERTY','stats_enable'=>1,'stat_1_number'=>'15+','stat_1_label'=>'Featured Projects','stat_2_number'=>'10+','stat_2_label'=>'Years of Experience','stat_3_number'=>'100%','stat_3_label'=>'Personal Assistance',
  'about_enable'=>1,'about_button_text'=>'Discover More','about_button_url'=>'#contact','about_image_badge_top'=>'DESIGNED','about_image_badge_bottom'=>'FOR LIVING.','about_kicker'=>'DISCOVER OUR WORLD','about_title'=>'Spaces curated for the way you live.','about_description'=>'From thoughtfully designed apartments to prestigious plots and villas, discover an experience shaped by beautiful architecture, convenient locations and personalized attention.','about_image'=>'',
  'projects_enable'=>1,'projects_kicker'=>'CURATED COLLECTION','projects_all_text'=>'View All Projects','projects_title'=>'Featured Properties','projects_description'=>'Handpicked projects and exceptional spaces.','projects_count'=>6,'filters_enable'=>1,
  'features_enable'=>1,'features_kicker'=>'THE DETAILS MATTER','features_title'=>'The Luxury Difference','feature_1_title'=>'Premium Locations','feature_1_body'=>'Properties in well-connected and desirable neighborhoods.','feature_2_title'=>'Thoughtful Design','feature_2_body'=>'Practical layouts, comfort and contemporary architecture.','feature_3_title'=>'Guided Experience','feature_3_body'=>'Personalized assistance at every step of the journey.',
  'gallery_enable'=>0,'gallery_kicker'=>'THE GALLERY','gallery_title'=>'A Closer Look','gallery_1'=>'','gallery_2'=>'','gallery_3'=>'',
  'location_enable'=>1,'location_kicker'=>'LOCATION & ACCESS','location_art_label'=>'LOCATION & CONNECTIVITY','location_map_label'=>'Open in Maps','location_image'=>'','location_title'=>'Where We Are','location_description'=>'Explore the neighborhood, access routes and location advantages of your next address.','location_map_url'=>'',
  'faq_enable'=>1,'faq_kicker'=>'GOOD TO KNOW','faq_title'=>'Frequently Asked Questions','faq_items'=>'','faq_1_question'=>'Can I arrange a site visit?','faq_1_answer'=>'Yes. Use the enquiry form or contact our team to request an appointment.','faq_2_question'=>'Can I request the latest price list?','faq_2_answer'=>'Contact our team for the latest available pricing and project details.','faq_3_question'=>'How do I confirm project approvals?','faq_3_answer'=>'Always verify RERA registration and official approvals from the appropriate authorities.','faq_4_question'=>'','faq_4_answer'=>'','faq_5_question'=>'','faq_5_answer'=>'','faq_6_question'=>'','faq_6_answer'=>'','cta_enable'=>1,'cta_kicker'=>'YOUR NEW BEGINNING','cta_button_text'=>"Let's Connect",'cta_button_url'=>'#contact','cta_section_title'=>'Your next chapter begins here.','cta_section_desc'=>'Connect with our team for project details, brochures and an appointment.',
  'blog_enable'=>1,'blog_kicker'=>'THE JOURNAL','blog_all_text'=>'Read All Articles','blog_title'=>'Insights & Updates','blog_count'=>3,
  'contact_enable'=>1,'contact_kicker'=>"LET'S TALK",'contact_title'=>'Start a Conversation','contact_desc'=>'Request a call back or schedule a personalized site visit.','contact_recipient'=>'',
  'footer_about'=>'Explore curated residential and commercial property with a personal approach.','footer_disclaimer'=>'All project details, pricing, availability and images are subject to change. Verify approvals and RERA information with official sources before buying.',
  'footer_copyright'=>'','rera_number'=>'','office_address'=>'',
  'animation'=>'reveal','animation_speed'=>650,'card_hover'=>'lift','buttons_round'=>0,
  'float_whatsapp'=>1,'float_contact'=>0,'scroll_top'=>1,'custom_css'=>'',
  'use_page_content'=>0,
  'github_repo'=>'',
  'archive_show_banner'=>1, 'archive_kicker'=>'', 'archive_title'=>'Explore Real Estate', 'archive_description'=>'Apartments, luxury floors, plots, villas and commercial projects — discover properties that match your requirements.',
  'archive_bg_color'=>'', 'archive_bg_image'=>'', 'archive_align'=>'left', 'archive_banner_padding'=>85,
  'archive_search_kicker'=>'FIND YOUR NEXT ADDRESS', 'archive_search_title'=>'Search Available Properties',
  'archive_show_search'=>1, 'archive_show_results_count'=>1,
  'seo_enabled'=>1,'seo_home_title'=>'','seo_home_description'=>'','seo_home_keywords'=>'','seo_home_og_image'=>'','seo_emit_keywords'=>0,'seo_projects_title'=>'','seo_projects_description'=>''
 ));
}
function lw_options() {
 $raw=get_option('lw_options',array()); if (!is_array($raw)) $raw=array();
 return array_merge(lw_defaults(),$raw);
}
function lw_opt($key,$default='') { $o=lw_options(); return isset($o[$key]) ? $o[$key] : $default; }
/** Read the expandable FAQ list. Existing websites keep their older FAQ entries until edited. */
function lw_faq_items() {
 $raw=get_option('lw_options',array());
 if(is_array($raw) && isset($raw['faq_items']) && is_string($raw['faq_items']) && $raw['faq_items']!=='') {
  $saved=json_decode($raw['faq_items'],true);
  if(is_array($saved)) return array_values(array_filter($saved,function($row){return is_array($row) && !empty($row['question']);}));
 }
 $o=lw_options();$items=array();
 for($i=1;$i<=6;$i++) {
  $q=trim((string)($o['faq_'.$i.'_question']??''));
  if($q!=='') $items[]=array('question'=>$q,'answer'=>(string)($o['faq_'.$i.'_answer']??''));
 }
 return $items;
}
/** WordPress settings and Customizer both store the same sanitized JSON list. */
function lw_clean_faq_json($value) {
 if(!is_string($value) || strlen($value)>500000) return null;
 $decoded=json_decode($value,true);
 if(!is_array($decoded) || ($decoded && array_keys($decoded)!==range(0,count($decoded)-1))) return null;
 $items=array();
 foreach($decoded as $entry) {
  if(count($items)>=250) break; // Practical safety boundary, not a two-question cap.
  if(!is_array($entry)) continue;
  $question=sanitize_text_field((string)($entry['question']??'')); $question=function_exists('mb_substr')?mb_substr($question,0,400):substr($question,0,400);
  $answer=sanitize_textarea_field((string)($entry['answer']??'')); $answer=function_exists('mb_substr')?mb_substr($answer,0,6000):substr($answer,0,6000);
  if($question!=='') $items[]=array('question'=>$question,'answer'=>$answer);
 }
 return wp_json_encode($items,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}
/** Visual editing area shared by the Studio and the WordPress Customizer. */
function lw_faq_repeater_markup($is_customizer=false) {
 $list=wp_json_encode(lw_faq_items(),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP|JSON_HEX_TAG);
 echo '<div class="lw-faq-repeater" data-context="'.($is_customizer?'customizer':'studio').'">';
 echo '<p class="description">Add FAQs as needed. Use Move Up / Down to change their order; removing a question also removes it from the homepage.</p>';
 echo '<div class="lw-faq-editor-list" aria-live="polite"></div>';
 echo '<button type="button" class="button button-secondary lw-faq-add">+ Add New FAQ</button>';
 echo '<input type="hidden" class="lw-faq-json" '.($is_customizer?'data-customize-setting-link="lw_options[faq_items]"':'name="lw_options[faq_items]"').' value="'.esc_attr($list).'">';
 echo '<p class="description">In Appearance → Customize, FAQs preview as you type. Click Publish to save. Changes in the Studio require Save Website Settings.</p></div>';
}

function lw_sanitize_options($input) {
 $old=lw_options(); if (!is_array($input)) return $old;
 $allowed=lw_defaults();
 $hex=array('primary','accent','background','surface','ink','muted','header_bg','header_color','topbar_bg','topbar_color','archive_bg_color');
 $urls=array('cta_url','hero_button_url','hero_secondary_url','instagram','facebook','youtube','location_map_url','about_button_url','cta_button_url');
 $emails=array('email','contact_recipient');
 $numbers=array('container_width'=>array(780,1700),'radius'=>array(0,40),'section_gap'=>array(38,150),'header_height'=>array(50,150),'header_padding'=>array(0,45),'logo_height'=>array(25,140),'header_gap'=>array(0,55),'menu_gap'=>array(0,55),'menu_font_size'=>array(9,20),'header_mobile_height'=>array(56,110),'hero_height'=>array(380,970),'hero_overlay'=>array(0,95),'projects_count'=>array(1,24),'blog_count'=>array(1,12),'animation_speed'=>array(200,1800),'archive_banner_padding'=>array(32,190));
 $bools=array('header_sticky','header_transparent','header_shadow','header_width_full','topbar_enable','bottomrow_enable','stats_enable','about_enable','projects_enable','filters_enable','features_enable','gallery_enable','location_enable','faq_enable','cta_enable','blog_enable','contact_enable','buttons_round','float_whatsapp','float_contact','scroll_top','use_page_content','seo_enabled','seo_emit_keywords','archive_show_banner','archive_show_search','archive_show_results_count');
 $fields=array('preset'=>array_keys(lw_presets()),'site_mode'=>array('agency','single'),'hero_style'=>array('split','full','minimal'),'card_style'=>array('lift','border','soft'),'font'=>array_keys(lw_fonts()),'animation'=>array('none','reveal','fade','slide'),'card_hover'=>array('none','lift','zoom','glow'),'archive_align'=>array('left','center'));
 $new=$old;
 foreach ($allowed as $key=>$fallback) {
  if (!array_key_exists($key,$input)) continue;
  $value=$input[$key]; if (!is_scalar($value)) continue;
  if (isset($fields[$key])) $new[$key]=in_array($value,$fields[$key],true)?$value:$old[$key];
  elseif (in_array($key,$hex,true)) $new[$key]=sanitize_hex_color($value)?:$old[$key];
  elseif (in_array($key,$urls,true)) $new[$key]=esc_url_raw($value);
  elseif (in_array($key,$emails,true)) $new[$key]=sanitize_email($value);
  elseif (isset($numbers[$key])) $new[$key]=max($numbers[$key][0],min($numbers[$key][1],absint($value)));
  elseif (in_array($key,$bools,true)) $new[$key]=empty($value)?0:1;
  elseif (strpos($key,'header_top_')===0 || strpos($key,'header_main_')===0 || strpos($key,'header_bottom_')===0 || strpos($key,'header_mobile_')===0) {
    $parts=array_filter(array_map('trim',explode(',',strtolower((string)$value))));
    $new[$key]=implode(',',array_slice(array_unique(array_intersect($parts,lw_header_elements())),0,12));
  }
  elseif ($key==='hero_image'||$key==='about_image'||in_array($key,array('gallery_1','gallery_2','gallery_3','location_image'),true)) $new[$key]=esc_url_raw($value);
  elseif ($key==='faq_items') {
    $clean=lw_clean_faq_json((string)$value);
    if($clean!==null) $new[$key]=$clean;
  }
  elseif ($key==='github_repo') {
    $v=trim((string)$value);$new[$key]=($v==='' || preg_match('/\A[a-zA-Z0-9_.-]+\/[a-zA-Z0-9_.-]+\z/D',$v))?$v:$old[$key];
  }
  elseif ($key==='seo_home_og_image'||$key==='archive_bg_image') $new[$key]=esc_url_raw($value);
  elseif ($key==='custom_css') $new[$key]=wp_strip_all_tags($value);
  else $new[$key]=sanitize_textarea_field($value);
 }
 return $new;
}
add_action('admin_init',function(){register_setting('lw_settings','lw_options',array('type'=>'array','sanitize_callback'=>'lw_sanitize_options','default'=>lw_defaults()));});
// One-time, lossless conversion of old numbered questions to the expandable list.
add_action('admin_init',function(){
 $raw=get_option('lw_options',array()); if(!is_array($raw) || (isset($raw['faq_items']) && $raw['faq_items']!=='')) return;
 $raw['faq_items']=wp_json_encode(lw_faq_items(),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
 update_option('lw_options',$raw);
},20);
add_action('admin_menu',function(){add_theme_page('Luxury Website Studio','Luxury Website','edit_theme_options','lw-studio','lw_admin_page');});
add_action('admin_enqueue_scripts',function($hook){
 if ($hook!=='appearance_page_lw-studio') return;
 wp_enqueue_media();wp_enqueue_style('lw-admin',LW_URI.'/assets/css/admin.css',array(),LW_VERSION);wp_enqueue_script('lw-admin',LW_URI.'/assets/js/admin.js',array(),LW_VERSION,true);wp_enqueue_script('lw-faq-editor',LW_URI.'/assets/js/faq-editor.js',array(),LW_VERSION,true);wp_enqueue_style('lw-faq-editor',LW_URI.'/assets/css/faq-editor.css',array(),LW_VERSION);
});
function lw_option_input($id,$label,$type='text',$help='') {
 $o=lw_options();$value=$o[$id]??'';
 echo '<label class="lw-field"><span class="lw-field-label">'.esc_html($label).'</span>';
 if($type==='textarea') echo '<textarea name="lw_options['.esc_attr($id).']" rows="3">'.esc_textarea($value).'</textarea>';
 elseif($type==='color') echo '<input type="color" name="lw_options['.esc_attr($id).']" value="'.esc_attr($value).'">';
 elseif($type==='image') echo '<span class="lw-image-row"><input class="lw-media-url" type="url" name="lw_options['.esc_attr($id).']" value="'.esc_attr($value).'" placeholder="Image URL or choose media"><button class="button lw-media-select" type="button">Choose Media</button></span>';
 elseif($type==='checkbox') echo '<input type="hidden" name="lw_options['.esc_attr($id).']" value="0"><input type="checkbox" name="lw_options['.esc_attr($id).']" value="1" '.checked((bool)$value,true,false).'>';
 elseif($type==='number') echo '<input type="number" name="lw_options['.esc_attr($id).']" value="'.esc_attr($value).'">';
 else echo '<input type="'.($type==='email'?'email':($type==='url'?'url':'text')).'" name="lw_options['.esc_attr($id).']" value="'.esc_attr($value).'">';
 if($help) echo '<small>'.esc_html($help).'</small>';echo '</label>';
}
function lw_option_select($id,$label,$choices) { $o=lw_options(); echo '<label class="lw-field"><span class="lw-field-label">'.esc_html($label).'</span><select name="lw_options['.esc_attr($id).']">';foreach($choices as $key=>$title) echo '<option value="'.esc_attr($key).'" '.selected($o[$id],$key,false).'>'.esc_html($title).'</option>';echo '</select></label>';}
function lw_field_group($title,$fields) {echo '<h3>'.esc_html($title).'</h3><div class="lw-field-grid">';foreach($fields as $f){lw_option_input($f[0],$f[1],$f[2]??'text',$f[3]??'');}echo '</div>';}
function lw_header_zone_editor($id,$label) {
 $o=lw_options();$items=array_filter(explode(',',$o[$id]));
 echo '<div class="lw-header-builder-zone"><div class="lw-builder-zone-label">'.esc_html($label).'</div><div class="lw-dropzone" data-zone="'.esc_attr($id).'">';
 foreach($items as $item) if(in_array($item,lw_header_elements(),true)) echo '<div class="lw-chip" draggable="true" data-name="'.esc_attr($item).'">'.esc_html(ucfirst($item)).'<button type="button" class="lw-chip-remove" aria-label="Remove">×</button></div>';
 echo '</div><select class="lw-add-item"><option value="">+ Add element</option>';
 foreach(lw_header_elements() as $item) echo '<option value="'.esc_attr($item).'">'.esc_html(ucfirst($item)).'</option>';
 echo '</select><input type="hidden" name="lw_options['.esc_attr($id).']" value="'.esc_attr($o[$id]).'"></div>';
}
function lw_admin_page() {
 if(!current_user_can('edit_theme_options')) return;
 $o=lw_options();$presets=lw_presets();
 echo '<div class="wrap lw-studio"><div class="lw-admin-header"><div><h1>Luxury Website <span>Studio</span></h1><p>One-click presets · Visual page builder · Animations · SEO · GitHub Releases</p></div><a href="'.esc_url(home_url('/')).'" target="_blank" class="button">Open Website ↗</a></div>';
 if(isset($_GET['lw_status'])&&$_GET['lw_status']==='preset') echo '<div class="notice notice-success is-dismissible"><p>Design preset applied. Website colours, typography, hero layout and cards are updated.</p></div>';
 echo '<section class="lw-preset-section"><h2>01. One-click Website Design</h2><p>Presets change the complete theme design system without deleting pages, posts, images or menus.</p><div class="lw-presets">';
 foreach($presets as $slug=>$p){echo '<div class="lw-preset-card '.($o['preset']===$slug?'is-active':'').'"><div class="lw-preset-art lw-preset-art-'.esc_attr($slug).'"><span class="lw-art-nav"></span><span class="lw-art-title"></span><span class="lw-art-subtitle"></span><span class="lw-art-button"></span><span class="lw-art-card"></span><span class="lw-art-card two"></span></div><h3>'.esc_html($p['name']).'</h3><p>'.esc_html($p['desc']).'</p><form action="'.esc_url(admin_url('admin-post.php')).'" method="post"><input type="hidden" name="action" value="lw_apply_preset"><input type="hidden" name="preset" value="'.esc_attr($slug).'">';wp_nonce_field('lw_apply_preset');echo '<button class="button '.($o['preset']===$slug?'button-secondary':'button-primary').'" type="submit">'.($o['preset']===$slug?'Reapply Preset':'Apply This Design →').'</button></form></div>';}
 echo '</div></section>';
 echo '<form action="options.php" method="post" class="lw-settings-form">';settings_fields('lw_settings');
 echo '<div class="lw-tabs" role="tablist"><button type="button" class="is-active" data-tab="header">Header Builder</button><button type="button" data-tab="design">Design & Motion</button><button type="button" data-tab="home">Homepage</button><button type="button" data-tab="archive">Projects Listing</button><button type="button" data-tab="contact">Contact & Footer</button><button type="button" data-tab="seo">SEO Settings</button><button type="button" data-tab="updates">GitHub Updates</button></div>';
 echo '<section class="lw-panel is-active" data-panel="header"><h2>02. Custom Header Builder</h2><p>Add, remove or drag components between header zones. Each row supports Left, Center and Right positions. Mobile header has its own builder.</p>';
 lw_field_group('Header Controls',array(array('topbar_enable','Show Top Bar','checkbox'),array('bottomrow_enable','Show Bottom Row','checkbox'),array('header_sticky','Sticky Header','checkbox'),array('header_transparent','Transparent Over Hero','checkbox'),array('header_height','Header Height (px)','number'),array('header_padding','Row Vertical Padding (px)','number'),array('logo_height','Logo Height (px)','number'),array('header_gap','Element Gap (px)','number'),array('menu_gap','Menu Item Gap (px)','number'),array('menu_font_size','Menu Font Size (px)','number'),array('header_mobile_height','Mobile Header Height (px)','number'),array('header_shadow','Header Shadow','checkbox'),array('header_width_full','Full-Width Header','checkbox')));
 echo '<div class="lw-field-grid">';lw_option_input('topbar_bg','Top Bar Background','color');lw_option_input('topbar_color','Top Bar Text','color');echo '</div>';
 echo '<div class="lw-builder-wrap">';foreach(array('top'=>'Top Bar','main'=>'Main Header','bottom'=>'Bottom Row') as $r=>$name) {echo '<h3>'.esc_html($name).'</h3><div class="lw-builder-row">';foreach(array('left','center','right') as $s) lw_header_zone_editor('header_'.$r.'_'.$s,ucfirst($s));echo '</div>';}echo '<h3>Mobile Header (≤ 980px)</h3><div class="lw-builder-row lw-builder-mobile">';foreach(array('left','right') as $s) lw_header_zone_editor('header_mobile_'.$s,ucfirst($s));echo '</div></div>';
 lw_field_group('Header Content',array(array('tagline','Top Bar / Tagline'),array('phone','Contact Number'),array('email','Contact Email','email'),array('cta_text','Header Button Text'),array('cta_url','Header Button URL')));
 echo '</section>';
 echo '<section class="lw-panel" data-panel="design"><h2>03. Appearance & Motion</h2><p>Change any colour or component style. Save to apply site-wide.</p><div class="lw-field-grid">';
 foreach(array('primary'=>'Primary / dark','accent'=>'Accent / buttons','background'=>'Background','surface'=>'Card Surface','ink'=>'Text Colour','muted'=>'Muted Text','header_bg'=>'Header Background','header_color'=>'Header Text') as $key=>$label) lw_option_input($key,$label,'color');
 echo '</div><div class="lw-field-grid">';
 lw_option_select('font','Font Style',array_map(function($v){return $v['label'];},lw_fonts()));
 lw_option_select('hero_style','Hero Layout',array('split'=>'Editorial Split','full'=>'Full-Width Cinematic','minimal'=>'Minimal Centered'));
 lw_option_select('card_style','Property Card Style',array('lift'=>'Editorial / Lifted','border'=>'Corporate / Border','soft'=>'Nature / Soft'));
 lw_option_select('card_hover','Card Hover Effect',array('none'=>'None','lift'=>'Lift','zoom'=>'Zoom Image','glow'=>'Accent Glow'));
 lw_option_select('animation','Entrance Animation',array('none'=>'None','reveal'=>'Rise & Reveal','fade'=>'Fade In','slide'=>'Slide In'));
 lw_option_input('animation_speed','Animation Speed (milliseconds)','number');
 lw_option_input('container_width','Content Width (px)','number');lw_option_input('radius','Card Radius (px)','number');lw_option_input('section_gap','Section Spacing (px)','number');lw_option_input('buttons_round','Pill-Shaped Buttons','checkbox');
 echo '</div>';lw_option_input('custom_css','Advanced Custom CSS','textarea','CSS-only, for additional styling. Keep custom CSS in a child theme for easier long-term maintenance.');echo '</section>';
 echo '<section class="lw-panel" data-panel="home"><h2>04. Homepage Sections</h2><p><strong>Every homepage text can be edited below.</strong> For live previews open Appearance → Customize → Luxury Website — Design Studio, then choose a Homepage section. The existing homepage layout and saved settings are preserved.</p><div class="lw-field-grid">';
 lw_option_select('site_mode','Website Type',array('agency'=>'Agency / Multi-Project','single'=>'Single Project / Landing Page'));
 lw_option_input('use_page_content','Use WordPress Page Content as Homepage','checkbox','Enable when using Elementor or a custom homepage designed in Gutenberg.');
 lw_option_input('hero_kicker','Hero Eyebrow');lw_option_input('hero_title','Hero Headline');lw_option_input('hero_description','Hero Description','textarea');
 lw_option_input('hero_image','Hero Background Photo','image');lw_option_input('hero_overlay','Hero Dark Overlay 0–95','number');lw_option_input('hero_height','Hero Height (px)','number');
 lw_option_input('hero_button','Primary Button');lw_option_input('hero_button_url','Primary Button URL');lw_option_input('hero_secondary','Secondary Button');lw_option_input('hero_secondary_url','Secondary Button URL');
 echo '</div>';
 lw_field_group('Statistics',array(array('home_search_kicker','Property Search Small Label'),array('stats_enable','Enable Statistics','checkbox'),array('stat_1_number','Statistic 1 Number'),array('stat_1_label','Statistic 1 Label'),array('stat_2_number','Statistic 2 Number'),array('stat_2_label','Statistic 2 Label'),array('stat_3_number','Statistic 3 Number'),array('stat_3_label','Statistic 3 Label')));
 lw_field_group('About Section',array(array('about_enable','Enable About','checkbox'),array('about_kicker','About Eyebrow'),array('about_title','About Title'),array('about_description','About Description','textarea'),array('about_image','About Image','image'),array('about_button_text','About Link Label'),array('about_button_url','About Link URL','url'),array('about_image_badge_top','Image Badge Top'),array('about_image_badge_bottom','Image Badge Bottom')));
 lw_field_group('Projects & Features',array(array('projects_enable','Enable Featured Projects','checkbox'),array('projects_title','Projects Section Title'),array('projects_description','Projects Description','textarea'),array('projects_kicker','Projects Small Label'),array('projects_all_text','View All Projects Text'),array('projects_count','Number of Projects','number'),array('filters_enable','Show Project Filters','checkbox'),array('features_enable','Enable Features','checkbox'),array('features_title','Features Heading'),array('features_kicker','Feature Small Label'),array('feature_1_title','Feature 1'),array('feature_1_body','Feature 1 Body','textarea'),array('feature_2_title','Feature 2'),array('feature_2_body','Feature 2 Body','textarea'),array('feature_3_title','Feature 3'),array('feature_3_body','Feature 3 Body','textarea')));
 lw_field_group('Gallery, Location & FAQs',array(array('gallery_enable','Enable Image Gallery','checkbox'),array('gallery_title','Gallery Title'),array('gallery_kicker','Gallery Small Label'),array('gallery_1','Gallery Image 1','image'),array('gallery_2','Gallery Image 2','image'),array('gallery_3','Gallery Image 3','image'),array('location_enable','Enable Location Section','checkbox'),array('location_title','Location Title'),array('location_kicker','Location Small Label'),array('location_image','Location Image','image'),array('location_art_label','Map Placeholder Label'),array('location_map_label','Maps Link Text'),array('location_description','Location Description','textarea'),array('location_map_url','Google Maps URL','url'),array('faq_enable','Enable FAQ Section','checkbox'),array('faq_title','FAQ Section Title'),array('faq_kicker','FAQ Small Label'),));
 echo '<h3>FAQ Questions & Answers</h3>'; lw_faq_repeater_markup(false);
 lw_field_group('Call to Action & Blog',array(array('cta_enable','Enable CTA Section','checkbox'),array('cta_section_title','CTA Heading'),array('cta_kicker','CTA Small Label'),array('cta_button_text','CTA Button Text'),array('cta_button_url','CTA Button Link','url'),array('cta_section_desc','CTA Description','textarea'),array('blog_enable','Enable Latest Articles','checkbox'),array('blog_title','Blog Heading'),array('blog_kicker','Articles Small Label'),array('blog_all_text','All Articles Link Label'),array('blog_count','Number of Articles','number')));
 echo '</section>';
 echo '<section class="lw-panel" data-panel="contact"><h2>05. Contact, Social & Footer</h2>';
 lw_field_group('Contact Details',array(array('contact_enable','Enable Contact Form','checkbox'),array('contact_title','Contact Section Title'),array('contact_kicker','Contact Small Label'),array('contact_desc','Contact Intro','textarea'),array('contact_recipient','Enquiries Sent To (email)','email','Leave empty to use WordPress Settings > General > Administration Email Address'),array('phone','Phone Number'),array('whatsapp','WhatsApp With Country Code'),array('email','Public Email','email'),array('office_address','Office Address','textarea'),array('rera_number','RERA / Registration Number')));
 lw_field_group('Social & Footer',array(array('instagram','Instagram Profile','url'),array('facebook','Facebook Profile','url'),array('youtube','YouTube Channel','url'),array('footer_about','Footer Intro','textarea'),array('footer_disclaimer','Legal Disclaimer','textarea'),array('footer_copyright','Copyright Override (optional)'),array('float_whatsapp','Floating WhatsApp','checkbox'),array('float_contact','Floating Contact Button','checkbox'),array('scroll_top','Back To Top Button','checkbox')));
 echo '</section>';
 echo '<section class="lw-panel" data-panel="archive"><h2>Projects / Property Listing Page</h2><p>Customize the <code>/projects/</code> archive. This section controls the listing banner, headline, search section and backdrop; it does not change your homepage or the individual property details pages.</p>';
 lw_field_group('Main Listing Banner',array(
  array('archive_show_banner','Show Project Banner','checkbox'),
  array('archive_kicker','Small Text Above Banner Title','text','Leave blank to show the website name.'),
  array('archive_title','Banner Heading / H1'),
  array('archive_description','Banner Description','textarea'),
  array('archive_bg_color','Custom Banner Background (hex)','text','Optional; leave blank to use your theme preset colour.'),
  array('archive_bg_image','Banner Background Image','image','Optional photo; an overlay keeps the text legible.'),
  array('archive_banner_padding','Banner Top/Bottom Spacing (px)','number')
 ));
 echo '<div class="lw-field-grid">'; lw_option_select('archive_align','Banner Text Alignment',array('left'=>'Left','center'=>'Centered')); echo '</div>';
 lw_field_group('Search & Directory',array(
  array('archive_search_kicker','Small Heading Above Search'),
  array('archive_search_title','Search Section Main Heading'),
  array('archive_show_search','Show Property Search Filters','checkbox'),
  array('archive_show_results_count','Show Number of Results','checkbox')
 ));
 echo '<p><strong>SEO:</strong> Set the Projects Archive SEO Title and Meta Description separately under SEO Settings. The banner heading is the visible H1 and does not overwrite the Google title.</p>';
 echo '</section>';
 echo '<section class="lw-panel" data-panel="seo"><h2>06. SEO & Search Preview</h2><p>Search optimisation settings for homepage. For each Page / Post / Project use the <strong>Luxury SEO</strong> sidebar in the Gutenberg editor or the SEO box below the classic editor.</p>';
 lw_field_group('Built-in SEO',array(array('seo_enabled','Enable Built-in SEO (disable when using a specialist SEO plugin)','checkbox'),array('seo_home_title','Homepage SEO Title'),array('seo_home_description','Homepage Meta Description','textarea'),array('seo_home_keywords','Homepage Related Keywords (internal list)'),array('seo_home_og_image','Homepage Social Share Image','image'),array('seo_emit_keywords','Emit legacy meta keywords tag (NOT used by Google)','checkbox'),array('seo_projects_title','Projects Archive SEO Title'),array('seo_projects_description','Projects Archive Description','textarea')));
 echo '<p><strong>Includes:</strong> canonical, noindex, social sharing metadata, Google search preview, focus keyword checklist and basic JSON-LD. WordPress core provides the XML sitemap at <code>/wp-sitemap.xml</code>. Specialist SEO plugins take precedence to prevent duplicate output.</p></section>';
 echo '<section class="lw-panel" data-panel="updates"><h2>07. GitHub Live Theme Updates</h2><p>Connect a <strong>public GitHub repository</strong>. Each published GitHub Release will be checked by WordPress; install the update from Dashboard → Updates. No tokens or API secrets are needed for public Releases.</p>';
 lw_field_group('Public GitHub Releases',array(array('github_repo','GitHub Owner/Repository (example: yourname/luxury-website)','text','Enter exactly OWNER/REPO, with no https:// prefix. Use a public repository.')));
 echo '<p><strong>Required release asset:</strong> attach <code>luxury-website-v1.2.0.zip</code> or <code>luxury-website.zip</code> to the GitHub Release tagged <code>v1.2.0</code>. Inside the ZIP, the one top-level folder must be named <code>luxury-website</code>.</p><p><strong>Update behaviour:</strong> WordPress checks for a newer Release (roughly every 12 hours). You can trigger a manual check in Dashboard → Updates. You can then enable WordPress auto-updates for this theme, after taking backups.</p><p>Only ZIPs published in your configured repository will be offered. This does not upload, create or publish releases automatically.</p></section>';
 echo '<div class="lw-save-bar"><button class="button button-primary button-hero" type="submit">Save Website Settings</button><span>Settings are shared across the entire active Luxury Website theme.</span></div></form>';
 echo '<div class="lw-help"><h3>How to get started</h3><p>1. Choose a design preset. 2. Upload your logo in Appearance → Customize → Site Identity. 3. Set Primary Menu in Appearance → Menus. 4. Add projects from Projects → Add New. 5. Upload hero photographs and save. 6. Set your contact number and enquiry email.</p><p><strong>Important:</strong> Presets change Luxury Website templates and styling. Existing Elementor pages with individually specified colours/layouts keep their own designer settings. To enable live updates, set a public GitHub repository in the GitHub Updates tab, and publish ZIP assets in Releases. Built-in SEO yields to major specialist plugins.</p></div></div>';
}
add_action('admin_post_lw_apply_preset',function(){
 if(!current_user_can('edit_theme_options')) wp_die('Permission denied.');
 check_admin_referer('lw_apply_preset');
 $key=isset($_POST['preset'])?sanitize_key(wp_unslash($_POST['preset'])):'';
 $presets=lw_presets();if(!isset($presets[$key])) wp_die('Invalid preset.');
 $o=lw_options();$p=$presets[$key];unset($p['name'],$p['desc']);
 $updated=array_merge($o,$p,array('preset'=>$key));update_option('lw_options',lw_sanitize_options($updated));
 wp_safe_redirect(add_query_arg(array('page'=>'lw-studio','lw_status'=>'preset'),admin_url('themes.php')));exit;
});
