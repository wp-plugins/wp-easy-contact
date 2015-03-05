<?php
/**
 * Query Filter Functions
 *
 * @package WP_ECONTACT
 * @version 1.0.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Change query parameters before wp_query is processed
 *
 * @since WPAS 4.0
 * @param object $query
 *
 * @return object $query
 */
function wp_econtact_query_filters($query) {
	$has_limitby = get_option("wp_econtact_has_limitby_cap");
	if (!is_admin() && $query->is_main_query()) {
		if ($query->is_author || $query->is_search) {
			$query = emd_limit_author_search('wp_econtact', $query, $has_limitby);
		}
	}
	return $query;
}
add_action('pre_get_posts', 'wp_econtact_query_filters');
