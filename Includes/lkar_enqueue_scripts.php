
<?php

if (! defined('ABSPATH')) exit;
class lkar_enqueue_scripts
{

    public function __construct()
    {
        add_action(
            'admin_enqueue_scripts',
            array($this, 'enqueue_admin_scripts')
        );

        add_action(
            'wp_enqueue_scripts',
            array($this, 'frontend_enqueue_scripts')
        );
    }

    /**
     * Get an asset version for browser cache invalidation.
     *
     * @param string $relative_path Asset path relative to this file.
     * @return string
     */
    private function get_asset_version($relative_path)
    {

        $asset_path = plugin_dir_path(__FILE__) . $relative_path;

        if (file_exists($asset_path)) {
            return (string) filemtime($asset_path);
        }

        return '1.0.0';
    }

    public function enqueue_admin_scripts()
    {

        $admin_style_path = '../Assets/css/lkar-admin-style.css';
        $admin_script_path = '../Assets/js/lkar-admin-script.js';
        $admin_frontend_script_path = '../Assets/js/lkar-admin-frontend-script.js';

        wp_enqueue_style(
            'lkar-admin-style',
            plugin_dir_url(__FILE__) . $admin_style_path,
            array(),
            $this->get_asset_version($admin_style_path)
        );

        wp_enqueue_script(
            'lkar-admin-script',
            plugin_dir_url(__FILE__) . $admin_script_path,
            array('jquery'),
            $this->get_asset_version($admin_script_path),
            true
        );

        wp_enqueue_script(
            'lkar-admin-frontend-script',
            plugin_dir_url(__FILE__) . $admin_frontend_script_path,
            array('jquery'),
            $this->get_asset_version($admin_frontend_script_path),
            true
        );

        // Localize the admin script.
        wp_localize_script(
            'lkar-admin-script',
            'lkar_ajax_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('lkar_save_settings_nonce'),
            )
        );
    }

    public function frontend_enqueue_scripts()
    {

        $frontend_style_path = '../Assets/css/lkar-frontend-styles.css';
        $frontend_script_path = '../Assets/js/lkar-frontend-password-script.js';

        wp_enqueue_style(
            'lkar-frontend-styles',
            plugin_dir_url(__FILE__) . $frontend_style_path,
            array(),
            $this->get_asset_version($frontend_style_path)
        );

        wp_enqueue_script(
            'lkar-frontend-password-script',
            plugin_dir_url(__FILE__) . $frontend_script_path,
            array('jquery'),
            $this->get_asset_version($frontend_script_path),
            true
        );

        // Load Dashicons.
        wp_enqueue_style('dashicons');

        wp_localize_script(
            'lkar-frontend-password-script',
            'lkar_frontend_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('lkar_frontend_password_nonce'),
            )
        );
    }
}
