<?php

require_once __DIR__ . '/../includes/class.profile-shortcodes.php';

use PHPUnit\Framework\TestCase;

/**
 * PHPUnit Test for the ProfileShortcodes class.
 * Validates that profile rendering produces expected HTML output.
 */
class ProfileShortcodesTest extends TestCase
{
    /**
     * Test that render_profiles() outputs correct HTML for given profiles.
     */
    public function testRenderProfilesReturnsHtml()
    {
        // Instantiate the ProfileShortcodes class
        $shortcodes = new CleanerProfile\ProfileShortcodes();

        // Prepare sample profile data with all necessary attributes
        $profiles = [
            [
                'name' => 'Alice',
                'photo_url' => 'https://example.com/alice.jpg',
                'bio' => 'Bio of Alice.',
                'schedule' => 'Weekdays 9-5',
                'rating' => '4.7',
                'reviews' => '23'
            ],
            [
                'name' => 'Bob',
                'photo_url' => 'https://example.com/bob.jpg',
                'bio' => 'Bio of Bob.',
                'schedule' => 'Weekends 10-4',
                'rating' => '4.2',
                'reviews' => '15'
            ],
        ];

        // Store profiles in WordPress options (simulate database state)
        update_option('cleaner_profiles', $profiles);

        // Generate HTML output for profiles
        $html = $shortcodes->render_profiles();

        // Assertions: verify key profile details are present in the output
        $this->assertStringContainsString('Alice', $html, 'Profile name Alice not found in output.');
        $this->assertStringContainsString('Bob', $html, 'Profile name Bob not found in output.');
        $this->assertStringContainsString('https://example.com/alice.jpg', $html, 'Alice photo URL not found in output.');
        $this->assertStringContainsString('Bio of Alice.', $html, 'Alice bio not found in output.');
        $this->assertStringContainsString('Weekdays 9-5', $html, 'Alice schedule not found in output.');
        $this->assertStringContainsString('4.7', $html, 'Alice rating not found in output.');
        $this->assertStringContainsString('(23 reviews)', $html, 'Alice reviews count not found in output.');
    }
}