// Register
$(document).on('submit', '#register_form', function (e) {
    e.preventDefault();
    $('#register-btn').html(showLoader.removeClass('d-none'));
    $('#register-btn').prop('disabled', true);

    $.ajax({
        url: 'php/reg-forgot.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            try {
                if (response == 'exists') {
                    alert("User Exists!")
                }
                else {
                    const data = JSON.parse(response);
                    const codeVerify = data.register_code;
                    const registerUsername = data.username;
                    const registerEmail = data.email;
                    const registerPassword = data.password;

                    showToast(`Registration code sent to: <span class="fw-semibold text-muted">${registerEmail}</span>`);

                    $('#register_form').addClass('d-none');
                    $('#registerverify_form').removeClass('d-none');
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
                                url: 'php/reg-forgot.php',
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

// Forgot
// Clicked Send Code
$(document).on('click', '#forgot-sendcode-btn', function (e) {
    e.preventDefault();
    const enteredUser = $('#forgot-user').val();
    $('#forgot-sendcode-btn').html(showLoader.removeClass('d-none'));

    $.ajax({
        url: 'php/reg-forgot.php',
        type: 'POST',
        data: { enteredForgotUser: enteredUser },
        success: function (response) {

            showToast(`Forgot password verification code sent to: <span class="fw-semibold text-muted">${enteredUser}</span>`);

            $('#forgot-sendcode-btn').html('Send code').prop('disabled', false);

            const forgotData = JSON.parse(response);
            const processedUser = forgotData.user;
            const code = forgotData.forgot_code;

            // Clicked Verify
            $(document).on('submit', '#forgot_form', function (e) {
                e.preventDefault();
                $('#forgot-verify-btn').html(showLoader.removeClass('d-none')).prop('disabled', true);

                const currentEnteredUser = $('#forgot-user').val();
                const enteredForgotCode = $('#forgot-code').val();

                if (currentEnteredUser == processedUser) {
                    if (enteredForgotCode == code) {
                        $('#forgot-verify-btn').html('Verify').prop('disabled', false);
                        $('#forgot_form').addClass('d-none');
                        $('#newpass_form').removeClass('d-none');

                        // Clicked Continue
                        $(document).on('submit', '#newpass_form', function (e) {
                            e.preventDefault();
                            $('#newpass-btn').html(showLoader.removeClass('d-none')).prop('disabled', true);
                            const enteredNewPass = $('#newpass').val();

                            $.ajax({
                                url: 'reg-forgot.php',
                                type: 'POST',
                                data: { forgot_verified_user: processedUser, newPass: enteredNewPass },
                                success: function (response) {
                                    if (response == 'updated') {
                                        showToast('Password updated successfully.');

                                        // Close modal properly
                                        let modal = bootstrap.Modal.getInstance(document.getElementById('forgotpw'));
                                        modal.hide();

                                        $('#newpass_form').addClass('d-none');
                                        $('#newpass_form')[0].reset();
                                        $('#forgot_form')[0].reset();
                                        $('#forgot_form').removeClass('d-none');
                                    }
                                    else {
                                        alert(response);
                                    }
                                    $('#newpass-btn').html('Continue').prop('disabled', false);
                                },
                                error: (xhr, status, error) => {
                                    alert('AJAX error: ' + error)
                                }
                            })
                        })
                    }
                    else {
                        alert("Invalid code!");
                    }
                }
                else {
                    alert("Invalid user, try to resend code and don't change the username/email value after the code has been sent successfully.");
                }
            })
        },
        error: function (xhr, status, error) {
            alert('AJAX error: ' + error);
        }
    })
})