// Toast
function showToast(message, duration) {
    $('#liveToast .toast-body').html(message);

    const toast = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast)
    toastBootstrap.show()

    setTimeout(()=>{
        toastBootstrap.hide();
    }, duration)
}

const showLoader = $('#loading');