<?php
/**
 * Admin Dashboard Functions
 *
 * @package WP_ECONTACT
 * @version 2.1.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * WP Dashboard setup function
 * @since WPAS 4.0
 *
 */
function wp_econtact_register_dashb_widgets() {
	if (current_user_can('configure_recent_dash_contacts')) {
		wp_add_dashboard_widget('wp_econtact_recent_dash_contacts', __('Recent Contacts', 'wp-econtact') , 'wp_econtact_recent_dash_contacts_dwidget', 'wp_econtact_recent_dash_contacts_dwidget_control');
	} else if (current_user_can('view_recent_dash_contacts')) {
		wp_add_dashboard_widget('wp_econtact_recent_dash_contacts', __('Recent Contacts', 'wp-econtact') , 'wp_econtact_recent_dash_contacts_dwidget', '');
	}
}
add_action('wp_dashboard_setup', 'wp_econtact_register_dashb_widgets');
/**
 * Dashboard entity widget display
 * @since WPAS 4.0
 *
 */
function wp_econtact_recent_dash_contacts_dwidget() {
	$args['has_pages'] = false;
	$args['class'] = 'emd_contact';
	$args['query_args'] = Array(
		'post_type' => 'emd_contact',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'context' => 'wp_econtact_WID_widget',
	);
	$args['fname'] = 'wp_econtact_recent_dash_contacts_layout';
	$args['app'] = 'wp_econtact';
	$args['filter'] = '';
	$args['header'] = '';
	$args['footer'] = '';
	emd_dashboard_widget('wp_econtact_recent_dash_contacts', 'entity', $args);
}
/**
 * Dashboard entity widget control
 * @since WPAS 4.0
 *
 */
function wp_econtact_recent_dash_contacts_dwidget_control() {
	emd_dashboard_widget_control('wp_econtact_recent_dash_contacts', 'Contacts', 'entity');
}
/**
 * Dashboard entity widget layout
 * @since WPAS 4.0
 *
 */
function wp_econtact_recent_dash_contacts_layout() {
	global $post;
	$ent_attrs = get_option('wp_econtact_attr_list');
?>
* <a href="<?php echo get_permalink() ?>" title="<?php echo esc_html(emd_mb_meta('emd_contact_email')) ?>"><?php echo esc_html(emd_mb_meta('emd_contact_first_name')) ?> <?php echo esc_html(emd_mb_meta('emd_contact_last_name')) ?></a> <br>
<?php
}
