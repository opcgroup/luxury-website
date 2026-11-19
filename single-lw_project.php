<?php
if(!defined('ABSPATH')) exit;
get_header();
if(have_posts()):while(have_posts()):the_post();
$id=get_the_ID();
$fields=array('Configuration'=>'_lw_configuration','Area'=>'_lw_area','Bathrooms'=>'_lw_bathrooms','Parking'=>'_lw_parking','Furnishing'=>'_lw_furnishing','Possession'=>'_lw_possession','Developer'=>'_lw_developer','RERA Registration'=>'_lw_rera');
$location=get_post_meta($id,'_lw_location',true);
$price=get_post_meta($id,'_lw_price',true);
$kind=get_post_meta($id,'_lw_listing_kind',true);
$brochure=get_post_meta($id,'_lw_brochure',true);
$floor=get_post_meta($id,'_lw_floor_plan',true);
$map=get_post_meta($id,'_lw_map',true);
$video=get_post_meta($id,'_lw_video',true);
$amenities=preg_split('/\r\n|\r|\n/',(string)get_post_meta($id,'_lw_amenities',true));
$gallery=lw_project_gallery_ids($id);
$whatsapp=lw_whatsapp_href();
if($whatsapp) $whatsapp.='?text='.rawurlencode('Hello, I would like details and a site visit for '.get_the_title().': '.get_permalink());
lw_page_hero(get_the_title(),$location);
?>
<section class="lw-section lw-realestate-single"><div class="lw-container">
 <div class="lw-single-property-top"><div><span class="lw-eyebrow"><?php echo esc_html($kind?ucwords(str_replace('-',' ',$kind)):'PROPERTY OVERVIEW'); ?></span><h2><?php the_title(); ?></h2><?php if($location): ?><p class="lw-property-address">⌖ <?php echo esc_html($location); ?></p><?php endif; ?></div><div class="lw-single-property-price"><small>Starting Price / Asking Price</small><strong><?php echo esc_html($price ?: 'Price on Request'); ?></strong></div></div>
 <div class="lw-single-property-layout"><main class="lw-single-property-main">
 <?php if(has_post_thumbnail()): ?><div class="lw-single-feature-photo"><?php the_post_thumbnail('full',array('loading'=>'eager')); ?></div><?php endif; ?>
 <?php if($gallery): ?><div class="lw-single-photo-grid" aria-label="Property photo gallery"><?php foreach($gallery as $attachment_id):$large=wp_get_attachment_image_url($attachment_id,'full');if(!$large) continue;?><a href="<?php echo esc_url($large); ?>" target="_blank" rel="noopener noreferrer"><?php echo wp_get_attachment_image($attachment_id,'medium_large',false,array('loading'=>'lazy')); ?></a><?php endforeach; ?></div><?php endif; ?>
 <div class="lw-property-description"><span class="lw-eyebrow">ABOUT THIS PROPERTY</span><h2>Property Details</h2><div class="lw-editor-content"><?php the_content(); ?></div></div>
 <?php if(array_filter($amenities,'strlen')): ?><section class="lw-single-section"><span class="lw-eyebrow">LIFESTYLE & CONVENIENCE</span><h2>Project Amenities</h2><ul class="lw-amenities-list"><?php foreach($amenities as $amenity):$amenity=trim($amenity);if($amenity!==''): ?><li><span aria-hidden="true">✓</span><?php echo esc_html($amenity); ?></li><?php endif;endforeach; ?></ul></section><?php endif; ?>
 <?php if($floor): ?><section class="lw-single-section"><span class="lw-eyebrow">PLANS & LAYOUTS</span><h2>Floor Plan</h2><?php $path=(string)wp_parse_url($floor,PHP_URL_PATH);if(preg_match('/\.(png|jpe?g|webp|gif)$/i',$path)): ?><a href="<?php echo esc_url($floor); ?>" target="_blank" rel="noopener noreferrer"><img class="lw-floorplan-photo" loading="lazy" src="<?php echo esc_url($floor); ?>" alt="Floor plan of <?php echo esc_attr(get_the_title()); ?>"></a><?php endif; ?><p><a class="lw-text-link" href="<?php echo esc_url($floor); ?>" target="_blank" rel="noopener noreferrer">Open Floor Plan ↗</a></p></section><?php endif; ?>
 <?php if($map): ?><section class="lw-single-section"><span class="lw-eyebrow">CONNECTIVITY</span><h2>Location & Map</h2><p><?php echo esc_html($location); ?></p><a class="lw-button lw-button-outline-dark" href="<?php echo esc_url($map); ?>" target="_blank" rel="noopener noreferrer">View on Google Maps ↗</a></section><?php endif; ?>
 <?php if($video): ?><section class="lw-single-section"><span class="lw-eyebrow">VIRTUAL TOUR</span><h2>Project Walkthrough</h2><p><a class="lw-text-link" href="<?php echo esc_url($video); ?>" target="_blank" rel="noopener noreferrer">Watch Property Video ↗</a></p></section><?php endif; ?>
 </main><aside class="lw-project-aside lw-realestate-sidebar"><h2>Property at a Glance</h2><dl>
 <?php foreach($fields as $label=>$key):$v=get_post_meta($id,$key,true);if(!$v)continue;?><div><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($v); ?></dd></div><?php endforeach; ?></dl>
 <?php if($brochure): ?><a class="lw-button" href="<?php echo esc_url($brochure); ?>" target="_blank" rel="noopener noreferrer">View / Download Brochure ↗</a><?php endif; ?>
 <?php if($whatsapp): ?><a class="lw-button lw-property-whatsapp" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener noreferrer">Enquire on WhatsApp ↗</a><?php endif; ?>
 <div id="contact" class="lw-sidebar-lead"><h3>Request Price & Site Visit</h3><p>Send your requirements for this property.</p><?php lw_render_contact_form('project-'.$id); ?></div>
 </aside></div>
 <p class="lw-realestate-disclaimer">Project specifications, prices, availability, possession schedules and approvals are subject to developer confirmation. Verify the official RERA record and documents before making any payment.</p>
 </div></section>
<?php endwhile;endif;get_footer(); ?>
