// Login
$(document).on('submit', '#login_form', function(e){
    e.preventDefault();
    $('#login-btn').html(showLoader.removeClass('d-none')).prop('disabled', true);

    $.ajax({
        url: 'controller/login.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response){
            if(response == "verified"){
                $('#login-btn').html('Login').prop('disabled', false);
                showToast("Login Successfully", 2000);
                // window.location.href = "main.php";
                window.location.reload();
            }
            else{
                $('#login-btn').html('Login').prop('disabled', false);
                alert(response);
            }
        },
        error: function (xhr, status, error){
            alert('Ajax error: ' + error);
        }
    })
})

// Register
$(document).on('submit', '#register_form', function (e) {
    e.preventDefault();
    $('#register-btn').html(showLoader.removeClass('d-none')).prop('disabled', true);

    $.ajax({
        url: 'controller/reg-forgot.php',
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

                    showToast(`Registration code sent to: <span class="fw-semibold text-muted">${registerEmail}</span>`, 3000);

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
                                url: 'controller/reg-forgot.php',
                                type: 'POST',
                                data: postData,
                                success: function (response) {
                                    if (response === '') {
                                        alert('No response!');
                                    }
                                    else {
                                        showToast(response, 2000);

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
                            showToast("Invalid Code", 2000);
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


// Forgot Password
(() => {
    let processedUser;
    let code;
    let codeSent;

    // Clicked Send Code
    $(document).on('click', '#forgot-sendcode-btn', function (e) {
        e.preventDefault();
        const enteredUser = $('#forgot-user').val();

        if (enteredUser.trim() === '') {
            showToast(`<span class="fw-semibold text-muted">Enter your email or username!</span>`, 2500);
            return;
        }

        $('#forgot-sendcode-btn').html(showLoader.removeClass('d-none'));

        $.ajax({
            url: 'controller/reg-forgot.php',
            type: 'POST',
            data: { enteredForgotUser: enteredUser },
            success: function (response) {

                const forgotData = JSON.parse(response);
                processedUser = forgotData.user;
                code = forgotData.forgot_code;
                const processedEmail = forgotData.email;

                if (forgotData == 'notFound') {
                    showToast(`<span class="fw-semibold text-muted">${enteredUser}</span> does not exists!`, 2200);
                }
                else if (processedUser.length > 0 && String(code).length > 0) {
                    showToast(`Forgot password verification code sent to: <span class="fw-semibold text-muted">${processedEmail}</span>`, 2500);
                    codeSent = true;
                }

                $('#forgot-sendcode-btn').html('Send code').prop('disabled', false);
            },
            error: function (xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        })
    })

    // Clicked Verify
    $(document).on('submit', '#forgot_form', function (e) {
        e.preventDefault();

        // Code Sent Checking
        if (!codeSent) {
            alert('Request code first together with your registered username or email.');
            return;
        }

        const currentEnteredUser = $('#forgot-user').val();
        const enteredForgotCode = $('#forgot-code').val();

        if (currentEnteredUser == processedUser) {
            if (enteredForgotCode == code) {
                $('#forgot_form').addClass('d-none');
                $('#newpass_form').removeClass('d-none');

            }
            else {
                alert("Invalid code!");
            }
        }
        else {
            alert("Invalid user, don't change the username/email value after the code has been sent successfully. Try again with your registered credential.");
        }
    })
    
    // Clicked Continue
    $(document).on('submit', '#newpass_form', function (e) {
        e.preventDefault();

        $('#newpass-btn').html(showLoader.removeClass('d-none')).prop('disabled', true);
        const enteredNewPass = $('#newpass').val();

        $.ajax({
            url: 'controller/reg-forgot.php',
            type: 'POST',
            data: { forgot_verified_user: processedUser, newPass: enteredNewPass },
            success: function (response) {
                if (response == 'updated') {
                    showToast('Password updated successfully.', 2000);

                    processedUser = undefined;
                    code = undefined;
                    codeSent = undefined;

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
                alert('AJAX error: ' + error);
            }
        })
    })
})()