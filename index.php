<?php
/*
Plugin Name: Custom Cleaner Profile Plugin
Description: Show a cleaner profile.
Version: 1.0
Author: John Francis dela Vega
*/

defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/includes/class.profile-manager.php';
require_once __DIR__ . '/includes/class.profile-shortcodes.php';

function cleaner_profile_register_plugin()
{
    new CleanerProfile\ProfileManager();
    new CleanerProfile\ProfileShortcodes();
}

add_action('plugins_loaded', 'cleaner_profile_register_plugin');