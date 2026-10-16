
<?php

if (! defined('ABSPATH')) exit;
class lkar_redirector
{

    public function __construct()
    {
        add_action('template_redirect', array($this, 'handle_redirection'));
        add_action('wp_ajax_nopriv_lkar_check_password', array($this, 'check_password'));
        add_action('wp_ajax_lkar_check_password', array($this, 'check_password'));
    }

    public function handle_redirection()
    {

        // Avoid redirection for admin pages.
        if (is_admin()) {
            return;
        }

        $protection_page_id = get_option('lkar_protection_page_id', 0);
        $protected_page_id  = get_option('lkar_page_id', 0);
        $protected_post_id  = get_option('lkar_post_id', 0);

        // Check whether the user already has access to the protected page.
        if (
            $protected_page_id &&
            is_page($protected_page_id) &&
            isset($_COOKIE['lkar_page_id' . $protected_page_id])
        ) {
            return;
        }

        // Check whether the user already has access to the protected post.
        if (
            $protected_post_id &&
            is_single($protected_post_id) &&
            isset($_COOKIE['lkar_post_id' . $protected_post_id])
        ) {
            return;
        }

        // Protected page redirection logic.
        if ($protected_page_id && is_page($protected_page_id)) {

            setcookie(
                'lkar_target_url',
                get_permalink($protected_page_id),
                time() + 3600,
                '/'
            );

            wp_safe_redirect(get_permalink($protection_page_id));
            exit;
        }

        // Protected post redirection logic.
        if (
            is_single() &&
            $protected_post_id &&
            is_single($protected_post_id)
        ) {
            setcookie(
                'lkar_target_url',
                get_permalink($protected_post_id),
                time() + 3600,
                '/'
            );

            wp_safe_redirect(get_permalink($protection_page_id));
            exit;
        }
    }

    public function check_password()
    {

        check_ajax_referer('lkar_frontend_password_nonce', 'nonce');

        $password = isset($_POST['password'])
            ? sanitize_text_field(wp_unslash($_POST['password']))
            : '';

        if (empty($password)) {
            wp_send_json_error(
                array('message' => 'Password is required.')
            );
        }

        $stored_password = get_option('lkar_password_id', '');

        if ($password === $stored_password) {

            setcookie(
                'lkar_access_granted',
                '1',
                time() + 3600,
                '/'
            );

            $redirect_url = isset($_COOKIE['lkar_target_url'])
                ? esc_url_raw(wp_unslash($_COOKIE['lkar_target_url']))
                : home_url();

            // Allow only valid redirect destinations.
            $redirect_url = wp_validate_redirect(
                $redirect_url,
                home_url()
            );

            $page_id = get_option('lkar_page_id', 0);
            $post_id = get_option('lkar_post_id', 0);

            if (
                $page_id &&
                $redirect_url === get_permalink($page_id)
            ) {
                setcookie(
                    'lkar_page_id' . $page_id,
                    '1',
                    time() + 3600,
                    '/'
                );
            }

            if (
                $post_id &&
                $redirect_url === get_permalink($post_id)
            ) {
                setcookie(
                    'lkar_post_id' . $post_id,
                    '1',
                    time() + 3600,
                    '/'
                );
            }

            wp_send_json_success(
                array(
                    'message'      => 'Access granted.',
                    'redirect_url' => $redirect_url,
                )
            );
        } else {

            wp_send_json_error(
                array('message' => 'Incorrect password.')
            );
        }
    }
}
