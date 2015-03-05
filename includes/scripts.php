<?php
/**
 * Enqueue Scripts Functions
 *
 * @package WP_ECONTACT
 * @version 1.0.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('admin_enqueue_scripts', 'wp_econtact_load_admin_enq');
/**
 * Enqueue style and js for each admin entity pages and settings
 *
 * @since WPAS 4.0
 * @param string $hook
 *
 */
function wp_econtact_load_admin_enq($hook) {
	if ($hook == 'toplevel_page_wp_econtact' || $hook == 'wp-easy-contact_page_wp_econtact_notify') {
		wp_enqueue_script('accordion');
		return;
	} else if (in_array($hook, Array(
		'wp-easy-contact_page_wp_econtact_store',
		'wp-easy-contact_page_wp_econtact_designs',
		'wp-easy-contact_page_wp_econtact_support'
	))) {
		wp_enqueue_style('admin-tabs', WP_ECONTACT_PLUGIN_URL . 'assets/css/admin-store.css');
		return;
	}
	global $post;
	if (isset($post) && in_array($post->post_type, Array(
		'emd_contact'
	))) {
		$theme_changer_enq = 1;
		$datetime_enq = 0;
		$date_enq = 0;
		$sing_enq = 0;
		$tab_enq = 0;
		if ($hook == 'post.php' || $hook == 'post-new.php') {
			$unique_vars['msg'] = __('Please enter a unique value.', 'emd-plugins');
			wp_enqueue_script('unique_validate-js', WP_ECONTACT_PLUGIN_URL . 'assets/js/unique_validate.js', array(
				'jquery',
				'jquery-validate'
			) , WP_ECONTACT_VERSION, true);
			wp_localize_script("unique_validate-js", 'unique_vars', $unique_vars);
		}
		switch ($post->post_type) {
			case 'emd_contact':
				$sing_enq = 1;
			break;
		}
		if ($datetime_enq == 1) {
			wp_enqueue_script("jquery-ui-timepicker", WP_ECONTACT_PLUGIN_URL . 'assets/ext/emd-meta-box/js/jqueryui/jquery-ui-timepicker-addon.js', array(
				'jquery-ui-datepicker',
				'jquery-ui-slider'
			) , WP_ECONTACT_VERSION, true);
			$tab_enq = 1;
		} elseif ($date_enq == 1) {
			wp_enqueue_script("jquery-ui-datepicker");
			$tab_enq = 1;
		}
		if ($sing_enq == 1) {
			wp_enqueue_script('radiotax', WP_ECONTACT_PLUGIN_URL . 'includes/admin/singletax/singletax.js', array(
				'jquery'
			) , WP_ECONTACT_VERSION, true);
		}
	}
}
add_action('wp_enqueue_scripts', 'wp_econtact_frontend_scripts');
/**
 * Enqueue style and js for each frontend entity pages and components
 *
 * @since WPAS 4.0
 *
 */
function wp_econtact_frontend_scripts() {
	$dir_url = WP_ECONTACT_PLUGIN_URL;
	if (is_page()) {
		$grid_vars = Array();
		$local_vars['ajax_url'] = admin_url('admin-ajax.php');
		$local_vars['validate_msg']['required'] = __('This field is required.', 'emd-plugins');
		$local_vars['validate_msg']['remote'] = __('Please fix this field.', 'emd-plugins');
		$local_vars['validate_msg']['email'] = __('Please enter a valid email address.', 'emd-plugins');
		$local_vars['validate_msg']['url'] = __('Please enter a valid URL.', 'emd-plugins');
		$local_vars['validate_msg']['date'] = __('Please enter a valid date.', 'emd-plugins');
		$local_vars['validate_msg']['dateISO'] = __('Please enter a valid date ( ISO )', 'emd-plugins');
		$local_vars['validate_msg']['number'] = __('Please enter a valid number.', 'emd-plugins');
		$local_vars['validate_msg']['digits'] = __('Please enter only digits.', 'emd-plugins');
		$local_vars['validate_msg']['creditcard'] = __('Please enter a valid credit card number.', 'emd-plugins');
		$local_vars['validate_msg']['equalTo'] = __('Please enter the same value again.', 'emd-plugins');
		$local_vars['validate_msg']['maxlength'] = __('Please enter no more than {0} characters.', 'emd-plugins');
		$local_vars['validate_msg']['minlength'] = __('Please enter at least {0} characters.', 'emd-plugins');
		$local_vars['validate_msg']['rangelength'] = __('Please enter a value between {0} and {1} characters long.', 'emd-plugins');
		$local_vars['validate_msg']['range'] = __('Please enter a value between {0} and {1}.', 'emd-plugins');
		$local_vars['validate_msg']['max'] = __('Please enter a value less than or equal to {0}.', 'emd-plugins');
		$local_vars['validate_msg']['min'] = __('Please enter a value greater than or equal to {0}.', 'emd-plugins');
		$local_vars['unique_msg'] = __('Please enter a unique value.', 'emd-plugins');
		$wpas_shc_list = get_option('wp_econtact_shc_list');
		$check_content = "";
		if (!is_author() && !is_tax()) {
			$check_content = get_post(get_the_ID())->post_content;
		}
		if (!empty($check_content) && has_shortcode($check_content, 'contact_submit')) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('jvalidate-js', $dir_url . 'assets/ext/jvalidate1111/wpas.validate.min.js', array(
				'jquery'
			));
			wp_enqueue_style('wpasui', WP_ECONTACT_PLUGIN_URL . 'assets/ext/wpas-jui/wpas-jui.min.css');
			wp_enqueue_style('contact-submit-forms', $dir_url . 'assets/css/contact-submit-forms.css');
			wp_enqueue_script('contact-submit-forms-js', $dir_url . 'assets/js/contact-submit-forms.js');
			wp_localize_script('contact-submit-forms-js', 'contact_submit_vars', $local_vars);
		}
		return;
	}
	if (is_single() && get_post_type() == 'emd_contact') {
		wp_enqueue_style("wp-econtact-default-single-css", WP_ECONTACT_PLUGIN_URL . 'assets/css/wp-econtact-default-single.css');
	}
}
