<?php

namespace CleanerProfile;

class ProfileShortcodes
{
    /**
     * Constructor.
     *
     * Hooks into WordPress actions:
     * - Registers shortcode to render profiles.
     * - Enqueues front-end styles.
     */
    public function __construct()
    {
        // Register shortcode [profile_cards]
        add_shortcode('profile_cards', [$this, 'render_profiles']);
        // Enqueue styles/scripts on front-end
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_styles']);
    }

    /**
     * Enqueues CSS styles for the profile cards.
     */
    public function enqueue_frontend_styles()
    {
        wp_enqueue_style(
            'cleaner-profile-frontend-style',
            plugin_dir_url(__DIR__) . 'assets/css/profile-card.css',
            [],
            '1.0'
        );
        wp_enqueue_style(
            'cpc-profile-form-style',
            plugins_url('assets/css/profile-form.css', __DIR__),
            [],
            '1.0'
        );
        wp_enqueue_script(
            'profile-manager',
            plugins_url('assets/js/profile-manager.js', __DIR__),
            ['jquery'],
            '1.0',
            true
        );
    }

    /**
     * Renders the profiles list as HTML.
     *
     * Fetches profiles from the database and outputs each as a card.
     *
     * @return string The generated HTML markup for profiles.
     */
    public function render_profiles()
    {
        $profiles = get_option('cleaner_profiles', []);
        if (empty($profiles)) return 'No profiles added.';
        $output = '<div class="cleaner-profile-wrapper">';
        foreach ($profiles as $profile) {
            $output .= $this->render_profile_card($profile);
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * Renders a single profile card HTML.
     *
     * Escapes output properly for security.
     *
     * @param array $profile Associative array with profile data.
     * @return string The HTML markup for a profile card.
     */
    private function render_profile_card($profile)
    {
        // Assign default placeholder if photo_url missing
        $photo_url = $profile['photo_url'] ?? 'https://via.placeholder.com/150';

        // Retrieve profile data with fallback defaults
        $name = $profile['name'] ?? '';
        $bio = $profile['bio'] ?? '';
        $schedule = $profile['schedule'] ?? '';
        $rating = isset($profile['rating']) ? floatval($profile['rating']) : 0;
        $reviews = isset($profile['reviews']) ? intval($profile['reviews']) : 0;

        // Generate star icons based on rating
        $stars_html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                $stars_html .= '<span class="star">&#9733;</span>'; // full star
            } elseif ($rating >= $i - 0.5) {
                // treat half as full for simplicity
                $stars_html .= '<span class="star">&#9733;</span>';
            } else {
                $stars_html .= '<span class="star">&#9734;</span>'; // empty star
            }
        }

        // Output the profile card with sanitized data
        return sprintf(
            '<div class="cleaner-card">
                <img src="%s" alt="%s" class="cleaner-photo" loading="lazy"  onerror="this.onerror=null; this.src=\'%s\';" />
                <div class="cleaner-meta">
                    <div class="cleaner-rating-review">
                        <span class="stars">%s</span>
                        <span class="rating">%.1f</span>
                        <span class="reviews">(%d reviews)</span>
                    </div>
                    <h2 class="cleaner-name">%s</h2>
                    <div class="cleaner-bio">%s</div>
                    <div class="cleaner-schedule">
                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Schedule icon SVG path -->
                            <path d="M9 1.4375C7.40539 1.4375 5.84659 1.91036 4.52072 2.79628C3.19485 3.6822 2.16146 4.94139 1.55122 6.41461C0.940993 7.88784 0.781329 9.50894 1.09242 11.0729C1.40352 12.6369 2.17139 14.0735 3.29895 15.201C4.42652 16.3286 5.86312 17.0965 7.42709 17.4076C8.99106 17.7187 10.6122 17.559 12.0854 16.9488C13.5586 16.3385 14.8178 15.3052 15.7037 13.9793C16.5896 12.6534 17.0625 11.0946 17.0625 9.5C17.0625 7.36169 16.2131 5.31096 14.7011 3.79895C13.189 2.28694 11.1383 1.4375 9 1.4375ZM9 16.4375C7.62429 16.4375 6.2795 16.0294 5.13585 15.2647C3.99219 14.5001 3.10108 13.4134 2.57531 12.1421C2.04953 10.8709 1.91273 9.47217 2.18221 8.12311C2.45169 6.77405 3.11535 5.53526 4.08917 4.56353C5.063 3.59181 6.30322 2.93083 7.65286 2.66427C9.0025 2.3977 10.4009 2.53752 11.671 3.06604C12.9412 3.59456 14.026 4.48802 14.7881 5.63332C15.5502 6.77862 15.9555 8.12429 15.9525 9.5C15.9505 11.3433 15.2174 13.1106 13.914 14.414C12.6106 15.7174 10.8433 16.4505 9 16.4525V16.4375ZM12.75 9.5C12.75 9.64719 12.6915 9.78836 12.5874 9.89244C12.4834 9.99653 12.3422 10.055 12.195 10.055H9C8.85281 10.055 8.71164 9.99653 8.60756 9.89244C8.50348 9.78836 8.445 9.64719 8.445 9.5V4.94C8.445 4.7928 8.50348 4.65164 8.60756 4.54756C8.71164 4.44347 8.85281 4.385 9 4.385C9.1472 4.385 9.28837 4.44347 9.39245 4.54756C9.49653 4.65164 9.555 4.7928 9.555 4.94V8.945H12.2175C12.3608 8.95081 12.4962 9.01184 12.5955 9.1153C12.6947 9.21876 12.7501 9.35662 12.75 9.5Z" fill="#99A1B7"/>
                        </svg>
                        <span>%s</span>
                    </div>
                </div>
            </div>',
            esc_url($photo_url),
            esc_attr($name),
            plugins_url('assets/img/cleaner.jpg', __DIR__),
            $stars_html,
            $rating,
            $reviews,
            esc_html($name),
            esc_html($bio),
            esc_html($schedule)
        );
    }
}