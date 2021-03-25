<?php
/*
Plugin Name: HK Anstalld Helper
Plugin URI: http://wordpress.org/extend/plugins/hk-anstalld-helper/
Description:
Author: jonashjalmarsson
Version: 0.1
Author URI: http://www.hultsfred.se
*/

/*  Copyright 2020 Jonas Hjalmarsson (email: jonas.hjalmarsson@hultsfred.se)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/




/* include options page */
include( plugin_dir_path( __FILE__ ) . 'hk-anstalld-helper-options.php');
/* include user class */
include( plugin_dir_path( __FILE__ ) . 'hk-anstalld-helper-user-class.php');
/* include shortcode */
include( plugin_dir_path( __FILE__ ) . 'hk-anstalld-helper-shortcode.php');

add_action('init', 'hkah_plugin_init');
add_action('wp_loaded', 'hkah_plugin_loaded');
add_action('wp_head', 'hkah_head_function');
add_action('wp_enqueue_scripts', 'hkah_enqueue_script');
register_activation_hook( __FILE__, 'hkah_dependentplugin_activate' );

$hkUser = null;

/* init plugin */
function hkah_plugin_init() {
  load_plugin_textdomain( 'hkah-plugin', false, 'hk-anstalld-helper/languages' );

  /* remove admin bar for subscribers */
  if ( !current_user_can('administrator') ) {
    add_filter('show_admin_bar', '__return_false');
  }

}

function hkah_plugin_loaded() {
  global $hkUser;
  if (empty($hkUser)) {
    $hkUser = new HKUser();
  }

  /* FILTERS */
  add_filter( 'body_class', function( $classes ) {
    global $hkUser; return array_merge( $classes, $hkUser->getCssIsClasses() );
  } );


}



/* add html head function */
function hkah_head_function() {
  $user = get_user_meta(get_current_user_id());
  ?>
  <!-- Hotjar Tracking Code for https://backstage.hultsfred.se -->
  <script>
      (function(h,o,t,j,a,r){
          h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
          h._hjSettings={hjid:1728140,hjsv:6};
          a=o.getElementsByTagName('head')[0];
          r=o.createElement('script');r.async=1;
          r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
          a.appendChild(r);
      })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
  </script>
  <?php
}


/* add html head function */
function hkah_enqueue_script() {
  global $hkUser;
  if (empty($hkUser)) {
    $hkUser = new HKUser();
  }
  $user = $hkUser->getUserObject();

	$options = get_option('hkah_options');

  wp_enqueue_style( 'hkah_bootstrap_style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
  wp_register_script( 'hkah_bootstrap_script', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js' , array('jquery'));
  wp_enqueue_script( 'hkah_bootstrap_script' );

  $version = 12;
	wp_enqueue_style( 'hkah_style', plugin_dir_url( __FILE__ ) . 'css/hk-anstalld-helper.css', array(), $version);
  wp_register_script( 'hkah_script', plugin_dir_url( __FILE__ ) . 'js/hk-anstalld-helper.js' , array('jquery'), $version);

	$translation_array = array(
		'title'           => __( 'Hultsfreds kommun',             'hkah-plugin' ),
		'button_title'    => __( $options['hkah_button_title'],   'hkah-plugin' ),
		'iframe_src'      => __( $options['hkah_iframe_src'],     'hkah-plugin' ),
    'avatar_src'      => __( $options['hkah_avatar_src'],     'hkah-plugin' ),
    'bubble_text'     => __( $options['hkah_bubble_text'],    'hkah-plugin' ),
    'user_title'      => __( $user['title'],                  'hkah-plugin' ),
    'user_office'     => __( $user['office'],                 'hkah-plugin' ),
    'user_department' => __( $user['department'],             'hkah-plugin' ),
    'user_company'    => __( $user['company'],                'hkah-plugin' ),
    'tooltip'         => hkah_tooltip_get_js_data());
	wp_localize_script( 'hkah_script', 'hkah_js_object', $translation_array );
  wp_enqueue_script( 'hkah_script' );
}


function hkah_tooltip_get_js_data() {
  $tooltip_array = array();

  while( have_rows('tooltip','option') ) {
    the_row();
    $key = get_sub_field('key');
    $tooltip = get_sub_field('tooltip');
    $placement = get_sub_field('placement');
    $type = get_sub_field('type');
    $show = get_sub_field('showhide');
    $questionmark = get_sub_field('questionmark');

    if ($show) {
      $tooltip_array[] = array("key" => $key, "title" => $tooltip, "placement" => $placement, "type" => $type, "questionmark" => $questionmark);
    }

	}

  return $tooltip_array;
}


function hkah_office_data() {
  $office_array = array();

  while( have_rows('office','option') ) {
    the_row();
    $icon = get_sub_field('icon');
    $name = get_sub_field('name');
    $link = get_sub_field('link');
    $show = get_sub_field('showhide');

    if ($show) {
      $office_array[] = array('icon' => $icon, 'name' => $name, 'link' => $link, 'target' => '_blank');
    }

	}

  return $office_array;

}


/* check dependencies */
function hkah_dependentplugin_activate()
{
}




?>
