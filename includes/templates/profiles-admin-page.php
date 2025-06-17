<div class="wrap">
    <h1>Manage Cleaner Profiles</h1>
    <button type="button" id="toggle-add-profile" class="button-primary">Add New Profile</button>

    <div id="add-profile-container" style="display: none; margin: 20px 0;">
        <h2 style="margin-top:30px;">Add New Profile</h2>
        <form class="profile-form" onsubmit="return false;">
            <p>
                <label for="new_name">Name</label>
                <input type="text" id="new_name" placeholder="Enter full name" required>
            </p>
            <p>
                <label for="new_photo_url">Photo URL</label>
                <input type="text" id="new_photo_url" placeholder="https://..." required>
            </p>
            <p>
                <label for="new_bio">Bio</label>
                <textarea id="new_bio" placeholder="Short bio" rows="3" required></textarea>
            </p>
            <p>
                <label for="new_schedule">Schedule</label>
                <input type="text" id="new_schedule" placeholder="e.g., Weekdays: 9am-5pm" required>
            </p>
            <p>
                <label for="new_rating">Rating (0-5)</label>
                <input type="number" step="0.5" min="0" max="5" id="new_rating" value="5" required>
            </p>
            <p>
                <label for="new_reviews">Reviews Count</label>
                <input type="number" min="0" id="new_reviews" value="0" required>
            </p>
            <button type="button" id="add-profile-btn" class="button-primary">Add Profile</button>
        </form>
    </div>

    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" id="profiles-form">
        <input type="hidden" name="action" value="cleaner_save_profiles"/>
        <div class="profiles-grid">
            <?php foreach ($profiles as $index => $profile) : ?>
                <div class="profile-form" data-index="<?php echo $index; ?>" >
                    <p>
                        <label for="new_name">Name</label>
                        <input type="text" name="profiles[<?php echo $index; ?>][name]"
                               name="profiles[<?php echo $index; ?>][name]"
                               value="<?php echo esc_attr($profile['name']); ?>" required/>
                    </p>
                    <p>
                        <label for="new_photo_url">Photo URL</label>
                        <input type="text" name="profiles[<?php echo $index; ?>][photo_url]"
                               value="<?php echo esc_attr($profile['photo_url']); ?>" required/>
                    </p>
                    <p>
                        <label for="new_bio">Bio</label>
                        <textarea name="profiles[<?php echo $index; ?>][bio]" id="new_bio" rows="3" required
                        ><?php echo esc_attr($profile['bio']); ?></textarea>
                    </p>
                    <p>
                        <label for="new_schedule">Schedule</label>
                        <input type="text" id="new_schedule" placeholder="e.g., Weekdays: 9am-5pm"
                               name="profiles[<?php echo $index; ?>][schedule]"
                               value="<?php echo esc_html($profile['schedule']); ?>" required>
                    </p>
                    <p>
                        <label for="new_rating">Rating (0-5)</label>
                        <input type="number" step="0.5" min="1" max="5" id="new_rating"
                               name="profiles[<?php echo $index; ?>][rating]"
                               value="<?php echo isset($profile['rating']) ? esc_attr($profile['rating']) : '0'; ?>"
                               required>
                    </p>
                    <p>
                        <label for="new_reviews">Reviews Count</label>
                        <input type="number" min="0" id="new_reviews" name="profiles[<?php echo $index; ?>][reviews]"
                               value="<?php echo isset($profile['reviews']) ? esc_attr($profile['reviews']) : '0'; ?>"
                               required>
                    </p>


                    <div class="actions">
                        <a href="#" class="button delete-profile">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="button-primary">Save Profiles</button>
    </form>
</div>
