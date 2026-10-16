<?php

/**
 * Plugin Name:  Lockaire
 * Description: Build a fully custom password-protected page from scratch — your own layout and design instead of WordPress's default plain password form.
 * Version: 1.0.0
 * slug: lockaire
 * Aurthor: kulwindersingh5555
 * License: GPL2 or later
 * Text Domain: lockaire
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'Includes/lkar_autoloader.php';

new lkar_autoloader();
new lkar_enqueue_scripts();
new lkar_shortcode();
new lkar_admin_menu();
new lkar_settings();
new lkar_redirector();


