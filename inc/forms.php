<?php
if(!defined('ABSPATH')) exit;
function lw_render_contact_form($id='default') {
 $o=lw_options();$status=isset($_GET['lw_enquiry'])?sanitize_key(wp_unslash($_GET['lw_enquiry'])):'';
 echo '<form class="lw-enquiry-form" action="'.esc_url(admin_url('admin-post.php')).'" method="post">';
 echo '<input type="hidden" name="action" value="lw_contact">';wp_nonce_field('lw_contact_form','lw_nonce');
 if(preg_match('/^project-(\d+)$/',(string)$id,$m)) {
  $project_id=absint($m[1]);
  if($project_id && get_post_type($project_id)==='lw_project') echo '<input type="hidden" name="lw_property_id" value="'.esc_attr($project_id).'">';
 }
 echo '<div class="lw-honey" aria-hidden="true"><label>Website <input type="text" name="lw_website" autocomplete="off" tabindex="-1"></label></div>';
 echo '<div class="lw-form-grid"><label>'.esc_html__('Your Name','luxury-website').'<input name="lw_name" required maxlength="100" autocomplete="name" placeholder="Full Name"></label><label>'.esc_html__('Phone Number','luxury-website').'<input name="lw_phone" type="tel" required maxlength="22" autocomplete="tel" placeholder="Mobile Number"></label></div>';
 echo '<label>'.esc_html__('Email Address (optional)','luxury-website').'<input name="lw_email" type="email" maxlength="160" autocomplete="email" placeholder="Email Address"></label>';
 echo '<label>'.esc_html__('Interested In','luxury-website').'<select name="lw_interest"><option value="Site Visit">Book a Site Visit</option><option value="Price List">Get Price List</option><option value="Property Details">Property Details</option><option value="Other Enquiry">Other Enquiry</option></select></label>';
 echo '<label>'.esc_html__('Message (optional)','luxury-website').'<textarea rows="3" name="lw_message" maxlength="2000" placeholder="Tell us your requirement"></textarea></label>';
 echo '<button type="submit" class="lw-button">'.esc_html__('Send Enquiry','luxury-website').' <span aria-hidden="true">↗</span></button>';
 if($status==='success') echo '<p class="lw-form-notice" role="status">Thank you. Your enquiry has been submitted.</p>';
 if($status==='error') echo '<p class="lw-form-error" role="alert">We could not send your enquiry. Please call us directly.</p>';
 echo '</form>';
}
add_shortcode('luxury_contact_form',function(){ob_start();lw_render_contact_form();return ob_get_clean();});
add_action('admin_post_nopriv_lw_contact','lw_handle_contact');add_action('admin_post_lw_contact','lw_handle_contact');
function lw_handle_contact(){
 if($_SERVER['REQUEST_METHOD']!=='POST') wp_die('Invalid request', '',array('response'=>405));
 if(!isset($_POST['lw_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['lw_nonce'])),'lw_contact_form')) wp_die('Invalid security token. Please refresh and retry.', '',array('response'=>403));
 $referer=wp_get_referer() ?: home_url('/');
 if(!empty($_POST['lw_website'])) {wp_safe_redirect(add_query_arg('lw_enquiry','success',$referer));exit;}
 $ip=isset($_SERVER['REMOTE_ADDR'])?sanitize_text_field($_SERVER['REMOTE_ADDR']):'';
 $throttle_key='lw_limiter_'.substr(wp_hash($ip.'|'.date('Y-m-d-H')),0,26);
 $attempts=(int)get_transient($throttle_key);
 if($attempts>=7){wp_die('Please try again later.', '',array('response'=>429));}
 set_transient($throttle_key,$attempts+1,HOUR_IN_SECONDS);
 $name=(isset($_POST['lw_name'])&&is_string($_POST['lw_name']))?sanitize_text_field(wp_unslash($_POST['lw_name'])):'';
 $phone=(isset($_POST['lw_phone'])&&is_string($_POST['lw_phone']))?preg_replace('/[^+0-9() .-]/','',wp_unslash($_POST['lw_phone'])):'';
 $email=(isset($_POST['lw_email'])&&is_string($_POST['lw_email']))?sanitize_email(wp_unslash($_POST['lw_email'])):'';
 $interest=(isset($_POST['lw_interest'])&&is_string($_POST['lw_interest']))?sanitize_text_field(wp_unslash($_POST['lw_interest'])):'';
 $message=(isset($_POST['lw_message'])&&is_string($_POST['lw_message']))?sanitize_textarea_field(wp_unslash($_POST['lw_message'])):'';
 if(strlen($name)<2||strlen(preg_replace('/\D/','',$phone))<8||($email&&!is_email($email))) {wp_safe_redirect(add_query_arg('lw_enquiry','error',$referer));exit;}
 $to=is_email(lw_opt('contact_recipient'))?lw_opt('contact_recipient'):get_option('admin_email');
 $subject='New website enquiry — '.get_bloginfo('name');
 $property_id=isset($_POST['lw_property_id']) ? absint($_POST['lw_property_id']) : 0;
 $property_context='';
 if($property_id && get_post_type($property_id)==='lw_project' && get_post_status($property_id)==='publish') {
  $property_context="Property: ".get_the_title($property_id)."\nProperty URL: ".get_permalink($property_id)."\n";
 }
 $body="Name: $name\nPhone: $phone\nEmail: $email\nInterested in: $interest\n".$property_context."Message:\n$message\n\nSource: ".home_url('/');
 $headers=array('Content-Type: text/plain; charset=UTF-8');
 if($email) $headers[]='Reply-To: '. $email;
 $ok=wp_mail($to,$subject,$body,$headers);
 wp_safe_redirect(add_query_arg('lw_enquiry',$ok?'success':'error',$referer).'#contact');exit;
}
