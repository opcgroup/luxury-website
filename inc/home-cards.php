<?php
/** Editable, data-driven homepage property category and location cards. */
if (!defined('ABSPATH')) exit;
function lw_default_home_cards($kind) {
 if($kind==='categories') {
  $titles=array('Residential Plots & Land','Apartments & Independent Floors','Luxury Villas & Houses','Commercial Properties','Upcoming Townships','Resale Properties');
 } else {
  $titles=array('Baddi & Barotiwala','Solan','Kasauli Region','Shimla Region');
 }
 return array_map(function($title){return array('title'=>$title,'description'=>'','image'=>'','url'=>'');},$titles);
}
function lw_home_cards($kind) {
 if(!in_array($kind,array('categories','locations'),true)) return array();
 $o=lw_options();$raw=$o[$kind.'_cards']??'';
 if($raw!=='') {
  $list=json_decode($raw,true);
  if(is_array($list)) return array_values(array_filter($list,function($v){return is_array($v) && !empty($v['title']);}));
 }
 return lw_default_home_cards($kind);
}
function lw_clean_home_cards_json($json) {
 if(!is_string($json) || strlen($json)>200000) return null;
 $decoded=json_decode($json,true);
 if(!is_array($decoded) || ($decoded && array_keys($decoded)!==range(0,count($decoded)-1))) return null;
 $clean=array();
 foreach($decoded as $r) {
  if(count($clean)>=30) break;
  if(!is_array($r)) continue;
  $title=substr(sanitize_text_field((string)($r['title']??'')),0,160);
  if(!$title)continue;
  $clean[]=array(
   'title'=>$title,
   'description'=>substr(sanitize_textarea_field((string)($r['description']??'')),0,600),
   'image'=>esc_url_raw((string)($r['image']??'')),
   'url'=>esc_url_raw((string)($r['url']??''))
  );
 }
 return wp_json_encode($clean,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}
function lw_home_cards_repeater_markup($kind,$customizer=false) {
 if(!in_array($kind,array('categories','locations'),true)) return;
 $value=wp_json_encode(lw_home_cards($kind),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP|JSON_HEX_TAG);
 $field=$kind.'_cards';
 echo '<div class="lw-home-card-editor" data-kind="'.esc_attr($kind).'" data-context="'.($customizer?'customizer':'studio').'">';
 echo '<p class="description">Add as many cards as needed (up to 30). Change the image, text and button URL, then reorder using the arrows. Use an existing project/category page as the URL.</p>';
 echo '<div class="lw-home-card-list"></div><button class="button button-secondary lw-home-card-add" type="button">+ Add '.($kind==='categories'?'Property Category':'Location').'</button>';
 echo '<input type="hidden" class="lw-home-card-json" '.($customizer?'data-customize-setting-link="lw_options['.$field.']"':'name="lw_options['.$field.']"').' value="'.esc_attr($value).'">';
 echo '</div>';
}
function lw_home_card_link($item,$kind) {
 if(!empty($item['url']))return esc_url($item['url']);
 $taxonomy=$kind==='categories'?'lw_project_type':'lw_project_location';
 $slug=sanitize_title($item['title']);
 $term=get_term_by('slug',$slug,$taxonomy);
 if(!$term || is_wp_error($term))$term=get_term_by('name',$item['title'],$taxonomy);
 if($term && !is_wp_error($term)) {
  $url=get_term_link($term); if(!is_wp_error($url))return esc_url($url);
 }
 return esc_url(get_post_type_archive_link('lw_project')?:home_url('/projects/'));
}
function lw_render_home_card_section($kind) {
 $o=lw_options();if(empty($o[$kind.'_cards_enable']))return;
 $items=lw_home_cards($kind);if(!$items)return;
 $class=$kind==='categories'?'lw-home-categories':'lw-home-locations';
 echo '<section class="lw-section lw-home-cards-section '.esc_attr($class).'" id="'.esc_attr($kind==='categories'?'property-categories':'property-locations').'"><div class="lw-container">';
 echo '<div class="lw-center-heading"><span class="lw-eyebrow">'.esc_html($o[$kind.'_cards_kicker']).'</span><h2>'.esc_html($o[$kind.'_cards_heading']).'</h2>';
 if(!empty($o[$kind.'_cards_description']))echo '<p>'.esc_html($o[$kind.'_cards_description']).'</p>';
 echo '</div><div class="lw-home-cards-grid">';
 foreach($items as $item) {
  $title=trim((string)($item['title']??''));if(!$title)continue;
  $desc=(string)($item['description']??'');$image=(string)($item['image']??'');
  echo '<article class="lw-home-card lw-reveal"><a href="'.lw_home_card_link($item,$kind).'" class="lw-home-card-link" aria-label="'.esc_attr('Explore '.$title).'">';
  if($image)echo '<img src="'.esc_url($image).'" loading="lazy" decoding="async" alt="'.esc_attr($title).'">';
  else echo '<div class="lw-home-card-placeholder" aria-hidden="true">⌂</div>';
  echo '<span class="lw-home-card-overlay"><strong>'.esc_html($title).'</strong>';
  if($desc)echo '<span class="lw-home-card-desc">'.esc_html($desc).'</span>';
  echo '<span class="lw-home-card-arrow" aria-hidden="true">↗</span></span></a></article>';
 }
 echo '</div></div></section>';
}
