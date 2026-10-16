<?php
class lkar_enqueue_scripts {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue_scripts' ) );
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_style( 'lkar-admin-style', plugin_dir_url( __FILE__ ) . '../Assets/css/lkar-admin-style.css' );
        



        wp_enqueue_script( 'lkar-admin-script', plugin_dir_url( __FILE__ ) . '../Assets/js/lkar-admin-script.js', 
        array( 'jquery' ), null, true );
        wp_enqueue_script( 'lkar-admin-frontend-script', plugin_dir_url( __FILE__ ) . '../Assets/js/lkar-admin-frontend-script.js',
         array('jquery'), null, true );

        // Localize the script with new data
        wp_localize_script( 'lkar-admin-script', 'lkar_ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce('lkar_save_settings_nonce' ),
        ) );
   
    }

    public function frontend_enqueue_scripts() {
        wp_enqueue_style( 'lkar-frontend-styles', plugin_dir_url( __FILE__ ) . 
        '../Assets/css/lkar-frontend-styles.css' );
        wp_enqueue_script( 'lkar-frontend-password-script', plugin_dir_url( __FILE__ ) . 
        '../Assets/js/lkar-frontend-password-script.js', array('jquery'), null, true );

        // Load dashicons
        wp_enqueue_style(
            'dashicons'
        );

        wp_localize_script( 'lkar-frontend-password-script', 'lkar_frontend_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'lkar_frontend_password_nonce' ),
        ) );

      
       
    }
    
}