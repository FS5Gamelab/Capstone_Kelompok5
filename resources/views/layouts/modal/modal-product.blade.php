<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-product" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mandatory">
                        <label for="n-product_image" class="form-label">Product Image</label>
                        <input type="file" name="product_image" id="n-product_image" class="form-control"
                            accept="image/*">
                        <img style="display: none;" class="img-preview tw-mt-2 tw-h-52" id="preview">
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="n-product_name" class="form-control">
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="n-slug" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-category_id" class="form-label">Category</label>
                        <select name="category_id" id="n-category_id" class="form-control text-capitalize">
                            <option value="" hidden>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-type" class="form-label">Type</label>
                        <select name="type" id="n-type" class="form-control">
                            <option value="" hidden>Select Type</option>
                            <option value="foods">Food</option>
                            <option value="drinks">Drink</option>
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-description" class="form-label">Description</label>
                        <textarea name="description" id="n-description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-price" class="form-label">Price</label>
                        <input type="number" name="price" id="n-price" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Update Product</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="update-product" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control" />
                        <img style="display: none;" class="img-preview2 tw-mt-2 tw-h-52" id="preview2">
                    </div>
                    <div class="form-group mandatory">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                    </div>
                    <div class="form-group mandatory">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control text-capitalize">
                            <option value="" hidden>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="" hidden>Select Type</option>
                            <option value="foods">Food</option>
                            <option value="drinks">Drink</option>
                        </select>
                    </div>

                    <div class="form-group mandatory">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mandatory">
                        <label for="in_stock" class="form-label">Stock</label>
                        <select name="in_stock" id="in_stock" class="form-control">
                            <option value="" hidden>Select Stock</option>
                            <option value="1">
                                Available
                            </option>
                            <option value="0">
                                Unavailable
                            </option>
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-update" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('button').attr('data-dismiss', 'modal').click(function() {
        $("#tambahModal").modal("hide");
        $("#ubahModal").modal("hide");
    });

    $("#n-product_image").change(function() {
        const image = document.querySelector("#n-product_image");
        const imgPreview = document.querySelector(".img-preview");
        file = image.files[0];
        const maxSize = 1 * 1024 * 1024;

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'File size must not exceed 1 MB.',
                showConfirmButton: true,
                confirmButtonText: 'Close',
                backdrop: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    image.value = '';
                    $("#preview").hide();
                }

            })

        } else {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
                $("#preview").show();
            }
        }

    })
    $("#product_image").change(function() {
        const image = document.querySelector("#product_image");
        const imgPreview = document.querySelector(".img-preview2");
        file = image.files[0];
        const maxSize = 1 * 1024 * 1024;

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'File size must not exceed 1 MB.',
                showConfirmButton: true,
                confirmButtonText: 'Close',
                backdrop: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    image.value = '';
                    $("#preview2").hide();
                }

            })

        } else {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
                $("#preview2").show();
            }
        }

    })
</script>

<script>
    const product_name = document.querySelector("#n-product_name");

    product_name.addEventListener("change", function() {
        const slug = document.querySelector("#n-slug");
        fetch("/products/create/checkSlug?product_name=" + product_name.value)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
</script>
<script>
    const product_name2 = document.querySelector("#product_name");

    product_name2.addEventListener("keyup", function() {
        console.log(product_name2.value);
        const slug = document.querySelector("#slug");
        fetch("/products/create/checkSlug?product_name=" + product_name2.value)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
</script>
