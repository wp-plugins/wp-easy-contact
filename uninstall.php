<?php
/**
 *  Uninstall WP Easy Contact
 *
 * Uninstalling deletes notifications and terms initializations
 *
 * @package WP_ECONTACT
 * @version 2.0.0
 * @since WPAS 4.0
 */
if (!defined('WP_UNINSTALL_PLUGIN')) exit;
if (!current_user_can('activate_plugins')) return;
function wp_econtact_uninstall() {
	//delete options
	$options_to_delete = Array(
		'wp_econtact_notify_list',
		'wp_econtact_ent_list',
		'wp_econtact_attr_list',
		'wp_econtact_shc_list',
		'wp_econtact_tax_list',
		'wp_econtact_rel_list',
		'wp_econtact_license_key',
		'wp_econtact_license_status',
		'wp_econtact_comment_list',
		'wp_econtact_access_views',
		'wp_econtact_limitby_auth_caps',
		'wp_econtact_limitby_caps',
		'wp_econtact_has_limitby_cap',
		'wp_econtact_setup_pages',
		'wp_econtact_emd_contact_terms_init'
	);
	if (!empty($options_to_delete)) {
		foreach ($options_to_delete as $option) {
			delete_option($option);
		}
	}
	$emd_activated_plugins = get_option('emd_activated_plugins');
	if (!empty($emd_activated_plugins)) {
		$emd_activated_plugins = array_diff($emd_activated_plugins, Array(
			'wp-econtact'
		));
		update_option('emd_activated_plugins', $emd_activated_plugins);
	}
}
if (is_multisite()) {
	global $wpdb;
	$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
	if ($blogs) {
		foreach ($blogs as $blog) {
			switch_to_blog($blog['blog_id']);
			wp_econtact_uninstall();
		}
		restore_current_blog();
	}
} else {
	wp_econtact_uninstall();
}
