<?php
/**
 * Registered on the server so editor patterns appear even when a custom
 * block's JavaScript is delayed, blocked or disabled. All content is editable
 * core Gutenberg markup. No imported image assets or unverified property claims.
 */
if (!defined('ABSPATH')) exit;

function lw_pat_wrap($name, $attributes, $content) {
    $json = $attributes ? ' ' . wp_json_encode($attributes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '';
    return '<!-- wp:'.$name.$json.' -->'.$content.'<!-- /wp:'.$name.' -->';
}
function lw_pat_p($text, $class='') {
    $attrs=$class?array('className'=>$class):array();
    return lw_pat_wrap('paragraph',$attrs,'<p'.($class?' class="'.esc_attr($class).'"':'').'>'.esc_html($text).'</p>');
}
function lw_pat_h($text,$level=2) {
    $attrs=$level===2?array():array('level'=>$level);
    return lw_pat_wrap('heading',$attrs,'<h'.$level.' class="wp-block-heading">'.esc_html($text).'</h'.$level.'>');
}
function lw_pat_button($label,$url='#contact') {
    $button=lw_pat_wrap('button',array('url'=>$url),'<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="'.esc_url($url).'">'.esc_html($label).'</a></div>');
    return lw_pat_wrap('buttons',array(),'<div class="wp-block-buttons">'.$button.'</div>');
}
function lw_pat_group($inner,$class='lw-inner-section',$full=true,$anchor='') {
    $attrs=array('className'=>$class,'layout'=>array('type'=>'constrained'));
    if($full)$attrs=array('align'=>'full')+$attrs;
    if($anchor)$attrs['anchor']=$anchor;
    $classes='wp-block-group'.($full?' alignfull':'').' '.esc_attr($class);
    $id=$anchor?' id="'.esc_attr($anchor).'"':'';
    return lw_pat_wrap('group',$attrs,'<div'.$id.' class="'.$classes.'">'.$inner.'</div>');
}
function lw_pat_cols($columns) {
    $html='';
    foreach ($columns as $content) {
        $html.=lw_pat_wrap('column',array(),'<div class="wp-block-column">'.$content.'</div>');
    }
    return lw_pat_wrap('columns',array(),'<div class="wp-block-columns">'.$html.'</div>');
}
function lw_pat_card($title,$body) {
    return lw_pat_group(lw_pat_h($title,3).lw_pat_p($body),'lw-inner-card',false);
}
function lw_pat_placeholder($label) {
    return lw_pat_group(lw_pat_p($label),'lw-inner-placeholder',false);
}
function lw_pat_section($inner,$suffix='') {
    return lw_pat_group($inner,'lw-inner-section'.($suffix?' '.$suffix:''));
}
function lw_pat_intro($eyebrow,$title,$body) {
    return lw_pat_p($eyebrow,'lw-inner-eyebrow').lw_pat_h($title).lw_pat_p($body);
}
function lw_pat_hero($eyebrow,$title,$body) {
    return lw_pat_section(lw_pat_p($eyebrow,'lw-inner-eyebrow').lw_pat_h($title,1).lw_pat_p($body).lw_pat_button('Enquire Now'),'lw-inner-hero');
}
function lw_pat_cta($heading,$text) {
    return lw_pat_group(lw_pat_h($heading).lw_pat_p($text).lw_pat_button('Contact Us','#contact'),'lw-inner-section lw-inner-dark lw-inner-cta',true,'contact');
}
function lw_pat_items($items) {
    return lw_pat_cols(array_map(function($item){return lw_pat_card($item[0],$item[1]);},$items));
}
function lw_register_inner_page_patterns() {
    if (!function_exists('register_block_pattern_category') || !function_exists('register_block_pattern')) return;
    register_block_pattern_category('luxury-inner-pages',array('label'=>__('Luxury Inner Pages','luxury-website')));
    $patterns=array();

    $patterns['about']=array('01 · About Us — Complete Page',
        lw_pat_hero('ABOUT THE COMPANY','Built around trust and real estate expertise.','Introduce your agency, developer or property advisory practice.')
        .lw_pat_section(lw_pat_intro('WHO WE ARE','Your story and your approach.','Replace this introduction with your verified history, mission and market experience.')
            .lw_pat_cols(array(
                lw_pat_h('Our Story',3).lw_pat_p('Explain your journey, the markets you serve and your property expertise.'),
                lw_pat_placeholder('Replace with a real team, office or project photograph.')))
        )
        .lw_pat_section(lw_pat_intro('WHY WORK WITH US','Experience that makes the difference.','Describe your genuine strengths and services.')
            .lw_pat_items(array(
                array('Local Expertise','Explain the neighborhoods and property segments you know.'),
                array('Transparent Guidance','Explain your property documentation and advisory approach.'),
                array('Site Visit Support','Describe how buyers can arrange a property viewing.'))),'lw-inner-soft')
        .lw_pat_cta('Find the property that fits your goals.','Tell us about your preferred location, configuration and budget.'));

    $patterns['project']=array('02 · Project Details — Landing Page',
        lw_pat_hero('PROJECT OVERVIEW','An address with room to grow.','Add approved project details, developer name and confirmed location.')
        .lw_pat_section(lw_pat_intro('INTRODUCTION','Designed for the next chapter.','Use verified details only: approved RERA registration, property category, unit sizes and development status.')
            .lw_pat_cols(array(
                lw_pat_placeholder('Add the official project elevation or real site photograph.'),
                lw_pat_h('At a glance',3).lw_pat_p('Developer: [Insert verified name]').lw_pat_p('Location: [Insert verified location]').lw_pat_p('Configurations: [Insert approved options]').lw_pat_p('RERA: [Insert verified number]'))))
        .lw_pat_section(lw_pat_intro('HIGHLIGHTS','What makes this project worth exploring.','Show only features supported by the developer’s documentation.')
            .lw_pat_items(array(
                array('Connectivity','Describe verified road and transport connections.'),
                array('Planning','Add approved unit layouts, open spaces and site planning details.'),
                array('Lifestyle','Add documented amenities and community features.'))),'lw-inner-soft')
        .lw_pat_section(lw_pat_h('Floor plans and project gallery')
            .lw_pat_cols(array(lw_pat_placeholder('Insert an approved floor plan image.'),lw_pat_placeholder('Insert project photographs or labelled illustrative renders.'))))
        .lw_pat_cta('Request the updated price list and brochure.','Confirm availability, terms and all price components with the team.'));

    $patterns['location']=array('03 · Location & Connectivity',
        lw_pat_hero('LOCATION','Connected to the places that matter.','Introduce the project’s verified location and local context.')
        .lw_pat_section(lw_pat_intro('NEIGHBOURHOOD','Explore the local advantage.','Use accurate, verifiable travel connections and distances.')
            .lw_pat_items(array(
                array('Major Roads','Enter approved access roads and connectivity details.'),
                array('Education & Health','Mention nearby institutions only after verifying locations.'),
                array('Daily Convenience','Describe nearby shopping and services without unverified claims.'))))
        .lw_pat_section(lw_pat_h('Find us on the map').lw_pat_p('Insert the Google Maps Embed block or a project location image here.').lw_pat_placeholder('LOCATION MAP PLACEHOLDER'),'lw-inner-soft')
        .lw_pat_cta('Arrange a site visit.','Request confirmed directions and available viewing appointments.'));

    $patterns['floorplans']=array('04 · Floor Plans & Prices',
        lw_pat_hero('FLOOR PLANS','Find a layout that works for you.','Compare available configurations and their approved area details.')
        .lw_pat_section(lw_pat_h('Available configurations')
            .lw_pat_items(array(
                array('Configuration A','Add approved BHK, utility and area details.'),
                array('Configuration B','Add approved unit size and room distribution.'),
                array('Configuration C','Add approved layout information and balcony details.'))))
        .lw_pat_section(lw_pat_h('Detailed floor plans')
            .lw_pat_cols(array(lw_pat_placeholder('Insert official Floor Plan A.'),lw_pat_placeholder('Insert official Floor Plan B.'))),'lw-inner-soft')
        .lw_pat_section(lw_pat_h('Pricing & payment plan').lw_pat_p('Insert the latest confirmed price list and payment schedule, including statutory charges and exclusions.'))
        .lw_pat_cta('Ask for the latest floor plan and pricing.','Confirm availability before making a booking decision.'));

    $patterns['amenities']=array('05 · Amenities & Specifications',
        lw_pat_hero('AMENITIES','A community designed for everyday life.','Describe facilities and specifications supported by approved plans.')
        .lw_pat_section(lw_pat_h('Community features')
            .lw_pat_items(array(array('Green Spaces','Documented landscaping and outdoor spaces.'),array('Fitness & Leisure','Approved fitness and recreational features.'),array('Security','Verified access and security specifications.')))
            .lw_pat_items(array(array('Parking','Approved parking arrangements.'),array('Utilities','Water and electrical provisions.'),array('Community','Shared facilities and resident spaces.'))))
        .lw_pat_section(lw_pat_h('Materials and specifications')
            .lw_pat_cols(array(
                lw_pat_h('Structure & finishes',3).lw_pat_p('Add the developer-approved structural and finish specifications.'),
                lw_pat_h('Kitchen & bathrooms',3).lw_pat_p('Insert verified fixture and fitting details.'))),'lw-inner-soft')
        .lw_pat_cta('Request complete project specifications.','Ask for the latest approved document and site-visit details.'));

    $patterns['gallery']=array('06 · Gallery & Lifestyle',
        lw_pat_hero('PHOTO GALLERY','Explore the spaces and surroundings.','Upload real property images or label visualisations clearly as illustrative.')
        .lw_pat_section(lw_pat_h('Project gallery')
            .lw_pat_cols(array(lw_pat_placeholder('Insert exterior images using Image or Gallery blocks.'),lw_pat_placeholder('Insert sample apartment / interior photographs.'))))
        .lw_pat_section(lw_pat_h('Community and lifestyle')
            .lw_pat_cols(array(lw_pat_placeholder('Insert clubhouse / landscaping visuals.'),lw_pat_placeholder('Insert neighbourhood / common-area visuals.'))),'lw-inner-soft')
        .lw_pat_section(lw_pat_p('Use accurate image captions; distinguish real photographs from concept renderings.'))
        .lw_pat_cta('See it in person.','Book a project visit for current site conditions.'));

    $patterns['contact']=array('07 · Contact & Enquiry',
        lw_pat_hero('CONTACT US','Talk to our property team.','Ask about project details, pricing or site visits.')
        .lw_pat_group(lw_pat_cols(array(
                lw_pat_h('Send an enquiry',2).lw_pat_wrap('shortcode',array(),'[luxury_contact_form]'),
                lw_pat_h('Our office',2).lw_pat_p('Insert your correct office address and working hours.').lw_pat_h('Contact number',3).lw_pat_p('Add your verified phone number and WhatsApp contact.'))),
            'lw-inner-section',true,'contact')
        .lw_pat_section(lw_pat_h('Find us').lw_pat_placeholder('Insert an embedded Google Map or office location image.'),'lw-inner-soft'));

    $patterns['services']=array('08 · Real Estate Services',
        lw_pat_hero('OUR SERVICES','Property advice tailored to you.','Introduce the services your business actually provides.')
        .lw_pat_section(lw_pat_h('Our services')
            .lw_pat_items(array(
                array('Residential Advisory','Location research, shortlisting and viewing support.'),
                array('Resale & Rental','Buyer, seller, landlord and tenant coordination.'),
                array('Commercial Advisory','Advice on available commercial property formats.'))))
        .lw_pat_section(lw_pat_h('How it works').lw_pat_cols(array(
                lw_pat_card('1. Discover','Share your property criteria and budget.'),
                lw_pat_card('2. Compare','Review approved property information.'),
                lw_pat_card('3. Visit','Schedule a site visit and follow up.'))),'lw-inner-soft')
        .lw_pat_cta('Discuss your property requirement.','Tell us your preferred city, property type and timeline.'));

    $patterns['faq']=array('09 · FAQs & Buyer Guide',
        lw_pat_hero('BUYER GUIDE','Important questions, useful answers.','Help visitors understand what they need to verify before booking.')
        .lw_pat_section(lw_pat_h('Frequently asked questions')
            .lw_pat_h('Is the project RERA registered?',3).lw_pat_p('Enter the applicable, verified RERA registration information and official source.')
            .lw_pat_h('What is included in the quoted price?',3).lw_pat_p('Explain the pricing components, taxes and additional charges.')
            .lw_pat_h('When is possession expected?',3).lw_pat_p('Refer to the latest official RERA or contractual possession timeline.')
            .lw_pat_h('How do I plan a site visit?',3).lw_pat_p('Insert your site visit scheduling process and contact information.'))
        .lw_pat_section(lw_pat_h('Buyer checklist')
            .lw_pat_p('Check ownership, approvals, RERA details, carpet area, agreement terms, payment schedule, cancellation terms and actual site progress.'),'lw-inner-soft')
        .lw_pat_cta('Need more project information?','Talk to us before you make a booking decision.'));

    $patterns['feature']=array('10 · Section — Property Benefit Cards',
        lw_pat_section(lw_pat_intro('PROJECT BENEFITS','Why consider this address?','Use verified details only.')
            .lw_pat_items(array(
                array('The Location','Add accurate connectivity information.'),
                array('The Planning','Add approved floor plans and amenities.'),
                array('The Support','Explain your after-sales or enquiry services.'))),'lw-inner-soft'));

    $patterns['cta']=array('11 · Section — Enquiry CTA',
        lw_pat_cta('Ready to explore your options?','Ask our team about the latest availability, price list and project visits.'));

    foreach($patterns as $slug=>$details) {
        register_block_pattern('luxury-inner/'.$slug,array(
            'title'=>__($details[0],'luxury-website'),
            'description'=>__('Editable layout for real estate inner pages. Replace all example text and placeholders.','luxury-website'),
            'categories'=>array('luxury-inner-pages'),
            'viewportWidth'=>1200,
            'content'=>$details[1]
        ));
    }
}
add_action('init','lw_register_inner_page_patterns',22);
