<?php



function hkah_firstname_shortcode_func( $atts ) {
	global $hkUser;
  $atts = shortcode_atts( array(
		'foo' => 'no foo',
		'baz' => 'default baz'
	), $atts, 'bartag' );

  return $hkUser->getFirstName();
}
add_shortcode( 'firstname', 'hkah_firstname_shortcode_func' );


function hkah_office_shortcode_func( $atts ) {
  $atts = shortcode_atts( array(
		'icon' => 'teams',
		'name' => 'Teams',
		'link' => 'https://teams.microsoft.com/',
		'target' => '_blank',
	), $atts, 'office' );

	$ret = '<a class="hk-office-logo-wrapper rek-link-listener" data-rek-beskrivning="Office" href="' . $atts['link'] . '" target="' . $atts['target'] . '"><span class="hk-' . $atts['icon'] . ' hk-office-logo"></span><span class="hk-office-text">' . $atts['name'] . '</span></a>';
  return $ret;
}
add_shortcode( 'office', 'hkah_office_shortcode_func' );

function hkah_office_links_shortcode_func( $atts ) {
	$office_array = hkah_office_data();
	$ret = "<div class='rek-link-listener' data-rek-pagetype='office'>";
	foreach ($office_array as $key => $value) {
		$ret .= '<a class="hk-office-logo-wrapper hk-' . $value['icon'] . '-tooltip rek-link-listener" data-rek-beskrivning="' .  $value['icon'] . '" href="' . $value['link'] . '" target="' . $value['target'] . '"><span class="hk-' . $value['icon'] . ' hk-office-logo"></span><span class="hk-office-text">' . $value['name'] . '</span></a>';

	}
	$ret .= "</div>";

  return $ret;
}
add_shortcode( 'office-links', 'hkah_office_links_shortcode_func' );

function hkah_opene_links_shortcode_func( $atts ) {

	//$jsonurl = 'https://internservice.hultsfred.se/api/v1/getflows/json/';
	//$jsondata = file_get_contents($jsonurl);
	//$jsonarray = json_decode($jsondata);


	$ret = "<div class='opene-wrapper rek-link-listener' data-rek-pagetype='opene'>Bara test";

	//$ret .= print_r($jsonarray,1);
	/*foreach ($office_array as $key => $value) {
		$ret .= '<a class="hk-office-logo-wrapper hk-' . $value['icon'] . '-tooltip rek-link-listener" data-rek-beskrivning="' .  $value['icon'] . '" href="' . $value['link'] . '" target="' . $value['target'] . '"><span class="hk-' . $value['icon'] . ' hk-office-logo"></span><span class="hk-office-text">' . $value['name'] . '</span></a>';

	}*/
	$ret .= "</div>";

  return $ret;
}
add_shortcode( 'opene-links', 'hkah_opene_links_shortcode_func' );
