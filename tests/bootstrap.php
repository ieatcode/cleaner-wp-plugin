<?php
/**
 * Bootstrap file for PHPUnit tests.
 *
 * This script loads the WordPress environment to enable PHPUnit tests to run in a
 * realistic WordPress context. It includes the core `wp-load.php` file, which
 * initializes WordPress, plugins, themes, and the database connection.
 *
 * Adjust the relative path to `wp-load.php` if your directory structure differs.
 *
 * Usage:
 * Run PHPUnit with this bootstrap to ensure your tests have access to WordPress functions.
 *
 * Example:
 * phpunit --bootstrap tests/bootstrap.php
 */
require_once __DIR__ . '/../../../../wp-load.php';