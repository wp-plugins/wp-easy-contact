
<div class="form-alerts">
<?php
echo (isset($zf_error) ? $zf_error : (isset($error) ? $error : ''));
$form_list = get_option('wp_econtact_glob_forms_list');
$form_variables = $form_list['contact_submit'];
$req_hide_vars = emd_get_form_req_hide_vars('wp_econtact', 'contact_submit');
$glob_list = get_option('wp_econtact_glob_list');
?>
</div>
<fieldset>
<div class="contact_submit-btn-fields">
<!-- contact_submit Form Attributes -->
<div class="contact_submit_attributes">
<div id="row1" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_first_name']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_first_name']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_first_name" class="control-label" for="emd_contact_first_name">
<?php _e('First Name', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your first name.', 'wp-econtact'); ?>" id="info_emd_contact_first_name" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_first_name', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('First Name field is required', 'wp-econtact'); ?>" id="info_emd_contact_first_name" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_first_name; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row2" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_last_name']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_last_name']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_last_name" class="control-label" for="emd_contact_last_name">
<?php _e('Last Name', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your last name.', 'wp-econtact'); ?>" id="info_emd_contact_last_name" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_last_name', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Last Name field is required', 'wp-econtact'); ?>" id="info_emd_contact_last_name" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_last_name; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row3" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_email']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_email']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_email" class="control-label" for="emd_contact_email">
<?php _e('Email', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your email address.', 'wp-econtact'); ?>" id="info_emd_contact_email" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_email', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Email field is required', 'wp-econtact'); ?>" id="info_emd_contact_email" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_email; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row4" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_phone']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_phone']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_phone" class="control-label" for="emd_contact_phone">
<?php _e('Phone', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your phone or mobile.', 'wp-econtact'); ?>" id="info_emd_contact_phone" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_phone', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Phone field is required', 'wp-econtact'); ?>" id="info_emd_contact_phone" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_phone; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row5" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_address']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_address']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_address" class="control-label" for="emd_contact_address">
<?php _e('Address', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your mailing address.', 'wp-econtact'); ?>" id="info_emd_contact_address" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_address', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Address field is required', 'wp-econtact'); ?>" id="info_emd_contact_address" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_address; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row6" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_city']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_city']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_city" class="control-label" for="emd_contact_city">
<?php _e('City', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your city.', 'wp-econtact'); ?>" id="info_emd_contact_city" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_city', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('City field is required', 'wp-econtact'); ?>" id="info_emd_contact_city" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_city; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row7" class="row">
<!-- Taxonomy input-->
<?php if ($form_variables['contact_state']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['contact_state']['size']; ?>">
<div class="form-group">
<label id="label_contact_state" class="control-label" for="contact_state">
<?php _e('State', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your state you reside in.', 'wp-econtact'); ?>" id="info_contact_state" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('contact_state', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('State field is required', 'wp-econtact'); ?>" id="info_contact_state" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $contact_state; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row8" class="row">
<!-- text input-->
<?php if ($form_variables['emd_contact_zipcode']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['emd_contact_zipcode']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_emd_contact_zipcode" class="control-label" for="emd_contact_zipcode">
<?php _e('Zip Code', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your zip code.', 'wp-econtact'); ?>" id="info_emd_contact_zipcode" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('emd_contact_zipcode', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Zip Code field is required', 'wp-econtact'); ?>" id="info_emd_contact_zipcode" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $emd_contact_zipcode; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row9" class="row">
<!-- Taxonomy input-->
<?php if ($form_variables['contact_country']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['contact_country']['size']; ?>">
<div class="form-group">
<label id="label_contact_country" class="control-label" for="contact_country">
<?php _e('Country', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<a data-html="true" href="#" data-toggle="tooltip" title="<?php _e('Please enter your country you reside in.', 'wp-econtact'); ?>" id="info_contact_country" class="helptip"><span class="field-icons icons-help"></span></a>
<?php if (in_array('contact_country', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Country field is required', 'wp-econtact'); ?>" id="info_contact_country" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $contact_country; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row10" class="row">
<!-- text input-->
<?php if ($form_variables['blt_title']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['blt_title']['size']; ?> woptdiv">
<div class="form-group">
<label id="label_blt_title" class="control-label" for="blt_title">
<?php _e('Subject', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('blt_title', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Subject field is required', 'wp-econtact'); ?>" id="info_blt_title" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $blt_title; ?>
</div>
</div>
<?php
} ?>
</div>
<div id="row11" class="row">
<!-- wysiwyg input-->
<?php if ($form_variables['blt_content']['show'] == 1) { ?>
<div class="col-md-<?php echo $form_variables['blt_content']['size']; ?>">
<div class="form-group">
<label id="label_blt_content" class="control-label" for="blt_content">
<?php _e('Message', 'wp-econtact'); ?>
<span style="display: inline-flex;right: 0px; position: relative; top:-6px;">
<?php if (in_array('blt_content', $req_hide_vars['req'])) { ?>
<a href="#" data-html="true" data-toggle="tooltip" title="<?php _e('Message field is required', 'wp-econtact'); ?>" id="info_blt_content" class="helptip">
<span class="field-icons icons-required"></span>
</a>
<?php
	} ?>
</span>
</label>
<?php echo $blt_content; ?>
</div>
</div>
<?php
} ?>
</div>
 
 
 
 
</div><!--form-attributes-->
<?php if ($show_captcha == 1) { ?>
<div class="row">
<div class="col-xs-12">
<div id="captcha-group" class="form-group">
<?php echo $captcha_image; ?>
<label style="padding:0px;" id="label_captcha_code" class="control-label" for="captcha_code">
<a id="info_captcha_code_help" class="helptip" data-html="true" data-toggle="tooltip" href="#" title="<?php _e('Please enter the characters with black color in the image above.', 'wp-econtact'); ?>">
<span class="field-icons icons-help"></span>
</a>
<a id="info_captcha_code_req" class="helptip" title="<?php _e('Security Code field is required', 'wp-econtact'); ?>" data-toggle="tooltip" href="#">
<span class="field-icons icons-required"></span>
</a>
</label>
<?php echo $captcha_code; ?>
</div>
</div>
</div>
<?php
} ?>
<?php wp_nonce_field('contact_submit', 'contact_submit_nonce'); ?>
<input type="hidden" name="form_name" id="form_name" value="contact_submit">
<!-- Button -->
<div class="row">
<div class="col-md-12">
<div class="wpas-form-actions">
<?php echo $singlebutton_contact_submit; ?>
</div>
</div>
</div>
</div><!--form-btn-fields-->
</fieldset>