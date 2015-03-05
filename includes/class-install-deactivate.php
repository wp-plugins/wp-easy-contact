<?php
/**
 * Install and Deactivate Plugin Functions
 * @package WP_ECONTACT
 * @version 1.0.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (!class_exists('Wp_Econtact_Install_Deactivate')):
	/**
	 * Wp_Econtact_Install_Deactivate Class
	 * @since WPAS 4.0
	 */
	class Wp_Econtact_Install_Deactivate {
		private $option_name;
		/**
		 * Hooks for install and deactivation and create options
		 * @since WPAS 4.0
		 */
		public function __construct() {
			$this->option_name = 'wp_econtact';
			register_activation_hook(WP_ECONTACT_PLUGIN_FILE, array(
				$this,
				'install'
			));
			register_deactivation_hook(WP_ECONTACT_PLUGIN_FILE, array(
				$this,
				'deactivate'
			));
			add_action('admin_init', array(
				$this,
				'setup_pages'
			));
			add_action('admin_notices', array(
				$this,
				'install_notice'
			));
			if (is_admin()) {
				$this->stax = new Emd_Single_Taxonomy('wp-econtact');
			}
			add_filter('tiny_mce_before_init', array(
				$this,
				'tinymce_fix'
			));
		}
		/**
		 * Runs on plugin install to setup custom post types and taxonomies
		 * flushing rewrite rules, populates settings and options
		 * creates roles and assign capabilities
		 * @since WPAS 4.0
		 *
		 */
		public function install() {
			Emd_Contact::register();
			flush_rewrite_rules();
			$this->set_roles_caps();
			$this->set_options();
		}
		/**
		 * Runs on plugin deactivate to remove options, caps and roles
		 * flushing rewrite rules
		 * @since WPAS 4.0
		 *
		 */
		public function deactivate() {
			flush_rewrite_rules();
			$this->remove_caps_roles();
			$this->reset_options();
		}
		/**
		 * Sets caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function set_roles_caps() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'add');
			}
		}
		/**
		 * Removes caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function remove_caps_roles() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'remove');
			}
		}
		/**
		 * Set , reset capabilities
		 *
		 * @since WPAS 4.0
		 * @param object $wp_roles
		 * @param string $type
		 *
		 */
		public function set_reset_caps($wp_roles, $type) {
			$caps['enable'] = Array(
				'manage_contact_tag' => Array(
					'administrator'
				) ,
				'edit_contact_country' => Array(
					'administrator'
				) ,
				'edit_others_emd_contacts' => Array(
					'administrator'
				) ,
				'read_private_emd_contacts' => Array(
					'administrator'
				) ,
				'edit_published_emd_contacts' => Array(
					'administrator'
				) ,
				'view_recent_contacts' => Array(
					'administrator'
				) ,
				'delete_emd_contacts' => Array(
					'administrator'
				) ,
				'manage_contact_state' => Array(
					'administrator'
				) ,
				'delete_published_emd_contacts' => Array(
					'administrator'
				) ,
				'assign_contact_tag' => Array(
					'administrator'
				) ,
				'edit_contact_tag' => Array(
					'administrator'
				) ,
				'edit_private_emd_contacts' => Array(
					'administrator'
				) ,
				'edit_contact_state' => Array(
					'administrator'
				) ,
				'edit_emd_contacts' => Array(
					'administrator'
				) ,
				'assign_contact_state' => Array(
					'administrator'
				) ,
				'assign_contact_country' => Array(
					'administrator'
				) ,
				'edit_dashboard' => Array(
					'administrator'
				) ,
				'delete_contact_state' => Array(
					'administrator'
				) ,
				'view_wp_econtact_dashboard' => Array(
					'administrator'
				) ,
				'publish_emd_contacts' => Array(
					'administrator'
				) ,
				'manage_contact_country' => Array(
					'administrator'
				) ,
				'delete_private_emd_contacts' => Array(
					'administrator'
				) ,
				'delete_others_emd_contacts' => Array(
					'administrator'
				) ,
				'delete_contact_tag' => Array(
					'administrator'
				) ,
				'delete_contact_country' => Array(
					'administrator'
				) ,
				'configure_recent_dash_contacts' => Array(
					'administrator'
				) ,
				'view_recent_dash_contacts' => Array(
					'administrator'
				) ,
			);
			foreach ($caps as $stat => $role_caps) {
				foreach ($role_caps as $mycap => $roles) {
					foreach ($roles as $myrole) {
						if (($type == 'add' && $stat == 'enable') || ($stat == 'disable' && $type == 'remove')) {
							$wp_roles->add_cap($myrole, $mycap);
						} else if (($type == 'remove' && $stat == 'enable') || ($type == 'add' && $stat == 'disable')) {
							$wp_roles->remove_cap($myrole, $mycap);
						}
					}
				}
			}
		}
		/**
		 * Set app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function set_options() {
			update_option($this->option_name . '_setup_pages', 1);
			$access_views['widgets'] = Array(
				'recent_contacts'
			);
			update_option($this->option_name . '_access_views', $access_views);
			$ent_list = Array(
				'emd_contact' => Array(
					'label' => __('Contacts', 'wp-econtact') ,
					'unique_keys' => Array(
						''
					)
				) ,
			);
			update_option($this->option_name . '_ent_list', $ent_list);
			$shc_list['app'] = 'WP Easy Contact';
			$shc_list['forms']['contact_submit'] = Array(
				'name' => 'contact_submit',
				'page_title' => __('Contact Form', 'wp-econtact')
			);
			if (!empty($shc_list)) {
				update_option($this->option_name . '_shc_list', $shc_list);
			}
			$attr_list['emd_contact']['emd_contact_first_name'] = Array(
				'label' => __('First Name', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 1,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_last_name'] = Array(
				'label' => __('Last Name', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 1,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_email'] = Array(
				'label' => __('Email', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 1,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_phone'] = Array(
				'label' => __('Phone', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 0,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_address'] = Array(
				'label' => __('Address', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 0,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_city'] = Array(
				'label' => __('City', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 0,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_zipcode'] = Array(
				'label' => __('Zip Code', 'wp-econtact') ,
				'display_type' => 'text',
				'required' => 0,
				"type" => "char"
			);
			$attr_list['emd_contact']['emd_contact_id'] = Array(
				'label' => __('ID', 'wp-econtact') ,
				'display_type' => 'hidden',
				'required' => 0,
				'autoinc_start' => 1,
				'autoinc_incr' => 1,
				"type" => "char"
			);
			$attr_list['emd_contact']['wpas_form_name'] = Array(
				'label' => __('Form Name', 'wp-econtact') ,
				'display_type' => 'hidden',
				'required' => 0,
				"default" => "admin",
				"type" => "char"
			);
			$attr_list['emd_contact']['wpas_form_submitted_by'] = Array(
				'label' => __('Form Submitted By', 'wp-econtact') ,
				'display_type' => 'hidden',
				'required' => 0,
				"type" => "char"
			);
			$attr_list['emd_contact']['wpas_form_submitted_ip'] = Array(
				'label' => __('Form Submitted IP', 'wp-econtact') ,
				'display_type' => 'hidden',
				'required' => 0,
				"type" => "char"
			);
			if (!empty($attr_list)) {
				update_option($this->option_name . '_attr_list', $attr_list);
			}
			$tax_list['emd_contact']['contact_state'] = Array(
				'label' => __('States', 'wp-econtact') ,
				'default' => '',
				'type' => 'single'
			);
			$tax_list['emd_contact']['contact_country'] = Array(
				'label' => __('Country', 'wp-econtact') ,
				'default' => '',
				'type' => 'single'
			);
			$tax_list['emd_contact']['contact_tag'] = Array(
				'label' => __('Contact Tags', 'wp-econtact') ,
				'default' => '',
				'type' => 'multi'
			);
			if (!empty($tax_list)) {
				update_option($this->option_name . '_tax_list', $tax_list);
			}
			if (!empty($rel_list)) {
				update_option($this->option_name . '_rel_list', $rel_list);
			}
			$emd_activated_plugins = get_option('emd_activated_plugins');
			if (!$emd_activated_plugins) {
				update_option('emd_activated_plugins', Array(
					'wp-econtact'
				));
			} else {
				array_push($emd_activated_plugins, 'wp-econtact');
				update_option('emd_activated_plugins', $emd_activated_plugins);
			}
			//conf parameters for incoming email
			$has_incoming_email = Array(
				'emd_contact' => Array(
					'label' => 'Contacts',
					'status' => 'publish',
					'vis_submit' => 1,
					'vis_status' => 'publish',
					'tax' => 'contact_tag',
					'subject' => 'blt_title',
					'date' => Array(
						'post_date'
					) ,
					'body' => 'emd_blt_content',
					'att' => 'emd_',
					'email' => 'emd_contact_email',
					'name' => Array(
						'emd_contact_first_name',
						'emd_contact_last_name',
					)
				)
			);
			update_option($this->option_name . '_has_incoming_email', $has_incoming_email);
			$emd_inc_email_apps = get_option('emd_inc_email_apps');
			$emd_inc_email_apps[$this->option_name] = $this->option_name . '_inc_email_conf';
			update_option('emd_inc_email_apps', $emd_inc_email_apps);
			//conf parameters for inline entity
			//action to configure different extension conf parameters for this plugin
			do_action('emd_extension_set_conf');
		}
		/**
		 * Reset app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function reset_options() {
			delete_option($this->option_name . '_ent_list');
			delete_option($this->option_name . '_shc_list');
			delete_option($this->option_name . '_attr_list');
			delete_option($this->option_name . '_tax_list');
			delete_option($this->option_name . '_rel_list');
			$users = get_users();
			foreach ($users as $user) {
				delete_user_meta($user->ID, $this->option_name . '_adm_notice1');
			}
			delete_option($this->option_name . '_setup_pages');
			delete_option($this->option_name . '_access_views');
			$emd_activated_plugins = get_option('emd_activated_plugins');
			if (!empty($emd_activated_plugins)) {
				$emd_activated_plugins = array_diff($emd_activated_plugins, Array(
					'wp-econtact'
				));
				update_option('emd_activated_plugins', $emd_activated_plugins);
			}
			$incemail_settings = get_option('emd_inc_email_apps', Array());
			unset($incemail_settings[$this->option_name]);
			update_option('emd_inc_email_apps', $incemail_settings);
			delete_option($this->option_name . '_has_incoming_email');
		}
		/**
		 * Show install notices
		 *
		 * @since WPAS 4.0
		 *
		 * @return html
		 */
		public function install_notice() {
			if (isset($_GET[$this->option_name . '_adm_notice1'])) {
				update_user_meta(get_current_user_id() , $this->option_name . '_adm_notice1', true);
			}
			if (get_user_option($this->option_name . '_adm_notice1') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/?pk_campaign=wpeasycontact&pk_source=plugin&pk_medium=link&pk_content=notice', __('New To WP Easy Contact? Review the documentation!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice1', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (get_option($this->option_name . '_setup_pages') == 1) {
				echo "<div id=\"message\" class=\"updated\"><p><strong>" . __('Welcome to WP Easy Contact', 'wp-econtact') . "</strong></p>
           <p class=\"submit\"><a href=\"" . add_query_arg('setup_wp_econtact_pages', 'true', admin_url('index.php')) . "\" class=\"button-primary\">" . __('Setup WP Easy Contact Pages', 'wp-econtact') . "</a> <a class=\"skip button-primary\" href=\"" . add_query_arg('skip_setup_wp_econtact_pages', 'true', admin_url('index.php')) . "\">" . __('Skip setup', 'wp-econtact') . "</a></p>
         </div>";
			}
		}
		/**
		 * Setup pages for components and redirect to dashboard
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function setup_pages() {
			if (!is_admin()) {
				return;
			}
			global $wpdb;
			if (!empty($_GET['setup_' . $this->option_name . '_pages'])) {
				$shc_list = get_option($this->option_name . '_shc_list');
				$types = Array(
					'forms',
					'charts',
					'shcs',
					'datagrids',
					'integrations'
				);
				foreach ($types as $shc_type) {
					if (!empty($shc_list[$shc_type])) {
						foreach ($shc_list[$shc_type] as $keyshc => $myshc) {
							if (isset($myshc['page_title'])) {
								$pages[$keyshc] = $myshc;
							}
						}
					}
				}
				foreach ($pages as $key => $page) {
					$found = "";
					$page_content = "[" . $key . "]";
					$found = $wpdb->get_var($wpdb->prepare("SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%"));
					if ($found != "") {
						continue;
					}
					$page_data = array(
						'post_status' => 'publish',
						'post_type' => 'page',
						'post_author' => get_current_user_id() ,
						'post_title' => $page['page_title'],
						'post_content' => $page_content,
						'comment_status' => 'closed'
					);
					$page_id = wp_insert_post($page_data);
				}
				delete_option($this->option_name . '_setup_pages');
				wp_redirect(admin_url('index.php?wp-econtact-installed=true'));
				exit;
			}
			if (!empty($_GET['skip_setup_' . $this->option_name . '_pages'])) {
				delete_option($this->option_name . '_setup_pages');
				wp_redirect(admin_url('index.php?'));
				exit;
			}
		}
		public function tinymce_fix($init) {
			$init['wpautop'] = false;
			return $init;
		}
	}
endif;
return new Wp_Econtact_Install_Deactivate();
