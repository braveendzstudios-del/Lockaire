<?php
class lkar_admin_menu {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }

    public function add_plugin_page() {
        add_menu_page(
            'Lockaire', // page title
            'Lockaire', // menu title
            'manage_options', // capability
            'lockaire', // menu slug
            array( $this, 'create_admin_page' ), // callback function
            'dashicons-lock' ,// icon
            

        );
    }

    
    public function create_admin_page() {
      
        $selector = new lkar_admin_selector();
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $selector->render();
    }
}