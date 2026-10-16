jQuery(document).ready(function($){
    $('#lkar-save-btn').on('click', function (e) {
        e.preventDefault();
        console.log('Save settings clicked');

        $.ajax({
        url: lkar_ajax_object.ajax_url,
        type: 'POST',
        data:{
            action: 'lkar_save_settings',
            security: lkar_ajax_object.nonce,
            password: $('#lkar_password_id').val(),
            protection_page_id: $('#lkar_protection_page_id').val(),
            page_id: $('#lkar_page_id').val(),
            post_id: $('#lkar_post_id').val(),
        }, success: function(response) {
            if(response.success) {
                alert('Settings saved successfully!');
            } else {
                alert('Error saving settings: ' + response.data);
            }
        }});
        
    });

    $('#lkar-show-password').on('click', function () {
        var passwordField = $('#lkar_password_id');
        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('.dashicons').toggleClass('dashicons-visibility dashicons-hidden');

        console.log('Password visibility toggled');
    });
});