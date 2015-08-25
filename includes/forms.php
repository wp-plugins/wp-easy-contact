<?php
/**
 * Setup and Process submit and search forms
 * @package WP_ECONTACT
 * @version 2.1.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (is_admin()) {
	add_action('wp_ajax_nopriv_emd_check_unique', 'emd_check_unique');
}
add_action('init', 'wp_econtact_form_shortcodes', -2);
/**
 * Start session and setup upload idr and current user id
 * @since WPAS 4.0
 *
 */
function wp_econtact_form_shortcodes() {
	global $file_upload_dir;
	$upload_dir = wp_upload_dir();
	$file_upload_dir = $upload_dir['basedir'];
	if (!session_id() && !headers_sent()) {
		session_start();
	}
}
add_shortcode('contact_submit', 'wp_econtact_process_contact_submit');
/**
 * Set each form field(attr,tax and rels) and render form
 *
 * @since WPAS 4.0
 *
 * @return object $form
 */
function wp_econtact_set_contact_submit() {
	global $file_upload_dir;
	$show_captcha = 0;
	$form_variables = get_option('wp_econtact_glob_forms_list');
	if (!empty($form_variables['contact_submit']['captcha'])) {
		switch ($form_variables['contact_submit']['captcha']) {
			case 'never-show':
				$show_captcha = 0;
			break;
			case 'show-always':
				$show_captcha = 1;
			break;
			case 'show-to-visitors':
				if (is_user_logged_in()) {
					$show_captcha = 0;
				} else {
					$show_captcha = 1;
				}
			break;
		}
	}
	$req_hide_vars = emd_get_form_req_hide_vars('wp_econtact', 'contact_submit');
	require_once WP_ECONTACT_PLUGIN_DIR . '/assets/ext/zebraform/Zebra_Form.php';
	$form = new Zebra_Form('contact_submit', 0, 'POST', '', array(
		'class' => 'form-container wpas-form wpas-form-stacked'
	));
	if (!in_array('emd_contact_first_name', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_first_name', 'emd_contact_first_name', __('First Name', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_first_name', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('First Name', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_first_name', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('First Name is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_last_name', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_last_name', 'emd_contact_last_name', __('Last Name', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_last_name', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Last Name', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_last_name', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Last Name is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_email', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_email', 'emd_contact_email', __('Email', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_email', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Email', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
			'email' => array(
				'error',
				__('Email: Please enter a valid email address', 'wp-econtact')
			) ,
		);
		if (in_array('emd_contact_email', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Email is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_phone', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_phone', 'emd_contact_phone', __('Phone', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_phone', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Phone', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_phone', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Phone is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_address', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_address', 'emd_contact_address', __('Address', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_address', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Address', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_address', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Address is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_city', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_city', 'emd_contact_city', __('City', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_city', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('City', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_city', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('City is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('contact_state', $req_hide_vars['hide'])) {
		$form->add('label', 'label_contact_state', 'contact_state', __('State', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('selectadv', 'contact_state', __('Please Select', 'wp-econtact') , array(
			'class' => 'input-lg'
		) , '', '{"allowClear":true,"placeholder":"' . __("Please Select", "wp-econtact") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_arr[''] = __('Please Select', 'wp-econtact');
		$txn_obj = get_terms('contact_state', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('contact_state', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('State is required!', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('emd_contact_zipcode', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_emd_contact_zipcode', 'emd_contact_zipcode', __('Zip Code', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'emd_contact_zipcode', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Zip Code', 'wp-econtact')
		));
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('emd_contact_zipcode', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Zip Code is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('contact_country', $req_hide_vars['hide'])) {
		$form->add('label', 'label_contact_country', 'contact_country', __('Country', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('selectadv', 'contact_country', __('Please Select', 'wp-econtact') , array(
			'class' => 'input-lg'
		) , '', '{"allowClear":true,"placeholder":"' . __("Please Select", "wp-econtact") . '","placeholderOption":"first"}');
		//get taxonomy values
		$txn_arr = Array();
		$txn_arr[''] = __('Please Select', 'wp-econtact');
		$txn_obj = get_terms('contact_country', array(
			'hide_empty' => 0
		));
		foreach ($txn_obj as $txn) {
			$txn_arr[$txn->slug] = $txn->name;
		}
		$obj->add_options($txn_arr);
		$zrule = Array(
			'dependencies' => array() ,
		);
		if (in_array('contact_country', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Country is required!', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('blt_title', $req_hide_vars['hide'])) {
		//text
		$form->add('label', 'label_blt_title', 'blt_title', __('Subject', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('text', 'blt_title', '', array(
			'class' => 'input-lg form-control',
			'placeholder' => __('Subject', 'wp-econtact')
		));
		$zrule = Array();
		if (in_array('blt_title', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Subject is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	if (!in_array('blt_content', $req_hide_vars['hide'])) {
		//wysiwyg
		$form->add('label', 'label_blt_content', 'blt_content', __('Message', 'wp-econtact') , array(
			'class' => 'control-label'
		));
		$obj = $form->add('wysiwyg', 'blt_content', '', array(
			'placeholder' => __('Enter text ...', 'wp-econtact') ,
			'style' => 'width: 100%; height: 200px',
			'class' => 'wyrj'
		));
		$zrule = Array();
		if (in_array('blt_content', $req_hide_vars['req'])) {
			$zrule = array_merge($zrule, Array(
				'required' => array(
					'error',
					__('Message is required', 'wp-econtact')
				)
			));
		}
		$obj->set_rule($zrule);
	}
	//hidden_func
	$emd_contact_id = emd_get_hidden_func('autoinc');
	$form->add('hidden', 'emd_contact_id', $emd_contact_id);
	//hidden
	$obj = $form->add('hidden', 'wpas_form_name', 'contact_submit');
	//hidden_func
	$wpas_form_submitted_by = emd_get_hidden_func('user_login');
	$form->add('hidden', 'wpas_form_submitted_by', $wpas_form_submitted_by);
	//hidden_func
	$wpas_form_submitted_ip = emd_get_hidden_func('user_ip');
	$form->add('hidden', 'wpas_form_submitted_ip', $wpas_form_submitted_ip);
	$form->assign('show_captcha', $show_captcha);
	if ($show_captcha == 1) {
		//Captcha
		$form->add('captcha', 'captcha_image', 'captcha_code', '', '<span style="font-weight:bold;" class="refresh-txt">Refresh</span>', 'refcapt');
		$form->add('label', 'label_captcha_code', 'captcha_code', __('Please enter the characters with black color.', 'wp-econtact'));
		$obj = $form->add('text', 'captcha_code', '', array(
			'placeholder' => __('Code', 'wp-econtact')
		));
		$obj->set_rule(array(
			'required' => array(
				'error',
				__('Captcha is required', 'wp-econtact')
			) ,
			'captcha' => array(
				'error',
				__('Characters from captcha image entered incorrectly!', 'wp-econtact')
			)
		));
	}
	$form->add('submit', 'singlebutton_contact_submit', '' . __('Send', 'wp-econtact') . ' ', array(
		'class' => 'wpas-button wpas-juibutton-secondary wpas-button-large  col-md-12 col-lg-12 col-xs-12 col-sm-12'
	));
	return $form;
}
/**
 * Process each form and show error or success
 *
 * @since WPAS 4.0
 *
 * @return html
 */
function wp_econtact_process_contact_submit() {
	$show_form = 1;
	$access_views = get_option('wp_econtact_access_views', Array());
	if (!current_user_can('view_contact_submit') && !empty($access_views['forms']) && in_array('contact_submit', $access_views['forms'])) {
		$show_form = 0;
	}
	if ($show_form == 1) {
		wp_enqueue_style('wpasui');
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpas-jvalidate-js');
		wp_enqueue_style('contact-submit-forms');
		wp_enqueue_script('contact-submit-forms-js');
		return emd_submit_php_form('contact_submit', 'wp_econtact', 'emd_contact', 'publish', 'publish', 'Thanks for your submission.', 'There has been an error when submitting your entry. Please contact the site administrator.', 0, 1);
	} else {
		return "<div class='alert alert-info not-authorized'>" . __('You are not allowed to access to this area. Please contact the site administrator.', 'wp-econtact') . "</div>";
	}
}
