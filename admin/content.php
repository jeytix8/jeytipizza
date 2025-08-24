<section id="content">
    <div class="container-lg">
        <!-- Products -->
        <div class="row justify-content-center align-items-center">
            <!-- Add Product -->
            <div class="text-end">
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add-modal">+ Add a
                    Product</button>
            </div>

            <!-- Product -->
            <table class="table text-center mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Product Item -->
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <!--Add Modal -->
        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="add-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add-modalLabel">Add
                            Product Information
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Information -->
                    <form id="add-product-form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!-- Image Preview -->
                            <div class="mb-2 text-center">
                                <img id="add-image-preview" src="" alt="Preview" style="max-width:100px; display:none;">
                            </div>

                            <!-- Image Upload Box -->
                            <div class="input-group mb-2">
                                <label for="add-product-image" class="form-control text-center" style="cursor:pointer;">
                                    <span id="add-upload-label">Upload</span>
                                    <input type="file" id="add-product-image" name="add-product-image" accept="image/*"
                                        style="display:none;">
                                </label>
                            </div>

                            <!-- Product name -->
                            <div class="input-group mb-2">
                                <span class="input-group-text"><img src="assets/pizza.png" alt="pizza"
                                        width="22"></span>
                                <input type="text" class="form-control" placeholder="Product name"
                                    name="add-product-name" required>
                            </div>

                            <!--Product Price -->
                            <div class="input-group mb-2">
                                <span class="input-group-text">&#8369</span>
                                <input type="number" class="form-control" placeholder="Price" name="add-product-price"
                                    required>
                            </div>

                            <!-- Product Description -->
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-pen-fill"></i></span>
                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                    placeholder="Product description" name="add-product-description"
                                    required></textarea>
                            </div>

                            <input type="hidden" name="add-cropped-image" id="add-cropped-image">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-danger">Save product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edit-modalLabel">Edit
                            Product Information
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Information -->
                    <form id="edit-product-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit-product-id">
                        
                        <div class="modal-body">
                            <!-- Image Preview -->
                            <div class="mb-2 text-center">
                                <img id="edit-image-preview" src="" alt="Preview" style="max-width:100px; display:none;">
                            </div>

                            <!-- Image Upload Box -->
                            <div class="input-group mb-2">
                                <label for="edit-product-image" class="form-control text-center" style="cursor:pointer;">
                                    <span id="edit-upload-label">Upload</span>
                                    <input type="file" id="edit-product-image" name="edit-product-image" accept="image/*"
                                        style="display:none;">
                                </label>
                            </div>

                            <!-- Product name -->
                            <div class="input-group mb-2">
                                <span class="input-group-text"><img src="assets/pizza.png" alt="pizza"
                                        width="22"></span>
                                <input type="text" class="form-control" placeholder="Product name"
                                    name="edit-product-name" required>
                            </div>

                            <!--Product Price -->
                            <div class="input-group mb-2">
                                <span class="input-group-text">&#8369</span>
                                <input type="number" class="form-control" placeholder="Price" name="edit-product-price"
                                    required>
                            </div>

                            <!-- Product Description -->
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-pen-fill"></i></span>
                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                    placeholder="Product description" name="edit-product-description"
                                    required></textarea>
                            </div>

                            <input type="hidden" name="edit-cropped-image" id="edit-cropped-image">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-danger">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Modal -->


        <!-- Crop Modal -->
        <div class="modal fade" id="crop-modal" tabindex="-1" aria-labelledby="crop-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crop-modalLabel">Crop Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body d-flex flex-column align-items-center">
                        <div class="w-100 d-flex justify-content-center">
                            <img id="cropper-image" src="" style="max-width:100%; max-height:50vh;">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" id="crop-btn" class="btn btn-success">Crop & Use</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>