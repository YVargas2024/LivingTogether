const stars = document.querySelectorAll('.stars-container .star');
const selectElement = document.getElementById('valoracion');

// Hover effect: Highlight stars one by one as the cursor moves
stars.forEach(star => {
    star.addEventListener('mouseover', () => {
        resetStars(); // Reset all stars
        // Color all stars up to the hovered star
        for (let i = 0; i < star.dataset.value; i++) {
            stars[i].classList.add('selected'); // Add class to highlight
        }
    });

    star.addEventListener('mouseleave', () => {
        resetStars(); // Reset all stars
        // If there's a selected rating, highlight the stars up to that value
        highlightStars(selectElement.value);
    });

    star.addEventListener('click', () => {
        selectElement.value = star.dataset.value; // Update the select value
        highlightStars(star.dataset.value); // Highlight the stars based on the selected value
    });
});

// Function to highlight stars up to the selected value
function highlightStars(value) {
    stars.forEach(star => {
        if (star.dataset.value <= value) {
            star.classList.add('selected');
        } else {
            star.classList.remove('selected');
        }
    });
}

// Reset all stars to their original state
function resetStars() {
    stars.forEach(star => star.classList.remove('selected'));
}
