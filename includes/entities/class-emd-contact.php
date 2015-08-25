<?php
/**
 * Entity Class
 *
 * @package WP_ECONTACT
 * @version 2.1.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Emd_Contact Class
 * @since WPAS 4.0
 */
class Emd_Contact extends Emd_Entity {
	protected $post_type = 'emd_contact';
	protected $textdomain = 'wp-econtact';
	protected $sing_label;
	protected $plural_label;
	protected $menu_entity;
	/**
	 * Initialize entity class
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function __construct() {
		add_action('init', array(
			$this,
			'set_filters'
		));
		add_action('admin_init', array(
			$this,
			'set_metabox'
		));
		add_filter('post_updated_messages', array(
			$this,
			'updated_messages'
		));
		add_action('manage_emd_contact_posts_custom_column', array(
			$this,
			'custom_columns'
		) , 10, 2);
		add_filter('manage_emd_contact_posts_columns', array(
			$this,
			'column_headers'
		));
	}
	/**
	 * Get column header list in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param array $columns
	 *
	 * @return array $columns
	 */
	public function column_headers($columns) {
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if (!in_array($fkey, Array(
					'wpas_form_name',
					'wpas_form_submitted_by',
					'wpas_form_submitted_ip'
				)) && !in_array($mybox_field['type'], Array(
					'textarea',
					'wysiwyg'
				)) && $mybox_field['list_visible'] == 1) {
					$columns[$fkey] = $mybox_field['name'];
				}
			}
		}
		$args = array(
			'_builtin' => false,
			'object_type' => Array(
				$this->post_type
			)
		);
		$taxonomies = get_taxonomies($args, 'objects');
		if (!empty($taxonomies)) {
			foreach ($taxonomies as $taxonomy) {
				$columns[$taxonomy->name] = $taxonomy->label;
			}
		}
		return $columns;
	}
	/**
	 * Get custom column values in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param int $column_id
	 * @param int $post_id
	 *
	 * @return string $value
	 */
	public function custom_columns($column_id, $post_id) {
		if (taxonomy_exists($column_id) == true) {
			$terms = get_the_terms($post_id, $column_id);
			$ret = array();
			if (!empty($terms)) {
				foreach ($terms as $term) {
					$url = add_query_arg(array(
						'post_type' => $this->post_type,
						'term' => $term->slug,
						'taxonomy' => $column_id
					) , admin_url('edit.php'));
					$a_class = preg_replace('/^emd_/', '', $this->post_type);
					$ret[] = sprintf('<a href="%s"  class="' . $a_class . '-tax ' . $term->slug . '">%s</a>', $url, $term->name);
				}
			}
			echo implode(', ', $ret);
			return;
		}
		$value = get_post_meta($post_id, $column_id, true);
		$type = "";
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if ($fkey == $column_id) {
					$type = $mybox_field['type'];
					break;
				}
			}
		}
		switch ($type) {
			case 'plupload_image':
			case 'image':
			case 'thickbox_image':
				$image_list = emd_mb_meta($column_id, 'type=image');
				if (!empty($image_list)) {
					$value = "";
					foreach ($image_list as $myimage) {
						$value.= "<img style='max-width:100%;height:auto;' src='" . $myimage['url'] . "' >";
					}
				}
			break;
			case 'user':
			case 'user-adv':
				$user_id = emd_mb_meta($column_id);
				if (!empty($user_id)) {
					$user_info = get_userdata($user_id);
					$value = $user_info->display_name;
				}
			break;
			case 'file':
				$file_list = emd_mb_meta($column_id, 'type=file');
				if (!empty($file_list)) {
					$value = "";
					foreach ($file_list as $myfile) {
						$fsrc = wp_mime_type_icon($myfile['ID']);
						$value.= "<a href='" . $myfile['url'] . "' target='_blank'><img src='" . $fsrc . "' title='" . $myfile['name'] . "' width='20' /></a>";
					}
				}
			break;
			case 'checkbox_list':
				$checkbox_list = emd_mb_meta($column_id, 'type=checkbox_list');
				if (!empty($checkbox_list)) {
					$value = implode(', ', $checkbox_list);
				}
			break;
			case 'select':
			case 'select_advanced':
				$select_list = get_post_meta($post_id, $column_id, false);
				if (!empty($select_list)) {
					$value = implode(', ', $select_list);
				}
			break;
			case 'checkbox':
				if ($value == 1) {
					$value = '<span class="dashicons dashicons-yes"></span>';
				} elseif ($value == 0) {
					$value = '<span class="dashicons dashicons-no-alt"></span>';
				}
			break;
		}
		echo $value;
	}
	/**
	 * Register post type and taxonomies and set initial values for taxs
	 *
	 * @since WPAS 4.0
	 *
	 */
	public static function register() {
		$labels = array(
			'name' => __('Contacts', 'wp-econtact') ,
			'singular_name' => __('Contact', 'wp-econtact') ,
			'add_new' => __('Add New', 'wp-econtact') ,
			'add_new_item' => __('Add New Contact', 'wp-econtact') ,
			'edit_item' => __('Edit Contact', 'wp-econtact') ,
			'new_item' => __('New Contact', 'wp-econtact') ,
			'all_items' => __('All Contacts', 'wp-econtact') ,
			'view_item' => __('View Contact', 'wp-econtact') ,
			'search_items' => __('Search Contacts', 'wp-econtact') ,
			'not_found' => __('No Contacts Found', 'wp-econtact') ,
			'not_found_in_trash' => __('No Contacts Found In Trash', 'wp-econtact') ,
			'menu_name' => __('Contacts', 'wp-econtact') ,
		);
		register_post_type('emd_contact', array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'description' => __('', 'wp-econtact') ,
			'show_in_menu' => true,
			'menu_position' => 6,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array(
				'slug' => 'contacts'
			) ,
			'can_export' => true,
			'hierarchical' => false,
			'menu_icon' => 'dashicons-groups',
			'map_meta_cap' => 'true',
			'taxonomies' => array() ,
			'capability_type' => 'emd_contact',
			'supports' => array(
				'title',
				'editor',
			)
		));
		$contact_state_nohr_labels = array(
			'name' => __('States', 'wp-econtact') ,
			'singular_name' => __('State', 'wp-econtact') ,
			'search_items' => __('Search States', 'wp-econtact') ,
			'popular_items' => __('Popular States', 'wp-econtact') ,
			'all_items' => __('All', 'wp-econtact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit State', 'wp-econtact') ,
			'update_item' => __('Update State', 'wp-econtact') ,
			'add_new_item' => __('Add New State', 'wp-econtact') ,
			'new_item_name' => __('Add New State Name', 'wp-econtact') ,
			'separate_items_with_commas' => __('Seperate States with commas', 'wp-econtact') ,
			'add_or_remove_items' => __('Add or Remove States', 'wp-econtact') ,
			'choose_from_most_used' => __('Choose from the most used States', 'wp-econtact') ,
			'menu_name' => __('States', 'wp-econtact') ,
		);
		register_taxonomy('contact_state', array(
			'emd_contact'
		) , array(
			'hierarchical' => false,
			'labels' => $contact_state_nohr_labels,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_tagcloud' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'contact_state'
			) ,
			'capabilities' => array(
				'manage_terms' => 'manage_contact_state',
				'edit_terms' => 'edit_contact_state',
				'delete_terms' => 'delete_contact_state',
				'assign_terms' => 'assign_contact_state'
			) ,
		));
		$contact_country_nohr_labels = array(
			'name' => __('Countries', 'wp-econtact') ,
			'singular_name' => __('Country', 'wp-econtact') ,
			'search_items' => __('Search Countries', 'wp-econtact') ,
			'popular_items' => __('Popular Countries', 'wp-econtact') ,
			'all_items' => __('All', 'wp-econtact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit Country', 'wp-econtact') ,
			'update_item' => __('Update Country', 'wp-econtact') ,
			'add_new_item' => __('Add New Country', 'wp-econtact') ,
			'new_item_name' => __('Add New Country Name', 'wp-econtact') ,
			'separate_items_with_commas' => __('Seperate Countries with commas', 'wp-econtact') ,
			'add_or_remove_items' => __('Add or Remove Countries', 'wp-econtact') ,
			'choose_from_most_used' => __('Choose from the most used Countries', 'wp-econtact') ,
			'menu_name' => __('Countries', 'wp-econtact') ,
		);
		register_taxonomy('contact_country', array(
			'emd_contact'
		) , array(
			'hierarchical' => false,
			'labels' => $contact_country_nohr_labels,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_tagcloud' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'contact_country'
			) ,
			'capabilities' => array(
				'manage_terms' => 'manage_contact_country',
				'edit_terms' => 'edit_contact_country',
				'delete_terms' => 'delete_contact_country',
				'assign_terms' => 'assign_contact_country'
			) ,
		));
		$contact_tag_nohr_labels = array(
			'name' => __('Contact Tags', 'wp-econtact') ,
			'singular_name' => __('Contact Tag', 'wp-econtact') ,
			'search_items' => __('Search Contact Tags', 'wp-econtact') ,
			'popular_items' => __('Popular Contact Tags', 'wp-econtact') ,
			'all_items' => __('All', 'wp-econtact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit Contact Tag', 'wp-econtact') ,
			'update_item' => __('Update Contact Tag', 'wp-econtact') ,
			'add_new_item' => __('Add New Contact Tag', 'wp-econtact') ,
			'new_item_name' => __('Add New Contact Tag Name', 'wp-econtact') ,
			'separate_items_with_commas' => __('Seperate Contact Tags with commas', 'wp-econtact') ,
			'add_or_remove_items' => __('Add or Remove Contact Tags', 'wp-econtact') ,
			'choose_from_most_used' => __('Choose from the most used Contact Tags', 'wp-econtact') ,
			'menu_name' => __('Contact Tags', 'wp-econtact') ,
		);
		register_taxonomy('contact_tag', array(
			'emd_contact'
		) , array(
			'hierarchical' => false,
			'labels' => $contact_tag_nohr_labels,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_tagcloud' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'contact_tag'
			) ,
			'capabilities' => array(
				'manage_terms' => 'manage_contact_tag',
				'edit_terms' => 'edit_contact_tag',
				'delete_terms' => 'delete_contact_tag',
				'assign_terms' => 'assign_contact_tag'
			) ,
		));
		if (!get_option('wp_econtact_emd_contact_terms_init')) {
			$set_tax_terms = Array(
				Array(
					'name' => __('AL', 'wp-econtact') ,
					'slug' => sanitize_title('AL') ,
					'desc' => __('Alabama', 'wp-econtact')
				) ,
				Array(
					'name' => __('AK', 'wp-econtact') ,
					'slug' => sanitize_title('AK') ,
					'desc' => __('Alaska', 'wp-econtact')
				) ,
				Array(
					'name' => __('AZ', 'wp-econtact') ,
					'slug' => sanitize_title('AZ') ,
					'desc' => __('Arizona', 'wp-econtact')
				) ,
				Array(
					'name' => __('AR', 'wp-econtact') ,
					'slug' => sanitize_title('AR') ,
					'desc' => __('Arkansas', 'wp-econtact')
				) ,
				Array(
					'name' => __('CA', 'wp-econtact') ,
					'slug' => sanitize_title('CA') ,
					'desc' => __('California', 'wp-econtact')
				) ,
				Array(
					'name' => __('CO', 'wp-econtact') ,
					'slug' => sanitize_title('CO') ,
					'desc' => __('Colorado', 'wp-econtact')
				) ,
				Array(
					'name' => __('CT', 'wp-econtact') ,
					'slug' => sanitize_title('CT') ,
					'desc' => __('Connecticut', 'wp-econtact')
				) ,
				Array(
					'name' => __('DE', 'wp-econtact') ,
					'slug' => sanitize_title('DE') ,
					'desc' => __('Delaware', 'wp-econtact')
				) ,
				Array(
					'name' => __('DC', 'wp-econtact') ,
					'slug' => sanitize_title('DC') ,
					'desc' => __('District of Columbia', 'wp-econtact')
				) ,
				Array(
					'name' => __('FL', 'wp-econtact') ,
					'slug' => sanitize_title('FL') ,
					'desc' => __('Florida', 'wp-econtact')
				) ,
				Array(
					'name' => __('GA', 'wp-econtact') ,
					'slug' => sanitize_title('GA') ,
					'desc' => __('Georgia', 'wp-econtact')
				) ,
				Array(
					'name' => __('HI', 'wp-econtact') ,
					'slug' => sanitize_title('HI') ,
					'desc' => __('Hawaii', 'wp-econtact')
				) ,
				Array(
					'name' => __('ID', 'wp-econtact') ,
					'slug' => sanitize_title('ID') ,
					'desc' => __('Idaho', 'wp-econtact')
				) ,
				Array(
					'name' => __('IL', 'wp-econtact') ,
					'slug' => sanitize_title('IL') ,
					'desc' => __('Illinois', 'wp-econtact')
				) ,
				Array(
					'name' => __('IN', 'wp-econtact') ,
					'slug' => sanitize_title('IN') ,
					'desc' => __('Indiana', 'wp-econtact')
				) ,
				Array(
					'name' => __('IA', 'wp-econtact') ,
					'slug' => sanitize_title('IA') ,
					'desc' => __('Iowa', 'wp-econtact')
				) ,
				Array(
					'name' => __('KS', 'wp-econtact') ,
					'slug' => sanitize_title('KS') ,
					'desc' => __('Kansas', 'wp-econtact')
				) ,
				Array(
					'name' => __('KY', 'wp-econtact') ,
					'slug' => sanitize_title('KY') ,
					'desc' => __('Kentucky', 'wp-econtact')
				) ,
				Array(
					'name' => __('LA', 'wp-econtact') ,
					'slug' => sanitize_title('LA') ,
					'desc' => __('Louisiana', 'wp-econtact')
				) ,
				Array(
					'name' => __('ME', 'wp-econtact') ,
					'slug' => sanitize_title('ME') ,
					'desc' => __('Maine', 'wp-econtact')
				) ,
				Array(
					'name' => __('MD', 'wp-econtact') ,
					'slug' => sanitize_title('MD') ,
					'desc' => __('Maryland', 'wp-econtact')
				) ,
				Array(
					'name' => __('MA', 'wp-econtact') ,
					'slug' => sanitize_title('MA') ,
					'desc' => __('Massachusetts', 'wp-econtact')
				) ,
				Array(
					'name' => __('MI', 'wp-econtact') ,
					'slug' => sanitize_title('MI') ,
					'desc' => __('Michigan', 'wp-econtact')
				) ,
				Array(
					'name' => __('MN', 'wp-econtact') ,
					'slug' => sanitize_title('MN') ,
					'desc' => __('Minnesota', 'wp-econtact')
				) ,
				Array(
					'name' => __('MS', 'wp-econtact') ,
					'slug' => sanitize_title('MS') ,
					'desc' => __('Mississippi', 'wp-econtact')
				) ,
				Array(
					'name' => __('MO', 'wp-econtact') ,
					'slug' => sanitize_title('MO') ,
					'desc' => __('Missouri', 'wp-econtact')
				) ,
				Array(
					'name' => __('MT', 'wp-econtact') ,
					'slug' => sanitize_title('MT') ,
					'desc' => __('Montana', 'wp-econtact')
				) ,
				Array(
					'name' => __('NE', 'wp-econtact') ,
					'slug' => sanitize_title('NE') ,
					'desc' => __('Nebraska', 'wp-econtact')
				) ,
				Array(
					'name' => __('NV', 'wp-econtact') ,
					'slug' => sanitize_title('NV') ,
					'desc' => __('Nevada', 'wp-econtact')
				) ,
				Array(
					'name' => __('NH', 'wp-econtact') ,
					'slug' => sanitize_title('NH') ,
					'desc' => __('New Hampshire', 'wp-econtact')
				) ,
				Array(
					'name' => __('NJ', 'wp-econtact') ,
					'slug' => sanitize_title('NJ') ,
					'desc' => __('New Jersey', 'wp-econtact')
				) ,
				Array(
					'name' => __('NM', 'wp-econtact') ,
					'slug' => sanitize_title('NM') ,
					'desc' => __('New Mexico', 'wp-econtact')
				) ,
				Array(
					'name' => __('NY', 'wp-econtact') ,
					'slug' => sanitize_title('NY') ,
					'desc' => __('New York', 'wp-econtact')
				) ,
				Array(
					'name' => __('NC', 'wp-econtact') ,
					'slug' => sanitize_title('NC') ,
					'desc' => __('North Carolina', 'wp-econtact')
				) ,
				Array(
					'name' => __('ND', 'wp-econtact') ,
					'slug' => sanitize_title('ND') ,
					'desc' => __('North Dakota', 'wp-econtact')
				) ,
				Array(
					'name' => __('OH', 'wp-econtact') ,
					'slug' => sanitize_title('OH') ,
					'desc' => __('Ohio', 'wp-econtact')
				) ,
				Array(
					'name' => __('OK', 'wp-econtact') ,
					'slug' => sanitize_title('OK') ,
					'desc' => __('Oklahoma', 'wp-econtact')
				) ,
				Array(
					'name' => __('OR', 'wp-econtact') ,
					'slug' => sanitize_title('OR') ,
					'desc' => __('Oregon', 'wp-econtact')
				) ,
				Array(
					'name' => __('PA', 'wp-econtact') ,
					'slug' => sanitize_title('PA') ,
					'desc' => __('Pennsylvania', 'wp-econtact')
				) ,
				Array(
					'name' => __('RI', 'wp-econtact') ,
					'slug' => sanitize_title('RI') ,
					'desc' => __('Rhode Island', 'wp-econtact')
				) ,
				Array(
					'name' => __('SC', 'wp-econtact') ,
					'slug' => sanitize_title('SC') ,
					'desc' => __('South Carolina', 'wp-econtact')
				) ,
				Array(
					'name' => __('SD', 'wp-econtact') ,
					'slug' => sanitize_title('SD') ,
					'desc' => __('South Dakota', 'wp-econtact')
				) ,
				Array(
					'name' => __('TN', 'wp-econtact') ,
					'slug' => sanitize_title('TN') ,
					'desc' => __('Tennessee', 'wp-econtact')
				) ,
				Array(
					'name' => __('TX', 'wp-econtact') ,
					'slug' => sanitize_title('TX') ,
					'desc' => __('Texas', 'wp-econtact')
				) ,
				Array(
					'name' => __('UT', 'wp-econtact') ,
					'slug' => sanitize_title('UT') ,
					'desc' => __('Utah', 'wp-econtact')
				) ,
				Array(
					'name' => __('VT', 'wp-econtact') ,
					'slug' => sanitize_title('VT') ,
					'desc' => __('Vermont', 'wp-econtact')
				) ,
				Array(
					'name' => __('VA', 'wp-econtact') ,
					'slug' => sanitize_title('VA') ,
					'desc' => __('Virginia', 'wp-econtact')
				) ,
				Array(
					'name' => __('WA', 'wp-econtact') ,
					'slug' => sanitize_title('WA') ,
					'desc' => __('Washington', 'wp-econtact')
				) ,
				Array(
					'name' => __('WV', 'wp-econtact') ,
					'slug' => sanitize_title('WV') ,
					'desc' => __('West Virginia', 'wp-econtact')
				) ,
				Array(
					'name' => __('WI', 'wp-econtact') ,
					'slug' => sanitize_title('WI') ,
					'desc' => __('Wisconsin', 'wp-econtact')
				) ,
				Array(
					'name' => __('WY', 'wp-econtact') ,
					'slug' => sanitize_title('WY') ,
					'desc' => __('Wyoming', 'wp-econtact')
				)
			);
			self::set_taxonomy_init($set_tax_terms, 'contact_state');
			$set_tax_terms = Array(
				Array(
					'name' => __('Afghanistan', 'wp-econtact') ,
					'slug' => sanitize_title('Afghanistan')
				) ,
				Array(
					'name' => __('Åland Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Åland Islands')
				) ,
				Array(
					'name' => __('Albania', 'wp-econtact') ,
					'slug' => sanitize_title('Albania')
				) ,
				Array(
					'name' => __('Algeria', 'wp-econtact') ,
					'slug' => sanitize_title('Algeria')
				) ,
				Array(
					'name' => __('American Samoa', 'wp-econtact') ,
					'slug' => sanitize_title('American Samoa')
				) ,
				Array(
					'name' => __('Andorra', 'wp-econtact') ,
					'slug' => sanitize_title('Andorra')
				) ,
				Array(
					'name' => __('Angola', 'wp-econtact') ,
					'slug' => sanitize_title('Angola')
				) ,
				Array(
					'name' => __('Anguilla', 'wp-econtact') ,
					'slug' => sanitize_title('Anguilla')
				) ,
				Array(
					'name' => __('Antarctica', 'wp-econtact') ,
					'slug' => sanitize_title('Antarctica')
				) ,
				Array(
					'name' => __('Antigua And Barbuda', 'wp-econtact') ,
					'slug' => sanitize_title('Antigua And Barbuda')
				) ,
				Array(
					'name' => __('Argentina', 'wp-econtact') ,
					'slug' => sanitize_title('Argentina')
				) ,
				Array(
					'name' => __('Armenia', 'wp-econtact') ,
					'slug' => sanitize_title('Armenia')
				) ,
				Array(
					'name' => __('Aruba', 'wp-econtact') ,
					'slug' => sanitize_title('Aruba')
				) ,
				Array(
					'name' => __('Australia', 'wp-econtact') ,
					'slug' => sanitize_title('Australia')
				) ,
				Array(
					'name' => __('Austria', 'wp-econtact') ,
					'slug' => sanitize_title('Austria')
				) ,
				Array(
					'name' => __('Azerbaijan', 'wp-econtact') ,
					'slug' => sanitize_title('Azerbaijan')
				) ,
				Array(
					'name' => __('Bahamas', 'wp-econtact') ,
					'slug' => sanitize_title('Bahamas')
				) ,
				Array(
					'name' => __('Bahrain', 'wp-econtact') ,
					'slug' => sanitize_title('Bahrain')
				) ,
				Array(
					'name' => __('Bangladesh', 'wp-econtact') ,
					'slug' => sanitize_title('Bangladesh')
				) ,
				Array(
					'name' => __('Barbados', 'wp-econtact') ,
					'slug' => sanitize_title('Barbados')
				) ,
				Array(
					'name' => __('Belarus', 'wp-econtact') ,
					'slug' => sanitize_title('Belarus')
				) ,
				Array(
					'name' => __('Belgium', 'wp-econtact') ,
					'slug' => sanitize_title('Belgium')
				) ,
				Array(
					'name' => __('Belize', 'wp-econtact') ,
					'slug' => sanitize_title('Belize')
				) ,
				Array(
					'name' => __('Benin', 'wp-econtact') ,
					'slug' => sanitize_title('Benin')
				) ,
				Array(
					'name' => __('Bermuda', 'wp-econtact') ,
					'slug' => sanitize_title('Bermuda')
				) ,
				Array(
					'name' => __('Bhutan', 'wp-econtact') ,
					'slug' => sanitize_title('Bhutan')
				) ,
				Array(
					'name' => __('Bolivia', 'wp-econtact') ,
					'slug' => sanitize_title('Bolivia')
				) ,
				Array(
					'name' => __('Bosnia And Herzegovina', 'wp-econtact') ,
					'slug' => sanitize_title('Bosnia And Herzegovina')
				) ,
				Array(
					'name' => __('Botswana', 'wp-econtact') ,
					'slug' => sanitize_title('Botswana')
				) ,
				Array(
					'name' => __('Bouvet Island', 'wp-econtact') ,
					'slug' => sanitize_title('Bouvet Island')
				) ,
				Array(
					'name' => __('Brazil', 'wp-econtact') ,
					'slug' => sanitize_title('Brazil')
				) ,
				Array(
					'name' => __('British Indian Ocean Territory', 'wp-econtact') ,
					'slug' => sanitize_title('British Indian Ocean Territory')
				) ,
				Array(
					'name' => __('Brunei Darussalam', 'wp-econtact') ,
					'slug' => sanitize_title('Brunei Darussalam')
				) ,
				Array(
					'name' => __('Bulgaria', 'wp-econtact') ,
					'slug' => sanitize_title('Bulgaria')
				) ,
				Array(
					'name' => __('Burkina Faso', 'wp-econtact') ,
					'slug' => sanitize_title('Burkina Faso')
				) ,
				Array(
					'name' => __('Burundi', 'wp-econtact') ,
					'slug' => sanitize_title('Burundi')
				) ,
				Array(
					'name' => __('Cambodia', 'wp-econtact') ,
					'slug' => sanitize_title('Cambodia')
				) ,
				Array(
					'name' => __('Cameroon', 'wp-econtact') ,
					'slug' => sanitize_title('Cameroon')
				) ,
				Array(
					'name' => __('Canada', 'wp-econtact') ,
					'slug' => sanitize_title('Canada')
				) ,
				Array(
					'name' => __('Cape Verde', 'wp-econtact') ,
					'slug' => sanitize_title('Cape Verde')
				) ,
				Array(
					'name' => __('Cayman Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Cayman Islands')
				) ,
				Array(
					'name' => __('Central African Republic', 'wp-econtact') ,
					'slug' => sanitize_title('Central African Republic')
				) ,
				Array(
					'name' => __('Chad', 'wp-econtact') ,
					'slug' => sanitize_title('Chad')
				) ,
				Array(
					'name' => __('Chile', 'wp-econtact') ,
					'slug' => sanitize_title('Chile')
				) ,
				Array(
					'name' => __('China', 'wp-econtact') ,
					'slug' => sanitize_title('China')
				) ,
				Array(
					'name' => __('Christmas Island', 'wp-econtact') ,
					'slug' => sanitize_title('Christmas Island')
				) ,
				Array(
					'name' => __('Cocos (Keeling) Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Cocos (Keeling) Islands')
				) ,
				Array(
					'name' => __('Colombia', 'wp-econtact') ,
					'slug' => sanitize_title('Colombia')
				) ,
				Array(
					'name' => __('Comoros', 'wp-econtact') ,
					'slug' => sanitize_title('Comoros')
				) ,
				Array(
					'name' => __('Congo', 'wp-econtact') ,
					'slug' => sanitize_title('Congo')
				) ,
				Array(
					'name' => __('Congo, The Democratic Republic Of The', 'wp-econtact') ,
					'slug' => sanitize_title('Congo, The Democratic Republic Of The')
				) ,
				Array(
					'name' => __('Cook Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Cook Islands')
				) ,
				Array(
					'name' => __('Costa Rica', 'wp-econtact') ,
					'slug' => sanitize_title('Costa Rica')
				) ,
				Array(
					'name' => __('Cote D\'ivoire', 'wp-econtact') ,
					'slug' => sanitize_title('Cote D\'ivoire')
				) ,
				Array(
					'name' => __('Croatia', 'wp-econtact') ,
					'slug' => sanitize_title('Croatia')
				) ,
				Array(
					'name' => __('Cuba', 'wp-econtact') ,
					'slug' => sanitize_title('Cuba')
				) ,
				Array(
					'name' => __('Cyprus', 'wp-econtact') ,
					'slug' => sanitize_title('Cyprus')
				) ,
				Array(
					'name' => __('Czech Republic', 'wp-econtact') ,
					'slug' => sanitize_title('Czech Republic')
				) ,
				Array(
					'name' => __('Denmark', 'wp-econtact') ,
					'slug' => sanitize_title('Denmark')
				) ,
				Array(
					'name' => __('Djibouti', 'wp-econtact') ,
					'slug' => sanitize_title('Djibouti')
				) ,
				Array(
					'name' => __('Dominica', 'wp-econtact') ,
					'slug' => sanitize_title('Dominica')
				) ,
				Array(
					'name' => __('Dominican Republic', 'wp-econtact') ,
					'slug' => sanitize_title('Dominican Republic')
				) ,
				Array(
					'name' => __('Ecuador', 'wp-econtact') ,
					'slug' => sanitize_title('Ecuador')
				) ,
				Array(
					'name' => __('Egypt', 'wp-econtact') ,
					'slug' => sanitize_title('Egypt')
				) ,
				Array(
					'name' => __('El Salvador', 'wp-econtact') ,
					'slug' => sanitize_title('El Salvador')
				) ,
				Array(
					'name' => __('Equatorial Guinea', 'wp-econtact') ,
					'slug' => sanitize_title('Equatorial Guinea')
				) ,
				Array(
					'name' => __('Eritrea', 'wp-econtact') ,
					'slug' => sanitize_title('Eritrea')
				) ,
				Array(
					'name' => __('Estonia', 'wp-econtact') ,
					'slug' => sanitize_title('Estonia')
				) ,
				Array(
					'name' => __('Ethiopia', 'wp-econtact') ,
					'slug' => sanitize_title('Ethiopia')
				) ,
				Array(
					'name' => __('Falkland Islands (Malvinas)', 'wp-econtact') ,
					'slug' => sanitize_title('Falkland Islands (Malvinas)')
				) ,
				Array(
					'name' => __('Faroe Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Faroe Islands')
				) ,
				Array(
					'name' => __('Fiji', 'wp-econtact') ,
					'slug' => sanitize_title('Fiji')
				) ,
				Array(
					'name' => __('Finland', 'wp-econtact') ,
					'slug' => sanitize_title('Finland')
				) ,
				Array(
					'name' => __('France', 'wp-econtact') ,
					'slug' => sanitize_title('France')
				) ,
				Array(
					'name' => __('French Guiana', 'wp-econtact') ,
					'slug' => sanitize_title('French Guiana')
				) ,
				Array(
					'name' => __('French Polynesia', 'wp-econtact') ,
					'slug' => sanitize_title('French Polynesia')
				) ,
				Array(
					'name' => __('French Southern Territories', 'wp-econtact') ,
					'slug' => sanitize_title('French Southern Territories')
				) ,
				Array(
					'name' => __('Gabon', 'wp-econtact') ,
					'slug' => sanitize_title('Gabon')
				) ,
				Array(
					'name' => __('Gambia', 'wp-econtact') ,
					'slug' => sanitize_title('Gambia')
				) ,
				Array(
					'name' => __('Georgia', 'wp-econtact') ,
					'slug' => sanitize_title('Georgia')
				) ,
				Array(
					'name' => __('Germany', 'wp-econtact') ,
					'slug' => sanitize_title('Germany')
				) ,
				Array(
					'name' => __('Ghana', 'wp-econtact') ,
					'slug' => sanitize_title('Ghana')
				) ,
				Array(
					'name' => __('Gibraltar', 'wp-econtact') ,
					'slug' => sanitize_title('Gibraltar')
				) ,
				Array(
					'name' => __('Greece', 'wp-econtact') ,
					'slug' => sanitize_title('Greece')
				) ,
				Array(
					'name' => __('Greenland', 'wp-econtact') ,
					'slug' => sanitize_title('Greenland')
				) ,
				Array(
					'name' => __('Grenada', 'wp-econtact') ,
					'slug' => sanitize_title('Grenada')
				) ,
				Array(
					'name' => __('Guadeloupe', 'wp-econtact') ,
					'slug' => sanitize_title('Guadeloupe')
				) ,
				Array(
					'name' => __('Guam', 'wp-econtact') ,
					'slug' => sanitize_title('Guam')
				) ,
				Array(
					'name' => __('Guatemala', 'wp-econtact') ,
					'slug' => sanitize_title('Guatemala')
				) ,
				Array(
					'name' => __('Guernsey', 'wp-econtact') ,
					'slug' => sanitize_title('Guernsey')
				) ,
				Array(
					'name' => __('Guinea', 'wp-econtact') ,
					'slug' => sanitize_title('Guinea')
				) ,
				Array(
					'name' => __('Guinea-bissau', 'wp-econtact') ,
					'slug' => sanitize_title('Guinea-bissau')
				) ,
				Array(
					'name' => __('Guyana', 'wp-econtact') ,
					'slug' => sanitize_title('Guyana')
				) ,
				Array(
					'name' => __('Haiti', 'wp-econtact') ,
					'slug' => sanitize_title('Haiti')
				) ,
				Array(
					'name' => __('Heard Island And Mcdonald Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Heard Island And Mcdonald Islands')
				) ,
				Array(
					'name' => __('Holy See (Vatican City State)', 'wp-econtact') ,
					'slug' => sanitize_title('Holy See (Vatican City State)')
				) ,
				Array(
					'name' => __('Honduras', 'wp-econtact') ,
					'slug' => sanitize_title('Honduras')
				) ,
				Array(
					'name' => __('Hong Kong', 'wp-econtact') ,
					'slug' => sanitize_title('Hong Kong')
				) ,
				Array(
					'name' => __('Hungary', 'wp-econtact') ,
					'slug' => sanitize_title('Hungary')
				) ,
				Array(
					'name' => __('Iceland', 'wp-econtact') ,
					'slug' => sanitize_title('Iceland')
				) ,
				Array(
					'name' => __('India', 'wp-econtact') ,
					'slug' => sanitize_title('India')
				) ,
				Array(
					'name' => __('Indonesia', 'wp-econtact') ,
					'slug' => sanitize_title('Indonesia')
				) ,
				Array(
					'name' => __('Iran, Islamic Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Iran, Islamic Republic Of')
				) ,
				Array(
					'name' => __('Iraq', 'wp-econtact') ,
					'slug' => sanitize_title('Iraq')
				) ,
				Array(
					'name' => __('Ireland', 'wp-econtact') ,
					'slug' => sanitize_title('Ireland')
				) ,
				Array(
					'name' => __('Isle Of Man', 'wp-econtact') ,
					'slug' => sanitize_title('Isle Of Man')
				) ,
				Array(
					'name' => __('Israel', 'wp-econtact') ,
					'slug' => sanitize_title('Israel')
				) ,
				Array(
					'name' => __('Italy', 'wp-econtact') ,
					'slug' => sanitize_title('Italy')
				) ,
				Array(
					'name' => __('Jamaica', 'wp-econtact') ,
					'slug' => sanitize_title('Jamaica')
				) ,
				Array(
					'name' => __('Japan', 'wp-econtact') ,
					'slug' => sanitize_title('Japan')
				) ,
				Array(
					'name' => __('Jersey', 'wp-econtact') ,
					'slug' => sanitize_title('Jersey')
				) ,
				Array(
					'name' => __('Jordan', 'wp-econtact') ,
					'slug' => sanitize_title('Jordan')
				) ,
				Array(
					'name' => __('Kazakhstan', 'wp-econtact') ,
					'slug' => sanitize_title('Kazakhstan')
				) ,
				Array(
					'name' => __('Kenya', 'wp-econtact') ,
					'slug' => sanitize_title('Kenya')
				) ,
				Array(
					'name' => __('Kiribati', 'wp-econtact') ,
					'slug' => sanitize_title('Kiribati')
				) ,
				Array(
					'name' => __('Korea, Democratic People\'s Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Korea, Democratic People\'s Republic Of')
				) ,
				Array(
					'name' => __('Korea, Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Korea, Republic Of')
				) ,
				Array(
					'name' => __('Kuwait', 'wp-econtact') ,
					'slug' => sanitize_title('Kuwait')
				) ,
				Array(
					'name' => __('Kyrgyzstan', 'wp-econtact') ,
					'slug' => sanitize_title('Kyrgyzstan')
				) ,
				Array(
					'name' => __('Lao People\'s Democratic Republic', 'wp-econtact') ,
					'slug' => sanitize_title('Lao People\'s Democratic Republic')
				) ,
				Array(
					'name' => __('Latvia', 'wp-econtact') ,
					'slug' => sanitize_title('Latvia')
				) ,
				Array(
					'name' => __('Lebanon', 'wp-econtact') ,
					'slug' => sanitize_title('Lebanon')
				) ,
				Array(
					'name' => __('Lesotho', 'wp-econtact') ,
					'slug' => sanitize_title('Lesotho')
				) ,
				Array(
					'name' => __('Liberia', 'wp-econtact') ,
					'slug' => sanitize_title('Liberia')
				) ,
				Array(
					'name' => __('Libyan Arab Jamahiriya', 'wp-econtact') ,
					'slug' => sanitize_title('Libyan Arab Jamahiriya')
				) ,
				Array(
					'name' => __('Liechtenstein', 'wp-econtact') ,
					'slug' => sanitize_title('Liechtenstein')
				) ,
				Array(
					'name' => __('Lithuania', 'wp-econtact') ,
					'slug' => sanitize_title('Lithuania')
				) ,
				Array(
					'name' => __('Luxembourg', 'wp-econtact') ,
					'slug' => sanitize_title('Luxembourg')
				) ,
				Array(
					'name' => __('Macao', 'wp-econtact') ,
					'slug' => sanitize_title('Macao')
				) ,
				Array(
					'name' => __('Macedonia, The Former Yugoslav Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Macedonia, The Former Yugoslav Republic Of')
				) ,
				Array(
					'name' => __('Madagascar', 'wp-econtact') ,
					'slug' => sanitize_title('Madagascar')
				) ,
				Array(
					'name' => __('Malawi', 'wp-econtact') ,
					'slug' => sanitize_title('Malawi')
				) ,
				Array(
					'name' => __('Malaysia', 'wp-econtact') ,
					'slug' => sanitize_title('Malaysia')
				) ,
				Array(
					'name' => __('Maldives', 'wp-econtact') ,
					'slug' => sanitize_title('Maldives')
				) ,
				Array(
					'name' => __('Mali', 'wp-econtact') ,
					'slug' => sanitize_title('Mali')
				) ,
				Array(
					'name' => __('Malta', 'wp-econtact') ,
					'slug' => sanitize_title('Malta')
				) ,
				Array(
					'name' => __('Marshall Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Marshall Islands')
				) ,
				Array(
					'name' => __('Martinique', 'wp-econtact') ,
					'slug' => sanitize_title('Martinique')
				) ,
				Array(
					'name' => __('Mauritania', 'wp-econtact') ,
					'slug' => sanitize_title('Mauritania')
				) ,
				Array(
					'name' => __('Mauritius', 'wp-econtact') ,
					'slug' => sanitize_title('Mauritius')
				) ,
				Array(
					'name' => __('Mayotte', 'wp-econtact') ,
					'slug' => sanitize_title('Mayotte')
				) ,
				Array(
					'name' => __('Mexico', 'wp-econtact') ,
					'slug' => sanitize_title('Mexico')
				) ,
				Array(
					'name' => __('Micronesia, Federated States Of', 'wp-econtact') ,
					'slug' => sanitize_title('Micronesia, Federated States Of')
				) ,
				Array(
					'name' => __('Moldova, Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Moldova, Republic Of')
				) ,
				Array(
					'name' => __('Monaco', 'wp-econtact') ,
					'slug' => sanitize_title('Monaco')
				) ,
				Array(
					'name' => __('Mongolia', 'wp-econtact') ,
					'slug' => sanitize_title('Mongolia')
				) ,
				Array(
					'name' => __('Montenegro', 'wp-econtact') ,
					'slug' => sanitize_title('Montenegro')
				) ,
				Array(
					'name' => __('Montserrat', 'wp-econtact') ,
					'slug' => sanitize_title('Montserrat')
				) ,
				Array(
					'name' => __('Morocco', 'wp-econtact') ,
					'slug' => sanitize_title('Morocco')
				) ,
				Array(
					'name' => __('Mozambique', 'wp-econtact') ,
					'slug' => sanitize_title('Mozambique')
				) ,
				Array(
					'name' => __('Myanmar', 'wp-econtact') ,
					'slug' => sanitize_title('Myanmar')
				) ,
				Array(
					'name' => __('Namibia', 'wp-econtact') ,
					'slug' => sanitize_title('Namibia')
				) ,
				Array(
					'name' => __('Nauru', 'wp-econtact') ,
					'slug' => sanitize_title('Nauru')
				) ,
				Array(
					'name' => __('Nepal', 'wp-econtact') ,
					'slug' => sanitize_title('Nepal')
				) ,
				Array(
					'name' => __('Netherlands', 'wp-econtact') ,
					'slug' => sanitize_title('Netherlands')
				) ,
				Array(
					'name' => __('Netherlands Antilles', 'wp-econtact') ,
					'slug' => sanitize_title('Netherlands Antilles')
				) ,
				Array(
					'name' => __('New Caledonia', 'wp-econtact') ,
					'slug' => sanitize_title('New Caledonia')
				) ,
				Array(
					'name' => __('New Zealand', 'wp-econtact') ,
					'slug' => sanitize_title('New Zealand')
				) ,
				Array(
					'name' => __('Nicaragua', 'wp-econtact') ,
					'slug' => sanitize_title('Nicaragua')
				) ,
				Array(
					'name' => __('Niger', 'wp-econtact') ,
					'slug' => sanitize_title('Niger')
				) ,
				Array(
					'name' => __('Nigeria', 'wp-econtact') ,
					'slug' => sanitize_title('Nigeria')
				) ,
				Array(
					'name' => __('Niue', 'wp-econtact') ,
					'slug' => sanitize_title('Niue')
				) ,
				Array(
					'name' => __('Norfolk Island', 'wp-econtact') ,
					'slug' => sanitize_title('Norfolk Island')
				) ,
				Array(
					'name' => __('Northern Mariana Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Northern Mariana Islands')
				) ,
				Array(
					'name' => __('Norway', 'wp-econtact') ,
					'slug' => sanitize_title('Norway')
				) ,
				Array(
					'name' => __('Oman', 'wp-econtact') ,
					'slug' => sanitize_title('Oman')
				) ,
				Array(
					'name' => __('Pakistan', 'wp-econtact') ,
					'slug' => sanitize_title('Pakistan')
				) ,
				Array(
					'name' => __('Palau', 'wp-econtact') ,
					'slug' => sanitize_title('Palau')
				) ,
				Array(
					'name' => __('Palestinian Territory, Occupied', 'wp-econtact') ,
					'slug' => sanitize_title('Palestinian Territory, Occupied')
				) ,
				Array(
					'name' => __('Panama', 'wp-econtact') ,
					'slug' => sanitize_title('Panama')
				) ,
				Array(
					'name' => __('Papua New Guinea', 'wp-econtact') ,
					'slug' => sanitize_title('Papua New Guinea')
				) ,
				Array(
					'name' => __('Paraguay', 'wp-econtact') ,
					'slug' => sanitize_title('Paraguay')
				) ,
				Array(
					'name' => __('Peru', 'wp-econtact') ,
					'slug' => sanitize_title('Peru')
				) ,
				Array(
					'name' => __('Philippines', 'wp-econtact') ,
					'slug' => sanitize_title('Philippines')
				) ,
				Array(
					'name' => __('Pitcairn', 'wp-econtact') ,
					'slug' => sanitize_title('Pitcairn')
				) ,
				Array(
					'name' => __('Poland', 'wp-econtact') ,
					'slug' => sanitize_title('Poland')
				) ,
				Array(
					'name' => __('Portugal', 'wp-econtact') ,
					'slug' => sanitize_title('Portugal')
				) ,
				Array(
					'name' => __('Puerto Rico', 'wp-econtact') ,
					'slug' => sanitize_title('Puerto Rico')
				) ,
				Array(
					'name' => __('Qatar', 'wp-econtact') ,
					'slug' => sanitize_title('Qatar')
				) ,
				Array(
					'name' => __('Reunion', 'wp-econtact') ,
					'slug' => sanitize_title('Reunion')
				) ,
				Array(
					'name' => __('Romania', 'wp-econtact') ,
					'slug' => sanitize_title('Romania')
				) ,
				Array(
					'name' => __('Russian Federation', 'wp-econtact') ,
					'slug' => sanitize_title('Russian Federation')
				) ,
				Array(
					'name' => __('Rwanda', 'wp-econtact') ,
					'slug' => sanitize_title('Rwanda')
				) ,
				Array(
					'name' => __('Saint Helena', 'wp-econtact') ,
					'slug' => sanitize_title('Saint Helena')
				) ,
				Array(
					'name' => __('Saint Kitts And Nevis', 'wp-econtact') ,
					'slug' => sanitize_title('Saint Kitts And Nevis')
				) ,
				Array(
					'name' => __('Saint Lucia', 'wp-econtact') ,
					'slug' => sanitize_title('Saint Lucia')
				) ,
				Array(
					'name' => __('Saint Pierre And Miquelon', 'wp-econtact') ,
					'slug' => sanitize_title('Saint Pierre And Miquelon')
				) ,
				Array(
					'name' => __('Saint Vincent And The Grenadines', 'wp-econtact') ,
					'slug' => sanitize_title('Saint Vincent And The Grenadines')
				) ,
				Array(
					'name' => __('Samoa', 'wp-econtact') ,
					'slug' => sanitize_title('Samoa')
				) ,
				Array(
					'name' => __('San Marino', 'wp-econtact') ,
					'slug' => sanitize_title('San Marino')
				) ,
				Array(
					'name' => __('Sao Tome And Principe', 'wp-econtact') ,
					'slug' => sanitize_title('Sao Tome And Principe')
				) ,
				Array(
					'name' => __('Saudi Arabia', 'wp-econtact') ,
					'slug' => sanitize_title('Saudi Arabia')
				) ,
				Array(
					'name' => __('Senegal', 'wp-econtact') ,
					'slug' => sanitize_title('Senegal')
				) ,
				Array(
					'name' => __('Serbia', 'wp-econtact') ,
					'slug' => sanitize_title('Serbia')
				) ,
				Array(
					'name' => __('Seychelles', 'wp-econtact') ,
					'slug' => sanitize_title('Seychelles')
				) ,
				Array(
					'name' => __('Sierra Leone', 'wp-econtact') ,
					'slug' => sanitize_title('Sierra Leone')
				) ,
				Array(
					'name' => __('Singapore', 'wp-econtact') ,
					'slug' => sanitize_title('Singapore')
				) ,
				Array(
					'name' => __('Slovakia', 'wp-econtact') ,
					'slug' => sanitize_title('Slovakia')
				) ,
				Array(
					'name' => __('Slovenia', 'wp-econtact') ,
					'slug' => sanitize_title('Slovenia')
				) ,
				Array(
					'name' => __('Solomon Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Solomon Islands')
				) ,
				Array(
					'name' => __('Somalia', 'wp-econtact') ,
					'slug' => sanitize_title('Somalia')
				) ,
				Array(
					'name' => __('South Africa', 'wp-econtact') ,
					'slug' => sanitize_title('South Africa')
				) ,
				Array(
					'name' => __('South Georgia And The South Sandwich Islands', 'wp-econtact') ,
					'slug' => sanitize_title('South Georgia And The South Sandwich Islands')
				) ,
				Array(
					'name' => __('Spain', 'wp-econtact') ,
					'slug' => sanitize_title('Spain')
				) ,
				Array(
					'name' => __('Sri Lanka', 'wp-econtact') ,
					'slug' => sanitize_title('Sri Lanka')
				) ,
				Array(
					'name' => __('Sudan', 'wp-econtact') ,
					'slug' => sanitize_title('Sudan')
				) ,
				Array(
					'name' => __('Suriname', 'wp-econtact') ,
					'slug' => sanitize_title('Suriname')
				) ,
				Array(
					'name' => __('Svalbard And Jan Mayen', 'wp-econtact') ,
					'slug' => sanitize_title('Svalbard And Jan Mayen')
				) ,
				Array(
					'name' => __('Swaziland', 'wp-econtact') ,
					'slug' => sanitize_title('Swaziland')
				) ,
				Array(
					'name' => __('Sweden', 'wp-econtact') ,
					'slug' => sanitize_title('Sweden')
				) ,
				Array(
					'name' => __('Switzerland', 'wp-econtact') ,
					'slug' => sanitize_title('Switzerland')
				) ,
				Array(
					'name' => __('Syrian Arab Republic', 'wp-econtact') ,
					'slug' => sanitize_title('Syrian Arab Republic')
				) ,
				Array(
					'name' => __('Taiwan, Province Of China', 'wp-econtact') ,
					'slug' => sanitize_title('Taiwan, Province Of China')
				) ,
				Array(
					'name' => __('Tajikistan', 'wp-econtact') ,
					'slug' => sanitize_title('Tajikistan')
				) ,
				Array(
					'name' => __('Tanzania, United Republic Of', 'wp-econtact') ,
					'slug' => sanitize_title('Tanzania, United Republic Of')
				) ,
				Array(
					'name' => __('Thailand', 'wp-econtact') ,
					'slug' => sanitize_title('Thailand')
				) ,
				Array(
					'name' => __('Timor-leste', 'wp-econtact') ,
					'slug' => sanitize_title('Timor-leste')
				) ,
				Array(
					'name' => __('Togo', 'wp-econtact') ,
					'slug' => sanitize_title('Togo')
				) ,
				Array(
					'name' => __('Tokelau', 'wp-econtact') ,
					'slug' => sanitize_title('Tokelau')
				) ,
				Array(
					'name' => __('Tonga', 'wp-econtact') ,
					'slug' => sanitize_title('Tonga')
				) ,
				Array(
					'name' => __('Trinidad And Tobago', 'wp-econtact') ,
					'slug' => sanitize_title('Trinidad And Tobago')
				) ,
				Array(
					'name' => __('Tunisia', 'wp-econtact') ,
					'slug' => sanitize_title('Tunisia')
				) ,
				Array(
					'name' => __('Turkey', 'wp-econtact') ,
					'slug' => sanitize_title('Turkey')
				) ,
				Array(
					'name' => __('Turkmenistan', 'wp-econtact') ,
					'slug' => sanitize_title('Turkmenistan')
				) ,
				Array(
					'name' => __('Turks And Caicos Islands', 'wp-econtact') ,
					'slug' => sanitize_title('Turks And Caicos Islands')
				) ,
				Array(
					'name' => __('Tuvalu', 'wp-econtact') ,
					'slug' => sanitize_title('Tuvalu')
				) ,
				Array(
					'name' => __('Uganda', 'wp-econtact') ,
					'slug' => sanitize_title('Uganda')
				) ,
				Array(
					'name' => __('Ukraine', 'wp-econtact') ,
					'slug' => sanitize_title('Ukraine')
				) ,
				Array(
					'name' => __('United Arab Emirates', 'wp-econtact') ,
					'slug' => sanitize_title('United Arab Emirates')
				) ,
				Array(
					'name' => __('United Kingdom', 'wp-econtact') ,
					'slug' => sanitize_title('United Kingdom')
				) ,
				Array(
					'name' => __('United States', 'wp-econtact') ,
					'slug' => sanitize_title('United States')
				) ,
				Array(
					'name' => __('United States Minor Outlying Islands', 'wp-econtact') ,
					'slug' => sanitize_title('United States Minor Outlying Islands')
				) ,
				Array(
					'name' => __('Uruguay', 'wp-econtact') ,
					'slug' => sanitize_title('Uruguay')
				) ,
				Array(
					'name' => __('Uzbekistan', 'wp-econtact') ,
					'slug' => sanitize_title('Uzbekistan')
				) ,
				Array(
					'name' => __('Vanuatu', 'wp-econtact') ,
					'slug' => sanitize_title('Vanuatu')
				) ,
				Array(
					'name' => __('Venezuela', 'wp-econtact') ,
					'slug' => sanitize_title('Venezuela')
				) ,
				Array(
					'name' => __('Viet Nam', 'wp-econtact') ,
					'slug' => sanitize_title('Viet Nam')
				) ,
				Array(
					'name' => __('Virgin Islands, British', 'wp-econtact') ,
					'slug' => sanitize_title('Virgin Islands, British')
				) ,
				Array(
					'name' => __('Virgin Islands, U.S.', 'wp-econtact') ,
					'slug' => sanitize_title('Virgin Islands, U.S.')
				) ,
				Array(
					'name' => __('Wallis And Futuna', 'wp-econtact') ,
					'slug' => sanitize_title('Wallis And Futuna')
				) ,
				Array(
					'name' => __('Western Sahara', 'wp-econtact') ,
					'slug' => sanitize_title('Western Sahara')
				) ,
				Array(
					'name' => __('Yemen', 'wp-econtact') ,
					'slug' => sanitize_title('Yemen')
				) ,
				Array(
					'name' => __('Zambia', 'wp-econtact') ,
					'slug' => sanitize_title('Zambia')
				) ,
				Array(
					'name' => __('Zimbabwe', 'wp-econtact') ,
					'slug' => sanitize_title('Zimbabwe')
				)
			);
			self::set_taxonomy_init($set_tax_terms, 'contact_country');
			update_option('wp_econtact_emd_contact_terms_init', true);
		}
	}
	/**
	 * Set metabox fields,labels,filters, comments, relationships if exists
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function set_filters() {
		$search_args = Array();
		$filter_args = Array();
		$this->sing_label = __('Contact', 'wp-econtact');
		$this->plural_label = __('Contacts', 'wp-econtact');
		$this->menu_entity = 'emd_contact';
		$this->boxes[] = array(
			'id' => 'emd_contact_info_emd_contact_0',
			'title' => __('Contact Info', 'wp-econtact') ,
			'pages' => array(
				'emd_contact'
			) ,
			'context' => 'normal',
		);
		list($search_args, $filter_args) = $this->set_args_boxes();
		if (!post_type_exists($this->post_type) || in_array($this->post_type, Array(
			'post',
			'page'
		))) {
			self::register();
		}
	}
	/**
	 * Initialize metaboxes
	 * @since WPAS 4.5
	 *
	 */
	public function set_metabox() {
		if (class_exists('EMD_Meta_Box') && is_array($this->boxes)) {
			foreach ($this->boxes as $meta_box) {
				new EMD_Meta_Box($meta_box);
			}
		}
	}
	/**
	 * Change content for created frontend views
	 * @since WPAS 4.0
	 * @param string $content
	 *
	 * @return string $content
	 */
	public function change_content($content) {
		global $post;
		$layout = "";
		if (get_post_type() == $this->post_type && is_single()) {
			ob_start();
			emd_get_template_part($this->textdomain, 'single', 'emd-contact');
			$layout = ob_get_clean();
		}
		if ($layout != "") {
			$content = $layout;
		}
		return $content;
	}
}
new Emd_Contact;
