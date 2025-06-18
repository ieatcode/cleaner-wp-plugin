<?php

namespace CleanerProfile;

/**
 * Class ProfileManager
 *
 * Handles admin menu registration, asset enqueueing, profile data saving, and rendering.
 */
class ProfileManager
{
    /**
     * Constructor.
     *
     * Hooks into WordPress actions for admin menu, asset loading, and profile saving.
     */
    public function __construct()
    {
        // Register the admin menu page
        add_action('admin_menu', [$this, 'add_admin_menu']);
        // Enqueue scripts and styles on the admin page
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        // Handle saving profiles via POST request
        add_action('admin_post_cleaner_save_profiles', [$this, 'save_profiles']);
    }

    /**
     * Adds the plugin's admin options page under Settings.
     */
    public function add_admin_menu()
    {
        add_options_page(
            'Cleaner Profiles',           // Page title
            'Cleaner Profiles',           // Menu title
            'manage_options',             // Capability required
            'cleaner-profiles',           // Menu slug
            [$this, 'render_admin_page']  // Callback to render page
        );
    }

    /**
     * Enqueues necessary CSS and JS assets for the admin page.
     *
     * @param string $hook The current admin page hook.
     */
    public function enqueue_assets($hook)
    {
        // Only load assets on the plugin's admin page
        if ('settings_page_cleaner-profiles' !== $hook) {
            return;
        }

        // Enqueue the main profile card styles
        wp_enqueue_style(
            'cleaner-profile-style',
            plugin_dir_url(__DIR__) . 'assets/css/profile-card.css',
            [], // No dependencies
            '1.0'
        );

        // Enqueue the form-specific styles
        wp_enqueue_style(
            'cpc-profile-form-style',
            plugins_url('assets/css/profile-form.css', __DIR__),
            [],
            '1.0'
        );

        // Enqueue the JavaScript for profile management
        wp_enqueue_script(
            'profile-manager',
            plugins_url('assets/js/profile-manager.js', __DIR__),
            ['jquery'], // Dependencies
            '1.0',
            true // Load in footer
        );
    }

    /**
     * Renders the admin profile management page.
     */
    public function render_admin_page()
    {
        // Retrieve existing profiles or default to empty array
        $profiles = get_option('cleaner_profiles', []);
        // Include the admin page template
        include plugin_dir_path(__FILE__) . 'templates/profiles-admin-page.php';
    }

    /**
     * Handles saving profiles data from the admin form.
     */
    public function save_profiles()
    {
        // Check user capabilities for security
        if ( ! current_user_can('manage_options') ) {
            wp_die('Unauthorized');
        }

        // Validate and sanitize input data
        $hasProfiles = isset($_POST['profiles']) && is_array($_POST['profiles']) && count($_POST['profiles']) > 0;

        if ( $hasProfiles ) {
            // Save the submitted profiles array
            update_option('cleaner_profiles', array_values($_POST['profiles']));
        } else {
            // Clear profiles if none submitted
            update_option('cleaner_profiles', []);
        }

        // Redirect back to the admin page with an update message
        wp_redirect( admin_url('options-general.php?page=cleaner-profiles&updated=1') );
        exit;
    }
}