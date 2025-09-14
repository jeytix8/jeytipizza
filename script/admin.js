let cropper;
let cropTarget = null; // 👈 para malaman kung ADD or EDIT ang nag-trigger

// 📌 Common function to open crop modal with image
function openCropperWithImage(src, target) {
    cropTarget = target; // 👈 set kung saan form gagamitin
    $('#cropper-image').attr('src', src);

    const cropModalEl = document.getElementById('crop-modal');
    const cropModal = new bootstrap.Modal(cropModalEl);
    cropModal.show();

    if (cropper) cropper.destroy();

    setTimeout(() => {
        cropper = new Cropper(document.getElementById('cropper-image'), {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            background: false,
            wheelZoomRatio: 0
        });
    }, 150);
}

function fileUpload(e, target) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (evt) {
            openCropperWithImage(evt.target.result, target);
        };
        reader.readAsDataURL(file);
    }
}

function pasteUpload(e, target) {
    const items = (e.originalEvent || e).clipboardData.items;
    for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf("image") !== -1) {
            const file = items[i].getAsFile();
            const reader = new FileReader();
            reader.onload = function (evt) {
                openCropperWithImage(evt.target.result, target);
            };
            reader.readAsDataURL(file);
            break;
        }
    }
}

// Account Update ______________________________________________
$(document).on('change', '#edit-account-image', function(e) {
    fileUpload(e, 'account');
});

$(document).on('paste', '#edit-account-form', function(e) {
    pasteUpload(e, 'account');
});

// Get Details
$(document).on('click', '#account-btn', function () {
    $.ajax({
        url: 'controller/admin-content.php',
        type: 'GET',
        data: { action: 'edit-account' },  // No need to pass ID since we'll use session
        success: function (response) {
            try {
                if (!response) {
                    throw new Error('Empty response');
                }
                const account = JSON.parse(response);
                if (account && account.username) {
                    // Populate the edit form with account data
                    $('#edit-account-form [name="edit-username"]').val(account.username);
                    $('#edit-account-form [name="edit-email"]').val(account.email);
                    $('#edit-account-form [name="edit-cropped-image"]').val(account.image);
                    $('#edit-account-image-preview').attr('src', account.image).show();
                    $('#edit-account-upload-label').text('Change Image');
                    $('#account-modal').modal('show');
                } else {
                    throw new Error('Invalid account data');
                }
            } catch (e) {
                console.error('Invalid JSON response:', response);
                alert('Account not found or invalid data received');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});

// Update
$(document).on('submit', '#edit-account-form', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('action', 'update');


    $.ajax({
        url: 'controller/admin-content.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.trim() === "Update") {
                readProducts();
                showToast("Product updated successfully!", 3000);

                $('#edit-modal').modal('hide');
                $('#edit-product-form')[0].reset();
                $('#edit-image-preview').hide();
                cropper.destroy();
            }
            else {
                alert(response);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});



// CREATE Product ______________________________________________
$(document).on('change', '#add-product-image', function (e) {
    fileUpload(e, 'add'); // 👈 tag as add
});

$(document).on('paste', '#add-product-form', function (e) {
    pasteUpload(e, 'add');
});

$(document).on('click', '#crop-btn', function () {
    if (!cropper) return;
    const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });

    if (cropTarget === 'add') {
        $('#add-cropped-image').val(canvas.toDataURL('image/png'));
        $('#add-upload-label').text('Change Image');
        $('#add-image-preview').attr('src', canvas.toDataURL('image/png')).show();
    } else if (cropTarget === 'edit') {
        $('#edit-cropped-image').val(canvas.toDataURL('image/png'));
        $('#edit-upload-label').text('Change Image');
        $('#edit-image-preview').attr('src', canvas.toDataURL('image/png')).show();
    }

    bootstrap.Modal.getInstance(document.getElementById('crop-modal')).hide();
    showToast("Image uploaded successfully.", 2000);
});


$(document).on('submit', '#add-product-form', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('action', 'create');

    $.ajax({
        url: 'controller/admin-content.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.trim() === "Add") {
                showToast("Product added successfully!", 3000);

                $('#add-modal').modal('hide');
                $('#add-product-form')[0].reset();
                $('#add-image-preview').hide();
                cropper.destroy();
                readProducts();
            }
            else {
                alert(response);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});


// Read Product ____________________
function readProducts() {
    $.ajax({
        url: 'controller/admin-content.php',
        type: 'GET',
        data: { action: 'read' },
        success: function (response) {
            $('#product-table-body').html(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}
$(document).ready(function () {
    readProducts();

});

// Update Product ________________
$(document).on('change', '#edit-product-image', function (e) {
    fileUpload(e, 'edit'); // 👈 tag as edit
});

$(document).on('paste', '#edit-product-form', function (e) {
    pasteUpload(e, 'edit');
});

$(document).on('change', '.form-select', function () {
    const $row = $(this).closest('tr');
    const productId = $row.find('th').text().trim();
    const status = $(this).val() === 'product-sold' ? 'Sold Out' : 'Available';

    $.ajax({
        url: 'controller/admin-content.php',
        type: 'POST',
        data: { action: 'update_status', id: productId, status: status },
        success: function (response) {
            showToast(response, 2000);
        }
    });
});

// Get Details
$(document).on('click', '.edit-btn', function () {
    const productId = $(this).data('id');
    $('#edit-product-id').val(productId); // set value sa hidden input

    $.ajax({
        url: 'controller/admin-content.php',
        type: 'GET',
        data: { action: 'edit', id: productId },
        success: function (response) {
            const product = JSON.parse(response);
            if (product) {

                // Populate the edit form with product data
                $('#edit-product-form [name="edit-product-name"]').val(product.name);
                $('#edit-product-form [name="edit-product-price"]').val(product.price);
                $('#edit-product-form [name="edit-product-description"]').val(product.description);
                $('#edit-product-form [name="edit-cropped-image"]').val(product.image);
                $('#edit-image-preview').attr('src', product.image).show();
                $('#edit-upload-label').text('Change Image');
                $('#edit-modal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});

// Update
$(document).on('submit', '#edit-product-form', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('action', 'update');


    $.ajax({
        url: 'controller/admin-content.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.trim() === "Update") {
                readProducts();
                showToast("Product updated successfully!", 3000);

                $('#edit-modal').modal('hide');
                $('#edit-product-form')[0].reset();
                $('#edit-image-preview').hide();
                cropper.destroy();
            }
            else {
                alert(response);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});


// Delete Product
$(document).on('click', '.delete-btn', function () {
    const productId = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'controller/admin-content.php',
                type: 'GET',
                data: { action: 'delete', id: productId },
                success: function (response) {
                    if (response.trim() === "Delete") {
                        readProducts();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Product has been deleted.",
                            icon: "success"
                        });
                    }
                    else{
                        Swal.fire({
                            title: "Error!",
                            text: response,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});


