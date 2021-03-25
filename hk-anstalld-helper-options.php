<?php
add_action('admin_init', 'hkah_options_init' );
add_action('admin_menu', 'hkah_options_add_page');

// Init plugin options to white list our options
function hkah_options_init() {
	register_setting( 'hkah_options_options', 'hkah_options', 'hkah_options_validate' );
}

// Add menu page
function hkah_options_add_page() {
	add_options_page('Anstalld Helper Settings', 'Anstalld Helper Settings', 'manage_options', 'hkah_options', 'hkah_options_do_page') ;
}



// Draw the menu page itself
function hkah_options_do_page() {
	global $wpdb;

	?>
	<div class="wrap">
		<h2>Settings for Anstalld Helper</h2>
		<form id="form_hkah_options" method="post" action="options.php">


			<?php settings_fields('hkah_options_options'); ?>
			<?php $options = get_option('hkah_options');
			//echo "<br>update_categories  : " . $options["update_categories"];
			//echo "<br>enable_cron  : " . $options["enable_cron"];
			//echo "<br>update_products  : " . $options["update_products"];
			?>
			<p><label for="hkah_options[hkah_iframe_src]">Iframe att bädda in</label><br/>
			<input size="80" type="text" name="hkah_options[hkah_iframe_src]" value="<?php echo $options['hkah_iframe_src']; ?>" /></p>
			<p><label for="hkah_options[hkah_iframe_src]">Avatar / Ikon</label><br/>
			<input size="80" type="text" name="hkah_options[hkah_avatar_src]" value="<?php echo $options['hkah_avatar_src']; ?>" /></p>
			<p><label for="hkah_options[hkah_iframe_src]">Chat-text (som alt-text eller om ingen avatar är inlagd)</label><br/>
			<input size="80" type="text" name="hkah_options[hkah_button_title]" value="<?php echo $options['hkah_button_title']; ?>" /></p>
			<p><label for="hkah_options[hkah_bubble_text]">Bubble text</label><br/>
			<input size="80" type="text" name="hkah_options[hkah_bubble_text]" value="<?php echo $options['hkah_bubble_text']; ?>" /></p>


			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}



?>
