<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Delete all plugin options from the database
delete_option( 'lkar_password_id' );
delete_option( 'lkar_protection_page_id' );
delete_option( 'lkar_page_id' );
delete_option( 'lkar_post_id' );
