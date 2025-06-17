<?php

namespace CleanerProfile;

class ProfileManager
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_post_cleaner_save_profiles', [$this, 'save_profiles']);
    }

    public function add_admin_menu()
    {
        add_options_page(
            'Cleaner Profiles',
            'Cleaner Profiles',
            'manage_options',
            'cleaner-profiles',
            [$this, 'render_admin_page']
        );
    }

    public function enqueue_assets($hook)
    {
        if ('settings_page_cleaner-profiles' !== $hook) {
            return;
        }

        wp_enqueue_style('cleaner-profile-style', plugin_dir_url(__DIR__) . 'assets/css/profile-card.css', [], '1.0');

        wp_enqueue_style(
            'cpc-profile-form-style',
            plugins_url('assets/css/profile-form.css', __DIR__),
            [],
            '1.0'
        );

        wp_enqueue_script('profile-manager', plugins_url('assets/js/profile-manager.js', __DIR__), ['jquery'], '1.0', true);

    }


    public function render_admin_page()
    {
        $profiles = get_option('cleaner_profiles', []);
        include plugin_dir_path(__FILE__) . 'templates/profiles-admin-page.php';
    }

    public function save_profiles()
    {
        if (!current_user_can('manage_options')) wp_die('Unauthorized');

        $hasProfiles = isset($_POST['profiles']) && is_array($_POST['profiles']) && count($_POST['profiles']) > 0;

        if ($hasProfiles) {
            update_option('cleaner_profiles', array_values($_POST['profiles']));
        } else {
            update_option('cleaner_profiles', []);
        }
        wp_redirect(admin_url('options-general.php?page=cleaner-profiles&updated=1'));
        exit;
    }

}