<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Blog</h5>
                {{-- <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form id="add-product" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="n-blog_image" class="form-label">Image</label>
                        <input type="file" name="blog_image" id="n-blog_image" class="form-control" accept="image/*">
                        <img style="display: none;" class="img-preview tw-mt-2 tw-h-52 tw-w-full" id="preview">
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-title" class="form-label">Title</label>
                        <input type="text" name="title" id="n-title" class="form-control">
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="n-slug" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="n-description" class="form-label">Description</label>
                        <input id="n-description" type="hidden" name="description">
                        <trix-editor input="n-description"></trix-editor>
                    </div>

                </div>
                <div class="modal-footer">
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
                <h5 class="modal-title" id="exampleModalLabel2">Update Blog</h5>
                {{-- <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form method="post" id="update-blog" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="blog_image" class="form-label">Image</label>
                        <input type="file" name="blog_image" id="blog_image" class="form-control" accept="image/*">
                        <img style="display: none;" class="img-preview2 tw-mt-2 tw-h-52 tw-w-full" id="preview2">
                    </div>
                    <div class="form-group mandatory">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group mandatory">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="description" class="form-label">Description</label>
                        <input id="description" type="hidden" name="description">
                        <trix-editor input="description"></trix-editor>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-update" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener("trix-file-accept", function(e) {
        e.preventDefault();
    });
</script>
<script>
    $(document).ready(function() {
        $('#tambahModal').on('shown.bs.modal', function() {
            $('#n-title').trigger('focus');
        });
    })
    $("#n-blog_image").change(function() {
        const image = document.querySelector("#n-blog_image");
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
    $("#blog_image").change(function() {
        const image = document.querySelector("#blog_image");
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
    const title = document.querySelector("#n-title");

    title.addEventListener("change", function() {
        const slug = document.querySelector("#n-slug");
        fetch("/blogs/create/checkSlug?title=" + title.value)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
</script>
<script>
    const title2 = document.querySelector("#title");

    title2.addEventListener("keyup", function() {
        console.log(title2.value);
        const slug = document.querySelector("#slug");
        fetch("/blogs/create/checkSlug?title=" + title2.value)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
</script>
