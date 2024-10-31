<?
/*

Plugin Name: Posts Page Custom Template
Description: Allows wordpress to use the custom template of the page which is set within the 'Posts page:' setting of the 'Reading' options.
Version: 1.0
Author: ballyhoos

*/


function posts_page_custom_template($template)
{
	global $wp_query;
	#	find if a page_for_posts have been set.
	if( true == ( $posts_per_page_id = get_option('page_for_posts')) ){
		#	get the current page id.
		$page_id = $wp_query->get_queried_object_id();
		#	if the same page, get the correct template.
		if( $page_id == $posts_per_page_id ){
			#	get the current theme directory.
			$theme_directory = get_stylesheet_directory() ."/";
			#	get the page template
			$page_template   = get_post_meta($page_id, '_wp_page_template', true );
			#	by-pass the default template, allow wordpress to handle the fallback template.
			if( $page_template != 'default' ){
				#	find the template in the parent if the template is not a child template
				if( is_child_theme() && !file_exists($theme_directory . $page_template) ){
					#	set to parent template directory 
					$theme_directory = get_template_directory();
				}
				return $theme_directory . $page_template;
			}
		}
	}
	return $template;
}

add_filter('template_include', 'posts_page_custom_template');

?>