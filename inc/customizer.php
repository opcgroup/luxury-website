<?php
if(!defined('ABSPATH')) exit;
add_action('customize_register',function($wp_customize){
 $wp_customize->add_panel('lw_panel',array('title'=>'Luxury Website — Design Studio','priority'=>30,'description'=>'Control the theme appearance. For the drag-and-drop header builder, open Appearance → Luxury Website.'));
 $groups=array(
  'lw_identity'=>array('title'=>'Global Colours & Fonts','priority'=>10),
  'lw_header'=>array('title'=>'Header & Navigation','priority'=>20),
  'lw_hero'=>array('title'=>'Hero & Buttons','priority'=>30),
  'lw_sections'=>array('title'=>'Homepage Sections','priority'=>40),
  'lw_archive'=>array('title'=>'Projects Listing Page','priority'=>45),
  'lw_motion'=>array('title'=>'Cards & Animations','priority'=>50),
  'lw_footer'=>array('title'=>'Contact & Footer','priority'=>60),
 );
 foreach($groups as $id=>$val) $wp_customize->add_section($id,array_merge($val,array('panel'=>'lw_panel')));
 $add=function($section,$id,$label,$type='text',$choices=array()) use($wp_customize){
  $default=lw_defaults();$sid='lw_options['.$id.']';
  $wp_customize->add_setting($sid,array('type'=>'option','default'=>$default[$id]??'','capability'=>'edit_theme_options','transport'=>'refresh','sanitize_callback'=>function($v)use($id){$arr=lw_sanitize_options(array($id=>$v));return $arr[$id];}));
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
 foreach(array('stats_enable'=>'Show Stats','about_enable'=>'Show About','projects_enable'=>'Show Projects','filters_enable'=>'Project Filters','features_enable'=>'Show Features','gallery_enable'=>'Show Image Gallery','location_enable'=>'Show Location','faq_enable'=>'Show FAQ','cta_enable'=>'Show CTA','blog_enable'=>'Show Articles','contact_enable'=>'Show Enquiry Form','use_page_content'=>'Use Custom Homepage Content') as $id=>$label) $add('lw_sections',$id,$label,'checkbox');
 foreach(array('about_title'=>'About Title','projects_title'=>'Projects Title','features_title'=>'Features Title','cta_section_title'=>'CTA Title','blog_title'=>'Blog Title','contact_title'=>'Contact Title') as $id=>$label) $add('lw_sections',$id,$label);
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
