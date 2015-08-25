<?php
/**
 * Settings Glossary Functions
 *
 * @package WP_ECONTACT
 * @version 2.1.0
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('wp_econtact_settings_glossary', 'wp_econtact_settings_glossary');
/**
 * Display glossary information
 * @since WPAS 4.0
 *
 * @return html
 */
function wp_econtact_settings_glossary() {
	global $title;
?>
<div class="wrap">
<h2><?php echo $title; ?></h2>
<p><?php _e('WP Easy Contact provides a contact form and stores the collected information in WordPress.', 'wp-econtact'); ?></p>
<p><?php _e('The below are the definitions of entities, attributes, and terms included in WP Easy Contact.', 'wp-econtact'); ?></p>
<div id="glossary" class="accordion-container">
<ul class="outer-border">
<li id="emd_contact" class="control-section accordion-section">
<h3 class="accordion-section-title hndle" tabindex="1"><?php _e('Contacts', 'wp-econtact'); ?></h3>
<div class="accordion-section-content">
<div class="inside">
<table class="form-table"><p class"lead"><?php _e('', 'wp-econtact'); ?></p><tr>
<th><?php _e('First Name', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your first name. First Name is a required field. First Name does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Last Name', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your last name. Last Name does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Email', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your email address. Email is a required field. Email does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Phone', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your phone or mobile. Phone does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Address', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your mailing address. Address does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('City', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your city. City does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Zip Code', 'wp-econtact'); ?></th>
<td><?php _e('Please enter your zip code. Zip Code does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Subject', 'wp-econtact'); ?></th>
<td><?php _e(' Subject is a required field. Subject does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Message', 'wp-econtact'); ?></th>
<td><?php _e(' Message is a required field. Message does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('ID', 'wp-econtact'); ?></th>
<td><?php _e('Unique contact id incremented by one to keep tract of communications Being a unique identifier, it uniquely distinguishes each instance of Contact entity. ID does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Form Name', 'wp-econtact'); ?></th>
<td><?php _e(' Form Name is filterable in the admin area. Form Name has a default value of <b>admin</b>.', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Form Submitted By', 'wp-econtact'); ?></th>
<td><?php _e(' Form Submitted By is filterable in the admin area. Form Submitted By does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Form Submitted IP', 'wp-econtact'); ?></th>
<td><?php _e(' Form Submitted IP is filterable in the admin area. Form Submitted IP does not have a default value. ', 'wp-econtact'); ?></td>
</tr><tr>
<th><?php _e('Country', 'wp-econtact'); ?></th>

<td><?php _e('Please enter your country you reside in. Country accepts multiple values like tags', 'wp-econtact'); ?>. <?php _e('Country does not have a default value', 'wp-econtact'); ?>.<div class="taxdef-block"><p><?php _e('The following are the preset values for <b>Country:</b>', 'wp-econtact'); ?></p><p class="taxdef-values"><?php _e('Afghanistan', 'wp-econtact'); ?>, <?php _e('Åland Islands', 'wp-econtact'); ?>, <?php _e('Albania', 'wp-econtact'); ?>, <?php _e('Algeria', 'wp-econtact'); ?>, <?php _e('American Samoa', 'wp-econtact'); ?>, <?php _e('Andorra', 'wp-econtact'); ?>, <?php _e('Angola', 'wp-econtact'); ?>, <?php _e('Anguilla', 'wp-econtact'); ?>, <?php _e('Antarctica', 'wp-econtact'); ?>, <?php _e('Antigua And Barbuda', 'wp-econtact'); ?>, <?php _e('Argentina', 'wp-econtact'); ?>, <?php _e('Armenia', 'wp-econtact'); ?>, <?php _e('Aruba', 'wp-econtact'); ?>, <?php _e('Australia', 'wp-econtact'); ?>, <?php _e('Austria', 'wp-econtact'); ?>, <?php _e('Azerbaijan', 'wp-econtact'); ?>, <?php _e('Bahamas', 'wp-econtact'); ?>, <?php _e('Bahrain', 'wp-econtact'); ?>, <?php _e('Bangladesh', 'wp-econtact'); ?>, <?php _e('Barbados', 'wp-econtact'); ?>, <?php _e('Belarus', 'wp-econtact'); ?>, <?php _e('Belgium', 'wp-econtact'); ?>, <?php _e('Belize', 'wp-econtact'); ?>, <?php _e('Benin', 'wp-econtact'); ?>, <?php _e('Bermuda', 'wp-econtact'); ?>, <?php _e('Bhutan', 'wp-econtact'); ?>, <?php _e('Bolivia', 'wp-econtact'); ?>, <?php _e('Bosnia And Herzegovina', 'wp-econtact'); ?>, <?php _e('Botswana', 'wp-econtact'); ?>, <?php _e('Bouvet Island', 'wp-econtact'); ?>, <?php _e('Brazil', 'wp-econtact'); ?>, <?php _e('British Indian Ocean Territory', 'wp-econtact'); ?>, <?php _e('Brunei Darussalam', 'wp-econtact'); ?>, <?php _e('Bulgaria', 'wp-econtact'); ?>, <?php _e('Burkina Faso', 'wp-econtact'); ?>, <?php _e('Burundi', 'wp-econtact'); ?>, <?php _e('Cambodia', 'wp-econtact'); ?>, <?php _e('Cameroon', 'wp-econtact'); ?>, <?php _e('Canada', 'wp-econtact'); ?>, <?php _e('Cape Verde', 'wp-econtact'); ?>, <?php _e('Cayman Islands', 'wp-econtact'); ?>, <?php _e('Central African Republic', 'wp-econtact'); ?>, <?php _e('Chad', 'wp-econtact'); ?>, <?php _e('Chile', 'wp-econtact'); ?>, <?php _e('China', 'wp-econtact'); ?>, <?php _e('Christmas Island', 'wp-econtact'); ?>, <?php _e('Cocos (Keeling) Islands', 'wp-econtact'); ?>, <?php _e('Colombia', 'wp-econtact'); ?>, <?php _e('Comoros', 'wp-econtact'); ?>, <?php _e('Congo', 'wp-econtact'); ?>, <?php _e('Congo, The Democratic Republic Of The', 'wp-econtact'); ?>, <?php _e('Cook Islands', 'wp-econtact'); ?>, <?php _e('Costa Rica', 'wp-econtact'); ?>, <?php _e('Cote D\'ivoire', 'wp-econtact'); ?>, <?php _e('Croatia', 'wp-econtact'); ?>, <?php _e('Cuba', 'wp-econtact'); ?>, <?php _e('Cyprus', 'wp-econtact'); ?>, <?php _e('Czech Republic', 'wp-econtact'); ?>, <?php _e('Denmark', 'wp-econtact'); ?>, <?php _e('Djibouti', 'wp-econtact'); ?>, <?php _e('Dominica', 'wp-econtact'); ?>, <?php _e('Dominican Republic', 'wp-econtact'); ?>, <?php _e('Ecuador', 'wp-econtact'); ?>, <?php _e('Egypt', 'wp-econtact'); ?>, <?php _e('El Salvador', 'wp-econtact'); ?>, <?php _e('Equatorial Guinea', 'wp-econtact'); ?>, <?php _e('Eritrea', 'wp-econtact'); ?>, <?php _e('Estonia', 'wp-econtact'); ?>, <?php _e('Ethiopia', 'wp-econtact'); ?>, <?php _e('Falkland Islands (Malvinas)', 'wp-econtact'); ?>, <?php _e('Faroe Islands', 'wp-econtact'); ?>, <?php _e('Fiji', 'wp-econtact'); ?>, <?php _e('Finland', 'wp-econtact'); ?>, <?php _e('France', 'wp-econtact'); ?>, <?php _e('French Guiana', 'wp-econtact'); ?>, <?php _e('French Polynesia', 'wp-econtact'); ?>, <?php _e('French Southern Territories', 'wp-econtact'); ?>, <?php _e('Gabon', 'wp-econtact'); ?>, <?php _e('Gambia', 'wp-econtact'); ?>, <?php _e('Georgia', 'wp-econtact'); ?>, <?php _e('Germany', 'wp-econtact'); ?>, <?php _e('Ghana', 'wp-econtact'); ?>, <?php _e('Gibraltar', 'wp-econtact'); ?>, <?php _e('Greece', 'wp-econtact'); ?>, <?php _e('Greenland', 'wp-econtact'); ?>, <?php _e('Grenada', 'wp-econtact'); ?>, <?php _e('Guadeloupe', 'wp-econtact'); ?>, <?php _e('Guam', 'wp-econtact'); ?>, <?php _e('Guatemala', 'wp-econtact'); ?>, <?php _e('Guernsey', 'wp-econtact'); ?>, <?php _e('Guinea', 'wp-econtact'); ?>, <?php _e('Guinea-bissau', 'wp-econtact'); ?>, <?php _e('Guyana', 'wp-econtact'); ?>, <?php _e('Haiti', 'wp-econtact'); ?>, <?php _e('Heard Island And Mcdonald Islands', 'wp-econtact'); ?>, <?php _e('Holy See (Vatican City State)', 'wp-econtact'); ?>, <?php _e('Honduras', 'wp-econtact'); ?>, <?php _e('Hong Kong', 'wp-econtact'); ?>, <?php _e('Hungary', 'wp-econtact'); ?>, <?php _e('Iceland', 'wp-econtact'); ?>, <?php _e('India', 'wp-econtact'); ?>, <?php _e('Indonesia', 'wp-econtact'); ?>, <?php _e('Iran, Islamic Republic Of', 'wp-econtact'); ?>, <?php _e('Iraq', 'wp-econtact'); ?>, <?php _e('Ireland', 'wp-econtact'); ?>, <?php _e('Isle Of Man', 'wp-econtact'); ?>, <?php _e('Israel', 'wp-econtact'); ?>, <?php _e('Italy', 'wp-econtact'); ?>, <?php _e('Jamaica', 'wp-econtact'); ?>, <?php _e('Japan', 'wp-econtact'); ?>, <?php _e('Jersey', 'wp-econtact'); ?>, <?php _e('Jordan', 'wp-econtact'); ?>, <?php _e('Kazakhstan', 'wp-econtact'); ?>, <?php _e('Kenya', 'wp-econtact'); ?>, <?php _e('Kiribati', 'wp-econtact'); ?>, <?php _e('Korea, Democratic People\'s Republic Of', 'wp-econtact'); ?>, <?php _e('Korea, Republic Of', 'wp-econtact'); ?>, <?php _e('Kuwait', 'wp-econtact'); ?>, <?php _e('Kyrgyzstan', 'wp-econtact'); ?>, <?php _e('Lao People\'s Democratic Republic', 'wp-econtact'); ?>, <?php _e('Latvia', 'wp-econtact'); ?>, <?php _e('Lebanon', 'wp-econtact'); ?>, <?php _e('Lesotho', 'wp-econtact'); ?>, <?php _e('Liberia', 'wp-econtact'); ?>, <?php _e('Libyan Arab Jamahiriya', 'wp-econtact'); ?>, <?php _e('Liechtenstein', 'wp-econtact'); ?>, <?php _e('Lithuania', 'wp-econtact'); ?>, <?php _e('Luxembourg', 'wp-econtact'); ?>, <?php _e('Macao', 'wp-econtact'); ?>, <?php _e('Macedonia, The Former Yugoslav Republic Of', 'wp-econtact'); ?>, <?php _e('Madagascar', 'wp-econtact'); ?>, <?php _e('Malawi', 'wp-econtact'); ?>, <?php _e('Malaysia', 'wp-econtact'); ?>, <?php _e('Maldives', 'wp-econtact'); ?>, <?php _e('Mali', 'wp-econtact'); ?>, <?php _e('Malta', 'wp-econtact'); ?>, <?php _e('Marshall Islands', 'wp-econtact'); ?>, <?php _e('Martinique', 'wp-econtact'); ?>, <?php _e('Mauritania', 'wp-econtact'); ?>, <?php _e('Mauritius', 'wp-econtact'); ?>, <?php _e('Mayotte', 'wp-econtact'); ?>, <?php _e('Mexico', 'wp-econtact'); ?>, <?php _e('Micronesia, Federated States Of', 'wp-econtact'); ?>, <?php _e('Moldova, Republic Of', 'wp-econtact'); ?>, <?php _e('Monaco', 'wp-econtact'); ?>, <?php _e('Mongolia', 'wp-econtact'); ?>, <?php _e('Montenegro', 'wp-econtact'); ?>, <?php _e('Montserrat', 'wp-econtact'); ?>, <?php _e('Morocco', 'wp-econtact'); ?>, <?php _e('Mozambique', 'wp-econtact'); ?>, <?php _e('Myanmar', 'wp-econtact'); ?>, <?php _e('Namibia', 'wp-econtact'); ?>, <?php _e('Nauru', 'wp-econtact'); ?>, <?php _e('Nepal', 'wp-econtact'); ?>, <?php _e('Netherlands', 'wp-econtact'); ?>, <?php _e('Netherlands Antilles', 'wp-econtact'); ?>, <?php _e('New Caledonia', 'wp-econtact'); ?>, <?php _e('New Zealand', 'wp-econtact'); ?>, <?php _e('Nicaragua', 'wp-econtact'); ?>, <?php _e('Niger', 'wp-econtact'); ?>, <?php _e('Nigeria', 'wp-econtact'); ?>, <?php _e('Niue', 'wp-econtact'); ?>, <?php _e('Norfolk Island', 'wp-econtact'); ?>, <?php _e('Northern Mariana Islands', 'wp-econtact'); ?>, <?php _e('Norway', 'wp-econtact'); ?>, <?php _e('Oman', 'wp-econtact'); ?>, <?php _e('Pakistan', 'wp-econtact'); ?>, <?php _e('Palau', 'wp-econtact'); ?>, <?php _e('Palestinian Territory, Occupied', 'wp-econtact'); ?>, <?php _e('Panama', 'wp-econtact'); ?>, <?php _e('Papua New Guinea', 'wp-econtact'); ?>, <?php _e('Paraguay', 'wp-econtact'); ?>, <?php _e('Peru', 'wp-econtact'); ?>, <?php _e('Philippines', 'wp-econtact'); ?>, <?php _e('Pitcairn', 'wp-econtact'); ?>, <?php _e('Poland', 'wp-econtact'); ?>, <?php _e('Portugal', 'wp-econtact'); ?>, <?php _e('Puerto Rico', 'wp-econtact'); ?>, <?php _e('Qatar', 'wp-econtact'); ?>, <?php _e('Reunion', 'wp-econtact'); ?>, <?php _e('Romania', 'wp-econtact'); ?>, <?php _e('Russian Federation', 'wp-econtact'); ?>, <?php _e('Rwanda', 'wp-econtact'); ?>, <?php _e('Saint Helena', 'wp-econtact'); ?>, <?php _e('Saint Kitts And Nevis', 'wp-econtact'); ?>, <?php _e('Saint Lucia', 'wp-econtact'); ?>, <?php _e('Saint Pierre And Miquelon', 'wp-econtact'); ?>, <?php _e('Saint Vincent And The Grenadines', 'wp-econtact'); ?>, <?php _e('Samoa', 'wp-econtact'); ?>, <?php _e('San Marino', 'wp-econtact'); ?>, <?php _e('Sao Tome And Principe', 'wp-econtact'); ?>, <?php _e('Saudi Arabia', 'wp-econtact'); ?>, <?php _e('Senegal', 'wp-econtact'); ?>, <?php _e('Serbia', 'wp-econtact'); ?>, <?php _e('Seychelles', 'wp-econtact'); ?>, <?php _e('Sierra Leone', 'wp-econtact'); ?>, <?php _e('Singapore', 'wp-econtact'); ?>, <?php _e('Slovakia', 'wp-econtact'); ?>, <?php _e('Slovenia', 'wp-econtact'); ?>, <?php _e('Solomon Islands', 'wp-econtact'); ?>, <?php _e('Somalia', 'wp-econtact'); ?>, <?php _e('South Africa', 'wp-econtact'); ?>, <?php _e('South Georgia And The South Sandwich Islands', 'wp-econtact'); ?>, <?php _e('Spain', 'wp-econtact'); ?>, <?php _e('Sri Lanka', 'wp-econtact'); ?>, <?php _e('Sudan', 'wp-econtact'); ?>, <?php _e('Suriname', 'wp-econtact'); ?>, <?php _e('Svalbard And Jan Mayen', 'wp-econtact'); ?>, <?php _e('Swaziland', 'wp-econtact'); ?>, <?php _e('Sweden', 'wp-econtact'); ?>, <?php _e('Switzerland', 'wp-econtact'); ?>, <?php _e('Syrian Arab Republic', 'wp-econtact'); ?>, <?php _e('Taiwan, Province Of China', 'wp-econtact'); ?>, <?php _e('Tajikistan', 'wp-econtact'); ?>, <?php _e('Tanzania, United Republic Of', 'wp-econtact'); ?>, <?php _e('Thailand', 'wp-econtact'); ?>, <?php _e('Timor-leste', 'wp-econtact'); ?>, <?php _e('Togo', 'wp-econtact'); ?>, <?php _e('Tokelau', 'wp-econtact'); ?>, <?php _e('Tonga', 'wp-econtact'); ?>, <?php _e('Trinidad And Tobago', 'wp-econtact'); ?>, <?php _e('Tunisia', 'wp-econtact'); ?>, <?php _e('Turkey', 'wp-econtact'); ?>, <?php _e('Turkmenistan', 'wp-econtact'); ?>, <?php _e('Turks And Caicos Islands', 'wp-econtact'); ?>, <?php _e('Tuvalu', 'wp-econtact'); ?>, <?php _e('Uganda', 'wp-econtact'); ?>, <?php _e('Ukraine', 'wp-econtact'); ?>, <?php _e('United Arab Emirates', 'wp-econtact'); ?>, <?php _e('United Kingdom', 'wp-econtact'); ?>, <?php _e('United States', 'wp-econtact'); ?>, <?php _e('United States Minor Outlying Islands', 'wp-econtact'); ?>, <?php _e('Uruguay', 'wp-econtact'); ?>, <?php _e('Uzbekistan', 'wp-econtact'); ?>, <?php _e('Vanuatu', 'wp-econtact'); ?>, <?php _e('Venezuela', 'wp-econtact'); ?>, <?php _e('Viet Nam', 'wp-econtact'); ?>, <?php _e('Virgin Islands, British', 'wp-econtact'); ?>, <?php _e('Virgin Islands, U.S.', 'wp-econtact'); ?>, <?php _e('Wallis And Futuna', 'wp-econtact'); ?>, <?php _e('Western Sahara', 'wp-econtact'); ?>, <?php _e('Yemen', 'wp-econtact'); ?>, <?php _e('Zambia', 'wp-econtact'); ?>, <?php _e('Zimbabwe', 'wp-econtact'); ?></p></div></td>
</tr>
<tr>
<th><?php _e('State', 'wp-econtact'); ?></th>

<td><?php _e('Please enter your state you reside in. State accepts multiple values like tags', 'wp-econtact'); ?>. <?php _e('State does not have a default value', 'wp-econtact'); ?>.<div class="taxdef-block"><p><?php _e('The following are the preset values and value descriptions for <b>State:</b>', 'wp-econtact'); ?></p>
<table class="table tax-table form-table"><tr><td><?php _e('AL', 'wp-econtact'); ?></td>
<td><?php _e('Alabama', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('AK', 'wp-econtact'); ?></td>
<td><?php _e('Alaska', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('AZ', 'wp-econtact'); ?></td>
<td><?php _e('Arizona', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('AR', 'wp-econtact'); ?></td>
<td><?php _e('Arkansas', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('CA', 'wp-econtact'); ?></td>
<td><?php _e('California', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('CO', 'wp-econtact'); ?></td>
<td><?php _e('Colorado', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('CT', 'wp-econtact'); ?></td>
<td><?php _e('Connecticut', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('DE', 'wp-econtact'); ?></td>
<td><?php _e('Delaware', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('DC', 'wp-econtact'); ?></td>
<td><?php _e('District of Columbia', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('FL', 'wp-econtact'); ?></td>
<td><?php _e('Florida', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('GA', 'wp-econtact'); ?></td>
<td><?php _e('Georgia', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('HI', 'wp-econtact'); ?></td>
<td><?php _e('Hawaii', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('ID', 'wp-econtact'); ?></td>
<td><?php _e('Idaho', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('IL', 'wp-econtact'); ?></td>
<td><?php _e('Illinois', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('IN', 'wp-econtact'); ?></td>
<td><?php _e('Indiana', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('IA', 'wp-econtact'); ?></td>
<td><?php _e('Iowa', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('KS', 'wp-econtact'); ?></td>
<td><?php _e('Kansas', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('KY', 'wp-econtact'); ?></td>
<td><?php _e('Kentucky', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('LA', 'wp-econtact'); ?></td>
<td><?php _e('Louisiana', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('ME', 'wp-econtact'); ?></td>
<td><?php _e('Maine', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MD', 'wp-econtact'); ?></td>
<td><?php _e('Maryland', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MA', 'wp-econtact'); ?></td>
<td><?php _e('Massachusetts', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MI', 'wp-econtact'); ?></td>
<td><?php _e('Michigan', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MN', 'wp-econtact'); ?></td>
<td><?php _e('Minnesota', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MS', 'wp-econtact'); ?></td>
<td><?php _e('Mississippi', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MO', 'wp-econtact'); ?></td>
<td><?php _e('Missouri', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('MT', 'wp-econtact'); ?></td>
<td><?php _e('Montana', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NE', 'wp-econtact'); ?></td>
<td><?php _e('Nebraska', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NV', 'wp-econtact'); ?></td>
<td><?php _e('Nevada', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NH', 'wp-econtact'); ?></td>
<td><?php _e('New Hampshire', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NJ', 'wp-econtact'); ?></td>
<td><?php _e('New Jersey', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NM', 'wp-econtact'); ?></td>
<td><?php _e('New Mexico', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NY', 'wp-econtact'); ?></td>
<td><?php _e('New York', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('NC', 'wp-econtact'); ?></td>
<td><?php _e('North Carolina', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('ND', 'wp-econtact'); ?></td>
<td><?php _e('North Dakota', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('OH', 'wp-econtact'); ?></td>
<td><?php _e('Ohio', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('OK', 'wp-econtact'); ?></td>
<td><?php _e('Oklahoma', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('OR', 'wp-econtact'); ?></td>
<td><?php _e('Oregon', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('PA', 'wp-econtact'); ?></td>
<td><?php _e('Pennsylvania', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('RI', 'wp-econtact'); ?></td>
<td><?php _e('Rhode Island', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('SC', 'wp-econtact'); ?></td>
<td><?php _e('South Carolina', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('SD', 'wp-econtact'); ?></td>
<td><?php _e('South Dakota', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('TN', 'wp-econtact'); ?></td>
<td><?php _e('Tennessee', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('TX', 'wp-econtact'); ?></td>
<td><?php _e('Texas', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('UT', 'wp-econtact'); ?></td>
<td><?php _e('Utah', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('VT', 'wp-econtact'); ?></td>
<td><?php _e('Vermont', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('VA', 'wp-econtact'); ?></td>
<td><?php _e('Virginia', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('WA', 'wp-econtact'); ?></td>
<td><?php _e('Washington', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('WV', 'wp-econtact'); ?></td>
<td><?php _e('West Virginia', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('WI', 'wp-econtact'); ?></td>
<td><?php _e('Wisconsin', 'wp-econtact'); ?></td>
</tr>
<tr>
<td><?php _e('WY', 'wp-econtact'); ?></td>
<td><?php _e('Wyoming', 'wp-econtact'); ?></td>
</tr>
</table>
</div></td>
</tr>
<tr>
<th><?php _e('Contact Tag', 'wp-econtact'); ?></th>

<td><?php _e(' Contact Tag accepts multiple values like tags', 'wp-econtact'); ?>. <?php _e('Contact Tag does not have a default value', 'wp-econtact'); ?>.<div class="taxdef-block"><p><?php _e('There are no preset values for <b>Contact Tag:</b>', 'wp-econtact'); ?></p></div></td>
</tr>
</table>
</div>
</div>
</li>
</ul>
</div>
</div>
<?php
}
