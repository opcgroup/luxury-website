<?php
if(!defined('ABSPATH')) exit;
add_action('customize_register',function($wp_customize){
 $wp_customize->add_panel('lw_panel',array('title'=>'Luxury Website — Design Studio','priority'=>30,'description'=>'Control the theme appearance. For the drag-and-drop header builder, open Appearance → Luxury Website.'));
 $groups=array(
  'lw_identity'=>array('title'=>'Global Colours & Fonts','priority'=>10),
  'lw_header'=>array('title'=>'Header & Navigation','priority'=>20),
  'lw_hero'=>array('title'=>'Hero & Buttons','priority'=>30),
  'lw_sections'=>array('title'=>'Homepage – Show / Hide Sections','priority'=>40),
  'lw_home_stats'=>array('title'=>'Homepage – Property Search & Stats','priority'=>41),
  'lw_home_about'=>array('title'=>'Homepage – About','priority'=>42),
  'lw_home_projects'=>array('title'=>'Homepage – Projects & Cards','priority'=>43),
  'lw_home_features'=>array('title'=>'Homepage – Feature Cards','priority'=>44),
  'lw_home_categories'=>array('title'=>'Homepage – Property Category Cards','priority'=>45),
  'lw_home_locations_cards'=>array('title'=>'Homepage – Location Cards','priority'=>46),
  'lw_home_gallery'=>array('title'=>'Homepage – Image Gallery','priority'=>46),
  'lw_home_location'=>array('title'=>'Homepage – Location & Map','priority'=>47),
  'lw_home_faq'=>array('title'=>'Homepage – FAQ Questions & Answers','priority'=>48),
  'lw_home_cta'=>array('title'=>'Homepage – Call to Action','priority'=>49),
  'lw_home_blog'=>array('title'=>'Homepage – Articles','priority'=>51),
  'lw_home_contact'=>array('title'=>'Homepage – Contact Form Intro','priority'=>52),
  'lw_archive'=>array('title'=>'Projects Listing Page','priority'=>45),
  'lw_motion'=>array('title'=>'Cards & Animations','priority'=>50),
  'lw_footer'=>array('title'=>'Contact & Footer','priority'=>60),
 );
 foreach($groups as $id=>$val) $wp_customize->add_section($id,array_merge($val,array('panel'=>'lw_panel')));
 // Text, colors and spacing have instant iframe previews; structural settings use core refresh.
 $live_fields=array(
  'primary','accent','background','surface','ink','muted','header_bg','header_color','topbar_bg','topbar_color','font',
  'container_width','radius','header_padding','header_height','logo_height','header_gap','menu_gap','menu_font_size','header_mobile_height','hero_height','hero_overlay','section_gap',
  'phone','email','tagline','cta_text','cta_url','hero_kicker','hero_title','hero_description','hero_button','hero_button_url','hero_secondary','hero_secondary_url','hero_image',
  'home_search_kicker','about_kicker','about_title','about_description','about_button_text','about_button_url','about_image_badge_top','about_image_badge_bottom',
  'projects_kicker','projects_title','projects_description','projects_all_text','features_kicker','features_title',
  'gallery_kicker','gallery_title','location_kicker','location_title','location_description','location_art_label','location_map_label','location_map_url',
  'faq_kicker','faq_title','cta_kicker','cta_section_title','cta_section_desc','cta_button_text','cta_button_url',
  'blog_kicker','blog_title','blog_all_text','contact_kicker','contact_title','contact_desc',
  'footer_about','footer_disclaimer','office_address','archive_title','archive_kicker','archive_description','archive_search_kicker','archive_search_title','archive_bg_color','archive_banner_padding','archive_align'
 );
 for($i=1;$i<=3;$i++) {
  $live_fields[]= 'stat_'.$i.'_number';$live_fields[]= 'stat_'.$i.'_label';
  $live_fields[]= 'feature_'.$i.'_title';$live_fields[]= 'feature_'.$i.'_body';
 }
 $add=function($section,$id,$label,$type='text',$choices=array()) use($wp_customize,$live_fields){
  $default=lw_defaults();$sid='lw_options['.$id.']';
  $wp_customize->add_setting($sid,array('type'=>'option','default'=>$default[$id]??'','capability'=>'edit_theme_options','transport'=>in_array($id,$live_fields,true)?'postMessage':'refresh','sanitize_callback'=>function($v)use($id){$arr=lw_sanitize_options(array($id=>$v));return $arr[$id];}));
  $args=array('label'=>$label,'section'=>$section,'settings'=>$sid,'type'=>$type,'priority'=>10);
  if($choices) $args['choices']=$choices;
  if($type==='color') $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$sid,$args));
  elseif($type==='image') $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,$sid,$args));
  else $wp_customize->add_control($sid,$args);
 };
 foreach(array('primary'=>'Primary','accent'=>'Accent','background'=>'Page Background','surface'=>'Card Background','ink'=>'Text','muted'=>'Muted Text','header_bg'=>'Header Background','header_color'=>'Header Text','topbar_bg'=>'Top Bar Background','topbar_color'=>'Top Bar Text') as $id=>$name) $add('lw_identity',$id,$name,'color');
 $add('lw_identity','font','Typography','select',array_map(function($v){return $v['label'];},lw_fonts()));
 $add('lw_identity','container_width','Max Content Width (px)','number');$add('lw_identity','radius','Card Corners (px)','number');
 foreach(array('header_sticky'=>'Sticky Header','header_transparent'=>'Transparent Header','header_shadow'=>'Header Shadow','header_width_full'=>'Full Width Header','topbar_enable'=>'Top Information Bar','bottomrow_enable'=>'Extra Bottom Header Row','buttons_round'=>'Rounded Buttons') as $id=>$label) $add('lw_header',$id,$label,'checkbox');
 foreach(array('logo_height'=>'Logo Height (px)','header_height'=>'Header Height (px)','header_padding'=>'Header Padding (px)','header_gap'=>'Header Element Gap (px)','menu_gap'=>'Menu Gap (px)','menu_font_size'=>'Menu Text Size (px)','header_mobile_height'=>'Mobile Height (px)') as $id=>$label) $add('lw_header',$id,$label,'number');
 $add('lw_header','phone','Phone Number');$add('lw_header','tagline','Header Tagline');$add('lw_header','cta_text','Button Text');$add('lw_header','cta_url','Button URL','url');
 foreach(array('hero_kicker'=>'Small Intro','hero_title'=>'Main Headline','hero_description'=>'Description','hero_button'=>'Main Button','hero_button_url'=>'Main Button Link','hero_secondary'=>'Second Button','hero_secondary_url'=>'Second Button Link') as $id=>$label) $add('lw_hero',$id,$label,($id==='hero_description'?'textarea':'text'));
 $add('lw_hero','hero_image','Hero Image','image');$add('lw_hero','hero_style','Hero Design','select',array('split'=>'Split','full'=>'Full Bleed','minimal'=>'Minimal'));
 $add('lw_hero','hero_overlay','Hero Photo Overlay %','number');$add('lw_hero','hero_height','Hero Minimum Height (px)','number');
 foreach(array('stats_enable'=>'Show Stats','categories_cards_enable'=>'Show Category Cards','locations_cards_enable'=>'Show Location Cards','about_enable'=>'Show About','projects_enable'=>'Show Projects','filters_enable'=>'Project Filters','features_enable'=>'Show Features','gallery_enable'=>'Show Image Gallery','location_enable'=>'Show Location','faq_enable'=>'Show FAQ','cta_enable'=>'Show CTA','blog_enable'=>'Show Articles','contact_enable'=>'Show Enquiry Form','use_page_content'=>'Use Custom Homepage Content') as $id=>$label) $add('lw_sections',$id,$label,'checkbox');
 // Homepage labels, fields and images are all editable in the live Customizer.
 $add('lw_home_stats','home_search_kicker','Search Form Eyebrow');
 for($i=1;$i<=3;$i++) { $add('lw_home_stats','stat_'.$i.'_number','Statistic '.$i.' Number');$add('lw_home_stats','stat_'.$i.'_label','Statistic '.$i.' Label'); }
 foreach(array('about_kicker'=>'Small Label','about_title'=>'Heading','about_description'=>'Description','about_button_text'=>'Button Text','about_button_url'=>'Button Link','about_image_badge_top'=>'Image Badge Top','about_image_badge_bottom'=>'Image Badge Bottom') as $id=>$label) $add('lw_home_about',$id,$label,$id==='about_description'?'textarea':'text');
 $add('lw_home_about','about_image','About Image','image');
 foreach(array('projects_kicker'=>'Small Label','projects_title'=>'Projects Heading','projects_description'=>'Description','projects_all_text'=>'View All Link Text') as $id=>$label) $add('lw_home_projects',$id,$label,$id==='projects_description'?'textarea':'text');
 $add('lw_home_projects','projects_count','Number of Projects','number');
 foreach(array('features_kicker'=>'Small Label','features_title'=>'Features Heading') as $id=>$label) $add('lw_home_features',$id,$label);
 for($i=1;$i<=3;$i++) { $add('lw_home_features','feature_'.$i.'_title','Feature Card '.$i.' Title');$add('lw_home_features','feature_'.$i.'_body','Feature Card '.$i.' Description','textarea'); }
 foreach(array('categories_cards_enable'=>'Enable Category Cards','categories_cards_kicker'=>'Small Label','categories_cards_heading'=>'Section Title','categories_cards_description'=>'Section Intro') as $id=>$label) $add('lw_home_categories',$id,$label,$id==='categories_cards_enable'?'checkbox':($id==='categories_cards_description'?'textarea':'text'));
 foreach(array('locations_cards_enable'=>'Enable Location Cards','locations_cards_kicker'=>'Small Label','locations_cards_heading'=>'Section Title','locations_cards_description'=>'Section Intro') as $id=>$label) $add('lw_home_locations_cards',$id,$label,$id==='locations_cards_enable'?'checkbox':($id==='locations_cards_description'?'textarea':'text'));
 foreach(array('categories'=>'lw_home_categories','locations'=>'lw_home_locations_cards') as $kind=>$section) {
   $sid='lw_options['.$kind.'_cards]';
   $wp_customize->add_setting($sid,array('type'=>'option','default'=>wp_json_encode(lw_home_cards($kind)),'capability'=>'edit_theme_options','transport'=>'refresh','sanitize_callback'=>function($value)use($kind){$clean=lw_clean_home_cards_json($value);return $clean!==null?$clean:wp_json_encode(lw_home_cards($kind));}));
   $wp_customize->add_control(new LW_Customize_Home_Cards_Repeater($wp_customize,$sid,array('label'=>ucfirst($kind).' Cards','section'=>$section,'settings'=>$sid,'kind'=>$kind,'priority'=>25)));
 }
 foreach(array('gallery_kicker'=>'Small Label','gallery_title'=>'Gallery Heading') as $id=>$label) $add('lw_home_gallery',$id,$label);
 for($i=1;$i<=3;$i++) $add('lw_home_gallery','gallery_'.$i,'Gallery Image '.$i,'image');
 foreach(array('location_kicker'=>'Small Label','location_title'=>'Location Heading','location_description'=>'Location Description','location_art_label'=>'Map Card Label','location_map_label'=>'Maps Link Text') as $id=>$label) $add('lw_home_location',$id,$label,$id==='location_description'?'textarea':'text');
 $add('lw_home_location','location_map_url','Google Maps URL','url');$add('lw_home_location','location_image','Location / Map Illustration','image');
 $add('lw_home_faq','faq_kicker','Small Label');$add('lw_home_faq','faq_title','FAQ Heading');
 // Expandable FAQ repeater: one setting, with Add/Remove/Reorder controls.
 $sid='lw_options[faq_items]';
 $wp_customize->add_setting($sid,array('type'=>'option','default'=>wp_json_encode(lw_faq_items()),'capability'=>'edit_theme_options','transport'=>'postMessage','sanitize_callback'=>function($value){$clean=lw_clean_faq_json($value);return $clean!==null?$clean:wp_json_encode(lw_faq_items());}));
 $wp_customize->add_control(new LW_Customize_FAQ_Repeater($wp_customize,$sid,array('label'=>'FAQ Questions & Answers','section'=>'lw_home_faq','settings'=>$sid,'priority'=>20)));
 foreach(array('cta_kicker'=>'Small Label','cta_section_title'=>'CTA Heading','cta_section_desc'=>'CTA Description','cta_button_text'=>'CTA Button Text') as $id=>$label) $add('lw_home_cta',$id,$label,$id==='cta_section_desc'?'textarea':'text');
 $add('lw_home_cta','cta_button_url','CTA Button URL','url');
 foreach(array('blog_kicker'=>'Small Label','blog_title'=>'Articles Heading','blog_all_text'=>'All Articles Link Text') as $id=>$label) $add('lw_home_blog',$id,$label);
 $add('lw_home_blog','blog_count','Number of Articles','number');
 foreach(array('contact_kicker'=>'Small Label','contact_title'=>'Contact Heading','contact_desc'=>'Contact Description') as $id=>$label) $add('lw_home_contact',$id,$label,$id==='contact_desc'?'textarea':'text');
 foreach(array('archive_show_banner'=>'Show Listing Banner','archive_show_search'=>'Show Property Filters','archive_show_results_count'=>'Show Result Count') as $id=>$label) $add('lw_archive',$id,$label,'checkbox');
 foreach(array('archive_kicker'=>'Small Intro (blank = Website Name)','archive_title'=>'Banner Heading (H1)','archive_description'=>'Banner Description','archive_search_kicker'=>'Search Intro','archive_search_title'=>'Search Heading') as $id=>$label) $add('lw_archive',$id,$label,($id==='archive_description'?'textarea':'text'));
 $add('lw_archive','archive_bg_image','Banner Background Image','image');
 $add('lw_archive','archive_bg_color','Custom Background Colour (optional)','text');
 $add('lw_archive','archive_banner_padding','Banner Vertical Padding (px)','number');
 $add('lw_archive','archive_align','Banner Text Alignment','select',array('left'=>'Left','center'=>'Center'));
 $add('lw_motion','card_style' ,'Project Card Style','select',array('lift'=>'Editorial','border'=>'Corporate','soft'=>'Organic'));
 $add('lw_motion','animation','Scroll Entrance','select',array('none'=>'None','reveal'=>'Rise','fade'=>'Fade','slide'=>'Slide'));
 $add('lw_motion','card_hover','Card Hover','select',array('none'=>'None','lift'=>'Lift','zoom'=>'Zoom','glow'=>'Glow'));
 $add('lw_motion','animation_speed','Speed (ms)','number');$add('lw_motion','section_gap','Section Spacing (px)','number');
 foreach(array('whatsapp'=>'WhatsApp Number','email'=>'Public Email','contact_recipient'=>'Lead Email','office_address'=>'Office Address','rera_number'=>'RERA Registration','footer_about'=>'Footer Text','footer_disclaimer'=>'Disclaimer') as $id=>$label) $add('lw_footer',$id,$label, in_array($id,array('office_address','footer_about','footer_disclaimer'),true)?'textarea':'text');
});

add_action('customize_register',function(){
 if(class_exists('LW_Customize_FAQ_Repeater')) return;
 class LW_Customize_FAQ_Repeater extends WP_Customize_Control {
  public $type='lw_faq_repeater';
  protected function render_content() {
   echo '<span class="customize-control-title">'.esc_html($this->label).'</span>';
   lw_faq_repeater_markup(true);
  }
 }
},1);
add_action('customize_register',function(){
 if(class_exists('LW_Customize_Home_Cards_Repeater'))return;
 class LW_Customize_Home_Cards_Repeater extends WP_Customize_Control {
  public $type='lw_home_cards_repeater';public $kind='categories';
  protected function render_content() {
   echo '<span class="customize-control-title">'.esc_html($this->label).'</span>';
   lw_home_cards_repeater_markup($this->kind,true);
  }
 }
},1);
add_action('customize_controls_enqueue_scripts',function(){
 wp_enqueue_script('lw-faq-editor',LW_URI.'/assets/js/faq-editor.js',array('customize-controls'),LW_VERSION,true);
 wp_enqueue_style('lw-faq-editor',LW_URI.'/assets/css/faq-editor.css',array(),LW_VERSION);
 wp_enqueue_script('lw-home-cards-editor',LW_URI.'/assets/js/home-cards-editor.js',array('customize-controls'),LW_VERSION,true);
 wp_enqueue_style('lw-home-cards-editor',LW_URI.'/assets/css/home-cards-editor.css',array(),LW_VERSION);
});

// Registers the browser-side instant preview. Unhandled settings keep WordPress refresh transport.
add_action('customize_preview_init',function(){
 wp_enqueue_script('lw-customizer-preview',LW_URI.'/assets/js/customizer-preview.js',array('customize-preview'),LW_VERSION,true);
 $font_css=array();foreach(lw_fonts() as $key=>$definition) $font_css[$key]=$definition['css'];
 wp_localize_script('lw-customizer-preview','LWLivePreview',array('fonts'=>$font_css,'defaultHero'=>LW_URI.'/assets/img/hero-'.sanitize_file_name(lw_opt('preset','utopia')).'.svg'));
});
