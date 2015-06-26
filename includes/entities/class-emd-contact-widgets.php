<?php
/**
 * Entity Widget Classes
 *
 * @package WP_ECONTACT
 * @version 2.0.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Entity widget class extends Emd_Widget class
 *
 * @since WPAS 4.0
 */
class wp_econtact_recent_contacts_widget extends Emd_Widget {
	public $title;
	public $text_domain = 'wp-econtact';
	public $class_label;
	public $class = 'emd_contact';
	public $type = 'entity';
	public $has_pages = false;
	public $css_label = 'recent-contacts';
	public $id = 'wp_econtact_recent_contacts_widget';
	public $query_args = array(
		'post_type' => 'emd_contact',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC'
	);
	public $filter = '';
	/**
	 * Instantiate entity widget class with params
	 *
	 * @since WPAS 4.0
	 */
	function wp_econtact_recent_contacts_widget() {
		$this->Emd_Widget(__('Recent Contacts', 'wp-econtact') , __('Contacts', 'wp-econtact') , __('The most recent contacts', 'wp-econtact'));
	}
	/**
	 * Returns widget layout
	 *
	 * @since WPAS 4.0
	 */
	public static function layout() {
		global $post;
		$layout = "<a href=\"" . get_permalink() . "\" title=\"" . esc_html(emd_mb_meta('emd_contact_email')) . "\">" . esc_html(emd_mb_meta('emd_contact_first_name')) . " " . esc_html(emd_mb_meta('emd_contact_last_name')) . "</a>";
		return $layout;
	}
}
$access_views = get_option('wp_econtact_access_views', Array());
if (empty($access_views['widgets']) || (!empty($access_views['widgets']) && in_array('recent_contacts', $access_views['widgets']) && current_user_can('view_recent_contacts'))) {
	register_widget('wp_econtact_recent_contacts_widget');
}
