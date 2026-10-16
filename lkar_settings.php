
<?php
// Handle the AJAX request to save settings.
if (! defined('ABSPATH')) exit;
class lkar_settings
{

    public function __construct()
    {
        add_action(
            'wp_ajax_lkar_save_settings',
            array($this, 'save_settings')
        );
    }

    public function save_settings()
    {

        // Check nonce for security.
        check_ajax_referer('lkar_save_settings_nonce', 'security');

        // Get and sanitize the posted data.
        $password = isset($_POST['password'])
            ? sanitize_text_field(wp_unslash($_POST['password']))
            : '';

        $protection_page_id = isset($_POST['protection_page_id'])
            ? absint(wp_unslash($_POST['protection_page_id']))
            : 0;

        $page_id = isset($_POST['page_id'])
            ? absint(wp_unslash($_POST['page_id']))
            : 0;

        $post_id = isset($_POST['post_id'])
            ? absint(wp_unslash($_POST['post_id']))
            : 0;

        // Save the settings.
        update_option('lkar_password_id', $password);
        update_option('lkar_protection_page_id', $protection_page_id);
        update_option('lkar_page_id', $page_id);
        update_option('lkar_post_id', $post_id);

        // Send a success response.
        wp_send_json_success(
            array('message' => 'Settings saved successfully.')
        );
    }
}
