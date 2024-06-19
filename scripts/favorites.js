$(document).ready(function() {
    $('.like-button').click(function() {
        let button = $(this);
        let imageId = button.data('image-id');

        $.ajax({
            url: 'toggle_favorite.php',
            method: 'POST',
            data: { image_id: imageId },
            success: function(response) {
                if (response === 'liked') {
                    button.text('Unlike');
                } else if (response === 'unliked') {
                    button.text('Like');
                    button.closest('.favorite-item').remove();
                } else if (response === 'not_logged_in') {
                    window.location.href = 'login.php';
                }
            }
        });
    });
});
        
