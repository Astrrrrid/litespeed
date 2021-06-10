<?php
/**
 * Plugin Name:       GDPR Yummy Cookie
 * Description:       A simple plugin for GDPR compliance
 * Version:           1.0.1
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       easy-gdpr
 *
 * Copyright (C) 2020 Astrid Wang
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

add_action('wp_enqueue_scripts', 'get_css');
function get_css() {
	wp_register_style('get_css', plugins_url('cookie_gdpr.css',__FILE__ ),array(),1.034);
	wp_enqueue_style('get_css');}
	function gdpr_yummy_cookie() {
		$path = dirname(__FILE__);
		echo file_get_contents( $path . '/test.html' );
	}

	if ( ! isset( $_COOKIE[ 'gdpr_yummy_cookie' ] ) ) {
		add_action( 'wp_footer', 'gdpr_yummy_cookie', 100 );
	}

/*
add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);

function addPluginAdminMenu() {
//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
add_menu_page(  $this->plugin_name, 'Plugin Name', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-chart-area', 26 );

//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
add_submenu_page( $this->plugin_name, 'Plugin Name Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
}
*/



class GDPR_yummy_cookie{
    // Our code will go here

//add_action('admin_menu', array( $this, 'addPluginAdminMenu' ),9);
	public function __construct() {
    // Hook into the admin menu
		add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );
		add_action( 'admin_init', array( $this, 'setup_fields' ) );
	}
	public function create_plugin_settings_page() {
    // Add the menu item and page
		$page_title = 'My Awesome Settings Page';
		$menu_title = 'GDPR Yummy Cookie';
		$capability = 'manage_options';
		$slug = 'smashing_fields';
		$callback = array( $this, 'plugin_settings_page_content' );
		$icon = 'dashicons-admin-plugins';
		$position = 100;

		add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
	}
	public function setup_sections() {
    //add_settings_section( 'our_first_section', 'My First Section Title', false, 'smashing_fields' );
		add_settings_section( 'our_first_section', 'My First Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
		add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
		add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
	}



	public function section_callback( $arguments ) {
		switch( $arguments['id'] ){
			case 'our_first_section':
			echo 'This is the first description here!';
			break;
			case 'our_second_section':
			echo 'This one is number two';
			break;
			case 'our_third_section':
			echo 'Third time is the charm!';
			break;
		}
	}


	public function plugin_settings_page_content() {
		echo 'Hello Astrid!';
		$this->page_sections = array();
// Must run after wp's `option_update_filter()`, so priority > 10
		add_action( 'whitelist_options', array( $this, 'whitelist_custom_options_page' ),11 );

		?>
		<div class="wrap">
			<h2>My Awesome Settings Page</h2>
			<img src="https://emoji.gg/assets/emoji/BlobbleWobble.gif" width="75px" height="75px" alt="BlobbleWobble">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'smashing_fields' );
				do_settings_sections( 'smashing_fields' );
				submit_button();
				?>
			</form>
			</div> <?php
		}
		public function setup_fields() {

    // Check which type of field we want
			$fields = array(
				array(
					'uid' => 'our_first_field',
					'label' => 'Awesome Date',
					'section' => 'our_first_section',
					'type' => 'text',
					'options' => false,
					'placeholder' => 'DD/MM/YYYY',
					'helper' => 'Does this help?',
					'supplemental' => 'I am underneath!',
					'default' => '01/01/2015'
				),
				array(
					'uid' => 'our_second_field',
					'label' => 'Awesome Date',
					'section' => 'our_first_section',
					'type' => 'textarea',
					'options' => false,
					'placeholder' => 'DD/MM/YYYY',
					'helper' => 'Does this help?',
					'supplemental' => 'I am underneath!',
					'default' => '01/01/2015'
				),
				array(
					'uid' => 'our_third_field',
					'label' => 'Awesome Select',
					'section' => 'our_first_section',
					'type' => 'select',
					'options' => array(
						'yes' => 'Yeppers',
						'no' => 'No way dude!',
						'maybe' => 'Meh, whatever.'
					),
					'placeholder' => 'Text goes here',
					'helper' => 'Does this help?',
					'supplemental' => 'I am underneath!',
					'default' => 'maybe'
				)
			);
			foreach( $fields as $field ){
				add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'smashing_fields', $field['section'], $field );
				register_setting( 'smashing_fields', $field['uid'] );
			}
		}

		public function field_callback( $arguments ) {
		    $value = get_option( $arguments['uid'] ); // Get the current value, if there is one
    if( ! $value ) { // If no value exists
        $value = $arguments['default']; // Set to our default
    }


    switch( $arguments['type'] ){
    case 'text': // If it is a text field
    printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
    break;
    case 'textarea': // If it is a textarea
    printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
    break;
    case 'select': // If it is a select dropdown
    if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
    	$options_markup = '‘';
    	foreach( $arguments['options'] as $key => $label ){
    		$options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
    	}
    	printf( '<select name="%1$s" id="%1$s">%2$s</select>', $arguments['uid'], $options_markup );
    }
    break;
}


    // If there is help text
if( $helper = $arguments['helper'] ){
        printf( '<span class="helper"> %s</span>', $helper ); // Show it
    }

    // If there is supplemental text
    if( $supplimental = $arguments['supplemental'] ){
        printf( '<p class="description">%s</p>', $supplimental ); // Show it
    }
}
public function whitelist_custom_options_page( $whitelist_options ){
    // Custom options are mapped by section id; Re-map by page slug.
	foreach($this->page_sections as $page => $sections ){
		$whitelist_options[$page] = array();
		foreach( $sections as $section )
			if( !empty( $whitelist_options[$section] ) )
				foreach( $whitelist_options[$section] as $option )
					$whitelist_options[$page][] = $option;
			}
			return $whitelist_options;
		}

// Wrapper for wp's `add_settings_section()` that tracks custom sections
		private function add_settings_section( $id, $title, $cb, $page ){
			add_settings_section( $id, $title, $cb, $page );
			if( $id != $page ){
				if( !isset($this->page_sections[$page]))
					$this->page_sections[$page] = array();
				$this->page_sections[$page][$id] = $id;
			}
		}
	}
	new GDPR_yummy_cookie();


//$path_css = dirname(__FILE__);
//echo file_get_contents($path_css.'/cookie.css');
// setcookie( 'lehancookie', 'delicous' );
// var_dump($_COOKIE[ 'lehancookie' ]);
// var_dump($_COOKIE,'------------');
// MVC model view controller