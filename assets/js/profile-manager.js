(function () {
  // Wait for DOM to load
  document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggle-add-profile');
    const formContainer = document.getElementById('add-profile-container');

    // Show/hide form on button click
    toggleButton.onclick = function () {
      if (formContainer.style.display === 'none') {
        formContainer.style.display = 'block'; // Show
      } else {
        formContainer.style.display = 'none'; // Hide
      }
    };
  });

  // Initialize the profile index counter for new entries; will be set dynamically based on existing rows
  let indexCounter = 0;
  const profilesGrid = document.querySelector('.profiles-grid');
  // Wait for the DOM to fully load before attaching event handlers
  document.addEventListener('DOMContentLoaded', function () {
    // Retrieve all existing profile rows in the table body to establish starting index
    const rows = document.querySelectorAll('.profiles-grid .profile-form');
    indexCounter = rows.length; // Count current rows to avoid ID conflicts

    /**
     * Handle the 'Add Profile' button click event.
     * Collects input values, validates, and appends a new profile row to the table.
     */
    document.getElementById('add-profile-btn').onclick = function () {
      // Gather input values for the new profile
      const name = document.getElementById('new_name').value.trim();
      const photoUrl = document.getElementById('new_photo_url').value.trim();
      const bio = document.getElementById('new_bio').value.trim();
      const schedule = document.getElementById('new_schedule').value.trim();
      const rating = document.getElementById('new_rating').value.trim();
      const reviews = document.getElementById('new_reviews').value.trim();

      // Basic validation to ensure no field is left empty
      if (!name || !photoUrl || !bio || !schedule || rating === '' || reviews === '') {
        alert('Please fill all fields before adding a new profile.');
        return; // Halt execution if validation fails
      }

      // Create a new table row element
      const row = document.createElement('div');
      row.classList.add('profile-form'); // Add class for styling
      row.setAttribute('data-index', indexCounter); // Set data attribute for easy reference
      // Insert the HTML for each cell with embedded input fields for easy editing
      row.innerHTML = `
              <p>
                <label for="new_name">Name</label>
                <input type="text" name="profiles[${indexCounter}][name]" value="${escapeHtml(name)}" >
            </p>
            <p>
                <label for="new_photo_url">Photo URL</label>
                <input type="text" name="profiles[${indexCounter}][photo_url]" value="${escapeHtml(photoUrl)}" />
            </p>
            <p>
                <label for="new_bio">Bio</label>
                <textarea id="new_bio" required placeholder="Short bio" rows="3" name="profiles[${indexCounter}][bio]"
                >${escapeHtml(bio)}</textarea>
            </p>
            <p>
                <label for="new_schedule">Schedule</label>
                <input type="text" name="profiles[${indexCounter}][schedule]" value="${escapeHtml(schedule)}" required>
            </p>
            <p>
                <label for="new_rating">Rating (0-5)</label>
                <input type="number" step="0.5" min="1" max="5" name="profiles[${indexCounter}][rating]" value="${escapeHtml(rating)}" required>
            </p>
            <p>
                <label for="new_reviews">Reviews Count</label>
                <input type="number" min="0" id="new_reviews" name="profiles[${indexCounter}][reviews]" value="${escapeHtml(reviews)}" required>
            </p>
            <div class="actions">
              <a href="#" class="button delete-profile">Delete</a>
            </div>`

      // Append the new profile row into the table body
      profilesGrid.appendChild(row);
      indexCounter++; // Increment counter to maintain unique indices

      // Clear input fields after adding the profile
      document.getElementById('new_name').value = '';
      document.getElementById('new_photo_url').value = '';
      document.getElementById('new_bio').value = '';
      document.getElementById('new_schedule').value = '';
      document.getElementById('new_rating').value = '0';
      document.getElementById('new_reviews').value = '0';

      const toggleButton = document.getElementById('toggle-add-profile');
      toggleButton.click();
    };

    /**
     * Delegate click events within the table body for delete buttons.
     * Implements a confirmation prompt before removing a row.
     */
    profilesGrid.addEventListener('click', function (e) {
      if (e.target && e.target.matches('.delete-profile')) {
        // Fetch confirmation message from data attribute or use default
        const msg = e.target.getAttribute('data-confirm') || 'Are you sure you want to delete this profile?';

        // Show confirmation dialog; proceed only if user confirms
        if (!confirm(msg)) {
          return; // Exit if user cancels
        }

        const profileCard = e.target.closest('.profile-form');

        // Remove the profile div from the DOM
        profileCard.remove();
      }
    });

    /**
     * Utility function to escape special HTML characters.
     * Prevents XSS vulnerabilities by sanitizing user input before injecting into HTML.
     * @param {string} text - The raw input string to escape.
     * @returns {string} - The sanitized HTML string.
     */
    function escapeHtml(text) {
      const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      };
      return text.replace(/[&<>"']/g, m => map[m]);
    }

  });
})();