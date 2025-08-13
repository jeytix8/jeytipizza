<section id="content">
    <div class="container-lg">
        <!-- Products -->
        <div class="row justify-content-center align-items-center">
            <!-- Add Product -->
            <div class="text-end">
                <button class="btn btn-sm btn-success">+ Add a Product</button>
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
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td><img src="https://assets.surlatable.com/m/15a89c2d9c6c1345/72_dpi_webp-REC-283110_Pizza.jpg"
                                alt="Peronizza" width="32"></td>
                        <td>Cheezinach</td>
                        <td>Cheezier</td>
                        <td>P 100</td>
                        <td>
                            <select class="form-select form-select-sm" aria-label="Default select example">
                                <option value="product-avail">Available</option>
                                <option value="product-sold">Sold Out</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" id="edit-btn" data-bs-toggle="modal"
                                data-bs-target="#edit-modal">Edit</button>
                            <button class="btn btn-sm btn-danger" id="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edit-modalLabel">Edit
                            Product Information
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Information -->
                        <form action="">
                            <div class="input-group mb-2">
                                <span class="input-group-text"><img src="assets/pizza.png" alt="pizza"
                                        width="22"></span>
                                <input type="text" class="form-control" placeholder="Product name">
                            </div>

                            <div class="input-group mb-2">
                                <span class="input-group-text">&#8369</span>
                                <input type="number" class="form-control" placeholder="Price">
                            </div>

                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="bi bi-pen-fill"></i></span>
                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                    placeholder="Product description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>