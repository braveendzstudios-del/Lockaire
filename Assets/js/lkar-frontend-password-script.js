jQuery(document).ready(function ($) {
   
    $('#lkar-password-submit').on('click', function (e) {
        e.preventDefault();
   
        var password = $('#lkar_password_id').val();
        $.ajax({
            url: lkar_frontend_object.ajax_url,
            type: 'POST',
            data: {
                action: 'lkar_check_password',
                password: password,
                nonce: lkar_frontend_object.nonce
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    alert(response.data.message);
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
    });

    $('#lkar-password-toggle').on('click', function () {
        var passwordField = $('#lkar_password_id');
        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('.dashicons').toggleClass('dashicons-visibility dashicons-hidden');

        console.log('Password visibility toggled');
    });
     
});      