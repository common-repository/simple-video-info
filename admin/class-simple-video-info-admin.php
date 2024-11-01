<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_Video_Info
 * @subpackage Simple_Video_Info/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Video_Info
 * @subpackage Simple_Video_Info/admin
 * @author     Your Name <email@example.com>
 */
class Simple_Video_Info_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Video_Info_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Video_Info_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-video-info-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Video_Info_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Video_Info_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-video-info-admin.js', array( 'jquery' ), $this->version, false );

    }

    public function display_admin_page() {
        add_options_page(
            'Simple Video Info',
            'Simple Video Info',
            'manage_options',
            'simple-video-info',
            array($this, 'plugin_options_page')
        );
    }
    public function plugin_options_page() {
        include plugin_dir_path( __FILE__ ) . '/partials/simple-video-info-admin-display.php';
    }

    public function plugin_admin_init() {
        register_setting('plugin_options', 'plugin_options', array($this, 'plugin_options_validate'));
        add_settings_section('plugin_main', 'Main Settings', array($this, 'plugin_section_text'), 'plugin');
        add_settings_field('plugin_text_string', 'YouTube Data API Key:', array($this, 'plugin_setting_string'), 'plugin', 'plugin_main');
    }
    public function plugin_section_text() {
        $options = get_option('plugin_options');
    }
    public function plugin_setting_string() {
        $options = get_option('plugin_options');
        echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
    }
    public function plugin_options_validate($input) {
        $newinput['text_string'] = trim($input['text_string']);
        if(!preg_match('/^[a-z0-9]{39}$/i', $newinput['text_string'])) {
            $newinput['text_string'] = 'Key should be exactly 39 characters';
        }
        return $newinput;
    }



}
