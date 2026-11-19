<?php
if(!defined('ABSPATH')) exit;
// Keep searchable real estate directory cards and pagination for project-specific searches.
if(get_query_var('post_type')==='lw_project' || lw_property_filter('post_type')==='lw_project') {
 get_template_part('archive','lw_project');
} else {
 get_template_part('index');
}
