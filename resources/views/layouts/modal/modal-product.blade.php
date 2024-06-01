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
            <form action="" method="post" enctype="multipart/form-data" id="update-product">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <img style="display: none;" class="img-preview2 tw-mt-2 tw-h-52" id="preview2">
                    </div>
                    <div class="form-group mandatory">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
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
                    <button type="submit" id="btn-update" class="btn btn-primary">Submit</button>
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
{{-- <script>
    $("#update-product").on("submit", function(e) {
        e.preventDefault();
        let id = $("#id").val();
        $("#ubahModal").modal("hide");
        $("#loader").show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `products/update/${id}`,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                $("#loader").hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: true,
                    });
                    let img;
                    let stk;
                    if (response.product.product_image) {
                        img = ` 
                        <td><img src="storage/${response.product.product_image}" alt="" class="tw-w-16 tw-h-16"></td>
                        
                        `
                    } else {
                        img = `<td>No Image</td>`
                    }

                    if (response.product.in_stock) {
                        stk =
                            `<td class="text-center"><i class="bi bi-check text-success"></i></td>`
                    } else {
                        stk = `<td class="text-center"><i class="bi bi-x text-danger"></i></td>`
                    }
                    $("#index_" + id).html(
                        `
                    ${img}
                    <td>${response.product.product_name}</td>
                    <td>${response.category.category_name}</td>
                    <td>${response.product.type}</td>
                    <td class="text-end">Rp${parseInt(response.product.price.toLocaleString('id_ID'))}</td>
                    <td>0</td>
                    <td class="tw-text-sm tw-text-nowrap">
                        0 / 5
                        <span class="tw-ml-1">
                            <i class="bi bi-star-fill tw-text-yellow-200"></i>
                        </span>    
                    </td>
                    <td class="text-center">
                        ${stk}
                    </td>
                    <td class="tw-text-nowrap">
                        <a href="/products/${response.product.id}" class="btn btn-sm btn-info me-2">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-edit"
                            class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="javascript:void(0)" data-id="${response.product.id}" id="btn-delete"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                        `
                    );
                } else {
                    let errors = response.errors;
                    let errorMessages = '';
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessages += `${errors[field]}<br>`;
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessages,
                        showConfirmButton: true,
                    });
                }

            },
            error: function(xhr, status, error) {
                $("#loader").hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update product.',
                    showConfirmButton: true,
                });
            }
        });
    });
</script> --}}
