<?php
/**
 * Access Functions
 *
 * @package     EMD
 * @copyright   Copyright (c) 2014,  Emarket Design
 * @since       1.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Checks if access views set and if user doesn't have access show no-access page
 *
 * @since WPAS 4.0
 * @param string $app
 * @param string $fpath
 * @param string $template
 *
 * @return string $template
 */
function emd_show_no_access_page($app, $fpath, $template) {
	$access_views = get_option($app . "_access_views");
	global $post;
	if (is_single() && empty($post->post_password)) {
		if (!empty($access_views['single'])) {
			foreach ($access_views['single'] as $vval) {
				if (get_post_type() == $vval['obj'] && !current_user_can('view_' . $vval['name'])) {
					return $fpath . 'includes/no-access.php';
				}
			}
		}
		$has_limit_by = get_option($app . "_has_limitby_cap");
		if (isset($has_limit_by) && $has_limit_by == 1) {
			$pids = apply_filters('emd_limit_by', Array() , $app, $post->post_type);
			if (!empty($pids) && !in_array($post->ID, $pids)) {
				return $fpath . 'includes/no-access.php';
			}
		}
	} elseif (is_tax() && !empty($access_views['tax'])) {
		foreach ($access_views['tax'] as $vval) {
			if (is_tax($vval['obj']) && !current_user_can('view_' . $vval['name'])) {
				return $fpath . 'includes/no-access.php';
			}
		}
	} elseif (is_post_type_archive() && !empty($access_views['archive'])) {
		foreach ($access_views['archive'] as $vval) {
			if (is_post_type_archive($vval['obj']) && !current_user_can('view_' . $vval['name'])) {
				return $fpath . 'includes/no-access.php';
			}
		}
	}
	return $template;
}
