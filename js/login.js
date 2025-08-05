let codeVerify;
let registerUsername;
let registerEmail;
let registerPassword;

$(document).on('submit', '#register_form', function (e) {
    e.preventDefault();
    $('#register-btn').html(showLoader.removeClass('d-none'));
    $('#register-btn').prop('disabled', true);

    $.ajax({
        url: 'php/mailer.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            try {
                if (response == 'exists') {
                    alert("User Exists!")
                }
                else {
                    let data = JSON.parse(response);
                    codeVerify = data.register_code;
                    registerUsername = data.username;
                    registerEmail = data.email;
                    registerPassword = data.password;

                    showToast(`Registration code sent to: <span class="fw-semibold text-muted">${registerEmail}</span>`);
                    
                    $('#register_form').addClass('d-none');
                    $('#registerverify_form').removeClass('d-none');
                }
            }
            catch (e) {
                alert('Failed to parse server response.');
            }

            // Button revert after the response
            $('#register-btn').html('Register');
            $('#register-btn').prop('disabled', false);
        },
        error: function (xhr, status, error) {
            alert('AJAX error: ' + error);
        }
    });
});

$(document).on('submit', '#registerverify_form', function (e) {
    e.preventDefault();

    if (codeVerify == $('#register-number').val()) {
        const postData = {
            username: registerUsername,
            email: registerEmail,
            password: registerPassword,
            verified_code: codeVerify,
        };

        $.ajax({
            url: 'php/mailer.php',
            type: 'POST',
            data: postData,
            success: function (response) {
                if (response === '') {
                    alert('No response!');
                }
                else {
                    showToast(response);

                    // Close modal properly
                    let modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                    modal.hide();

                    $('#registerverify_form').addClass('d-none');
                    $('#registerverify_form')[0].reset();

                    $('#register_form').removeClass('d-none');
                    $('#register_form')[0].reset();
                }
            },
            error: function (xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }
    else {
        showToast("Invalid Code");
    }
});