# Cleaner Profile WordPress Plugin

## Transform your profiles into sleek, customizable, and responsive profile cards with easy shortcode integration.

___

### Features

- Display profiles as elegant, mobile-friendly cards
- Responsive layout with CSS Grid and Flexbox
- Fully customizable profile attributes: name, photo, bio, schedule, ratings
- No external dependencies required
- Easy to extend and style with SCSS/CSS

### Installation

1. Upload the plugin folder to your WordPress wp-content/plugins/ directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Enqueue or customize styles as needed.

---

### Usage
Shortcode to display a profile card:
```
[profile_cards][/profile_cards]
```

---
### Customization

- Style profiles with your own SCSS/CSS by editing assets/css/profile-card.scss.
- Extend the PHP shortcode handler for more attributes or features.
- Use hooks and filters to add extra profile fields.


### Admin Interface
- Access the admin interface to manage profiles via the WordPress Settings -> Cleaner Profiles
- Click "Add New Profile" to create a new profile card.
- Delete profiles by clicking the "Delete" button next to each profile.
- Click "Save Profiles" to save all the changes made.

---
### Notes
- Profiles are stored in the WordPress options table; data persists across updates.
- For best results, style the profile cards using the provided CSS classes.


---
## Testing 

### Unit Tests

This plugin includes PHPUnit tests to help ensure code quality and functionality.

### Prerequisites
- PHP 8.0 or higher
- Composer (for managing dependencies)
- PHPUnit (installed via Composer)

### Setup

- **Install PHPUnit via Composer**

Navigate to your plugin root directory and run:

```bash
composer require --dev phpunit/phpunit ^10
```

### Run Tests
Execute the tests with:
```bash
vendor/bin/phpunit
```

### Notes
- Tests are located in the /tests directory.