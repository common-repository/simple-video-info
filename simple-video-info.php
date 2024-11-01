<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://studioaceofspade.com
 * @since             1.0.0
 * @package           Simple_Video_Info
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Video Info
 * Plugin URI:        http://studioaceofspade.com/simple-video-info-uri/
 * Description:       A simple way to get stats from any YouTube or Vimeo video. Includes number of plays, comments, likes, title, description, thumbnail and more.
 * Version:           1.0.0
 * Author:            Studio Ace of Spade
 * Author URI:        http://studioaceofspade.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-video-info
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-video-info-activator.php
 */
function activate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-video-info-activator.php';
    Simple_Video_Info_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-video-info-deactivator.php
 */
function deactivate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-video-info-deactivator.php';
    Simple_Video_Info_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-video-info.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

    $plugin = new Simple_Video_Info();
    $plugin->run();

}
run_plugin_name();
