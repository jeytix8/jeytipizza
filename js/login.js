let codeVerify;
let registerUsername;
let registerEmail;
let registerPassword;

$(document).on('submit', '#register_form', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'php/mailer.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            try {
                let data = JSON.parse(response);
                codeVerify = data.register_code;
                registerUsername = data.username;
                registerEmail = data.email;
                registerPassword = data.password;

                $('#register_form').addClass('d-none');
                $('#registerverify_form').removeClass('d-none');
                alert('Code sent to your email!');
            } catch (e) {
                alert('Failed to parse server response.');
            }
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
                } else {
                    alert(response);
                    $('#registerverify_form').addClass('d-none');

                    // Close modal properly
                    let modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                    modal.hide();
                }
            },
            error: function (xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }
    else {
        alert("Invalid Code");
    }
});
