<div class="wrap">
    <!-- Page Title -->
    <h1>Manage Cleaner Profiles</h1>

    <!-- Button to toggle the add new profile form -->
    <button type="button" id="toggle-add-profile" class="button-primary">Add New Profile</button>

    <!-- Container for the "Add New Profile" form, initially hidden -->
    <div id="add-profile-container" style="display: none; margin: 20px 0;">
        <h2 style="margin-top:30px;">Add New Profile</h2>
        <!-- Form for creating a new profile -->
        <form class="profile-form" onsubmit="return false;">
            <!-- Profile Name -->
            <p>
                <label for="new_name">Name</label>
                <input type="text" id="new_name" placeholder="Enter full name" required>
            </p>
            <!-- Photo URL -->
            <p>
                <label for="new_photo_url">Photo URL</label>
                <input type="text" id="new_photo_url" placeholder="https://..." required>
            </p>
            <!-- Bio -->
            <p>
                <label for="new_bio">Bio</label>
                <textarea id="new_bio" placeholder="Short bio" rows="3" required></textarea>
            </p>
            <!-- Schedule -->
            <p>
                <label for="new_schedule">Schedule</label>
                <input type="text" id="new_schedule" placeholder="e.g., Weekdays: 9am-5pm" required>
            </p>
            <!-- Rating Input -->
            <p>
                <label for="new_rating">Rating (0-5)</label>
                <input type="number" step="0.5" min="0" max="5" id="new_rating" value="5" required>
            </p>
            <!-- Reviews Count -->
            <p>
                <label for="new_reviews">Reviews Count</label>
                <input type="number" min="0" id="new_reviews" value="0" required>
            </p>
            <!-- Button to add profile (client-side; will add a new card dynamically) -->
            <button type="button" id="add-profile-btn" class="button-primary">Add Profile</button>
        </form>
    </div>

    <!-- Form for saving profiles; posts data back to WordPress admin -->
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="profiles-form">
        <!-- Action identifier for PHP handler -->
        <input type="hidden" name="action" value="cleaner_save_profiles"/>

        <!-- Profiles grid container: holds all profile "cards" -->
        <div class="profiles-grid">
            <?php foreach ($profiles as $index => $profile) : ?>
                <!-- Each profile "card" with data-index for reference -->
                <div class="profile-form" data-index="<?php echo $index; ?>">
                    <!-- Profile Name -->
                    <p>
                        <label for="profile_name_<?php echo $index; ?>">Name</label>
                        <input type="text"
                               id="profile_name_<?php echo $index; ?>"
                               name="profiles[<?php echo $index; ?>][name]"
                               value="<?php echo esc_attr($profile['name']); ?>"
                               required>
                    </p>
                    <!-- Photo URL -->
                    <p>
                        <label for="profile_photo_<?php echo $index; ?>">Photo URL</label>
                        <input type="text"
                               id="profile_photo_<?php echo $index; ?>"
                               name="profiles[<?php echo $index; ?>][photo_url]"
                               value="<?php echo esc_attr($profile['photo_url']); ?>"
                               required>
                    </p>
                    <!-- Bio -->
                    <p>
                        <label for="profile_bio_<?php echo $index; ?>">Bio</label>
                        <textarea id="profile_bio_<?php echo $index; ?>"
                                  name="profiles[<?php echo $index; ?>][bio]"
                                  rows="3" required><?php echo esc_html($profile['bio']); ?></textarea>
                    </p>
                    <!-- Schedule -->
                    <p>
                        <label for="profile_schedule_<?php echo $index; ?>">Schedule</label>
                        <input type="text"
                               id="profile_schedule_<?php echo $index; ?>"
                               name="profiles[<?php echo $index; ?>][schedule]"
                               value="<?php echo esc_attr($profile['schedule']); ?>"
                               required>
                    </p>
                    <!-- Rating -->
                    <p>
                        <label for="profile_rating_<?php echo $index; ?>">Rating (0-5)</label>
                        <input type="number"
                               id="profile_rating_<?php echo $index; ?>"
                               name="profiles[<?php echo $index; ?>][rating]"
                               value="<?php echo isset($profile['rating']) ? esc_attr($profile['rating']) : '0'; ?>"
                               step="0.5" min="0" max="5" required>
                    </p>
                    <!-- Reviews -->
                    <p>
                        <label for="profile_reviews_<?php echo $index; ?>">Reviews</label>
                        <input type="number"
                               id="profile_reviews_<?php echo $index; ?>"
                               name="profiles[<?php echo $index; ?>][reviews]"
                               value="<?php echo isset($profile['reviews']) ? esc_attr($profile['reviews']) : '0'; ?>"
                               min="0" required>
                    </p>

                    <!-- Delete button for client-side removal -->
                    <div class="actions">
                        <a href="#" class="button delete-profile">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Save button: posts all profiles (remaining after deletions) -->
        <button type="submit" class="button-primary">Save Profiles</button>
    </form>
</div>