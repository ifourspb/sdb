<?php
$vito_theme_data = wp_get_theme();
return array(
	'theme_name' => $vito_theme_data['Name'], 
	'theme_slug' => sanitize_title($vito_theme_data['Name']),
	'theme_author' => $vito_theme_data['Author'],
	'theme_author_uri' => $vito_theme_data['AuthorURI'],
	'theme_version' => $vito_theme_data['Version'],
	'required_wp_version' => '3.1'
);