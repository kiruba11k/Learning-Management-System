<<<<<<< HEAD
$(document).ready(function() {
    $('#toggle-login').click(function(event) {
        event.preventDefault();
        $('#login-form').removeClass('d-none');
        $('#register-form').addClass('d-none');
        $('#toggle-login').addClass('d-none');
        $('#toggle-register').removeClass('d-none');
    });

    $('#toggle-register').click(function(event) {
        event.preventDefault();
        $('#login-form').addClass('d-none');
        $('#register-form').removeClass('d-none');
        $('#toggle-login').removeClass('d-none');
        $('#toggle-register').addClass('d-none');
    });
});
=======
$(document).ready(function() {
    $('#toggle-login').click(function(event) {
        event.preventDefault();
        $('#login-form').removeClass('d-none');
        $('#register-form').addClass('d-none');
        $('#toggle-login').addClass('d-none');
        $('#toggle-register').removeClass('d-none');
    });

    $('#toggle-register').click(function(event) {
        event.preventDefault();
        $('#login-form').addClass('d-none');
        $('#register-form').removeClass('d-none');
        $('#toggle-login').removeClass('d-none');
        $('#toggle-register').addClass('d-none');
    });
});
>>>>>>> 109f3f8e230fc89dc7569212f5a58ec112f08ca9
