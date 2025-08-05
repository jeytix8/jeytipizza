// Toast
function showToast(message) {
    $('#liveToast .toast-body').html(message);

    const toast = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast)
    toastBootstrap.show(1000)
}

$('#loading').addClass('d-none');
const showLoader = $('#loading');