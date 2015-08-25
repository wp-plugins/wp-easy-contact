<?php $ent_attrs = get_option('wp_econtact_attr_list'); ?>
<div class="emd-container">
<?php
$emd_contact_first_name = emd_mb_meta('emd_contact_first_name');
if (!empty($emd_contact_first_name)) { ?>
   <div id="emd-contact-emd-contact-first-name-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-first-name-key" class="emd-single-title">
<?php _e('First Name', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-first-name-val" class="emd-single-val">
<?php echo $emd_contact_first_name; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_last_name = emd_mb_meta('emd_contact_last_name');
if (!empty($emd_contact_last_name)) { ?>
   <div id="emd-contact-emd-contact-last-name-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-last-name-key" class="emd-single-title">
<?php _e('Last Name', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-last-name-val" class="emd-single-val">
<?php echo $emd_contact_last_name; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_email = emd_mb_meta('emd_contact_email');
if (!empty($emd_contact_email)) { ?>
   <div id="emd-contact-emd-contact-email-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-email-key" class="emd-single-title">
<?php _e('Email', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-email-val" class="emd-single-val">
<?php echo $emd_contact_email; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_phone = emd_mb_meta('emd_contact_phone');
if (!empty($emd_contact_phone)) { ?>
   <div id="emd-contact-emd-contact-phone-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-phone-key" class="emd-single-title">
<?php _e('Phone', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-phone-val" class="emd-single-val">
<?php echo $emd_contact_phone; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_address = emd_mb_meta('emd_contact_address');
if (!empty($emd_contact_address)) { ?>
   <div id="emd-contact-emd-contact-address-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-address-key" class="emd-single-title">
<?php _e('Address', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-address-val" class="emd-single-val">
<?php echo $emd_contact_address; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_city = emd_mb_meta('emd_contact_city');
if (!empty($emd_contact_city)) { ?>
   <div id="emd-contact-emd-contact-city-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-city-key" class="emd-single-title">
<?php _e('City', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-city-val" class="emd-single-val">
<?php echo $emd_contact_city; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_zipcode = emd_mb_meta('emd_contact_zipcode');
if (!empty($emd_contact_zipcode)) { ?>
   <div id="emd-contact-emd-contact-zipcode-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-zipcode-key" class="emd-single-title">
<?php _e('Zip Code', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-zipcode-val" class="emd-single-val">
<?php echo $emd_contact_zipcode; ?>
   </div>
   </div>
<?php
} ?>
<?php
$emd_contact_id = emd_mb_meta('emd_contact_id');
if (!empty($emd_contact_id)) { ?>
   <div id="emd-contact-emd-contact-id-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-id-key" class="emd-single-title">
<?php _e('ID', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-emd-contact-id-val" class="emd-single-val">
<?php echo $emd_contact_id; ?>
   </div>
   </div>
<?php
} ?>
<?php $blt_content = $post->post_content;
if (!empty($blt_content)) { ?>
   <div id="emd-contact-blt-content-div" class="emd-single-div">
   <div id="emd-contact-blt-content-key" class="emd-single-title">
   <?php _e('Message', 'wp-econtact'); ?>
   </div>
   <div id="emd-contact-blt-content-val" class="emd-single-val">
   <?php echo $blt_content; ?>
   </div>
   </div>
<?php
} ?>
<?php
$taxlist = get_object_taxonomies(get_post_type() , 'objects');
foreach ($taxlist as $taxkey => $mytax) {
	$termlist = get_the_term_list(get_the_ID() , $taxkey, '', ' , ', '');
	if (!empty($termlist)) { ?>
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-div" class="emd-single-div">
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-key" class="emd-single-title">
      <?php echo esc_html($mytax->labels->singular_name); ?>
      </div>
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-val" class="emd-single-val">
      <?php echo $termlist; ?>
      </div>
      </div>
   <?php
	}
} ?>
</div><!--container-end-->