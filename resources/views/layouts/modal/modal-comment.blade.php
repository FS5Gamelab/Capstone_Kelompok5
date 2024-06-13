<div class="modal fade" id="modal-comment" tabindex="-1" role="dialog" aria-labelledby="modalOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrderLabel">Product Comment</h5>

            </div>
            <div class="modal-body tw-text-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="tw-w-full">
                            <div class="row">
                                <div class="col-12">
                                    <div id="basic">
                                    </div>
                                </div>
                                <div class="row tw-flex tw-items-center mt-3">
                                    <div class="col-12">
                                        <textarea name="comment" id="comment" placeholder="comment"
                                            class="tw-border tw-rounded-lg tw-px-3 py-2 mt-1 text-start tw-text-sm tw-w-full dark:tw-bg-gray-700 tw-text-black dark:tw-text-white focus:tw-border-blue-500 focus:tw-ring-4 focus:tw-ring-blue-500"></textarea>
                                    </div>
                                    <input type="hidden" name="product_id" id="product_id">
                                    <input type="hidden" name="cart_id" id="cart_id">
                                    <input type="hidden" name="order_id" id="order_id">
                                    <input type="hidden" name="rating" id="rating">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-light-secondary !tw-text-black dark:!tw-text-white"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button id="btn-submit" class="btn btn-primary !tw-mr-3">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#modal-comment').on('shown.bs.modal', function() {
            $('#comment').trigger('focus');
        });
    });
    $("#btn-submit").click(function() {
        let id = $("#product_id").val();
        let order = $("#order_id").val();
        let rating = $("#rating").val();
        let comment = $("#comment").val();
        let cart = $("#cart_id").val();
        let token = $("meta[name='csrf-token']").attr("content");
        $("#modal-comment").modal("hide");
        $("#loader").show();

        $.ajax({
            url: `/review`,
            type: "POST",
            data: {
                "product_id": id,
                "order_id": order,
                "rating": rating,
                "comment": comment,
                "_token": token
            },
            success: function(response) {
                $("#loader").hide();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                    })
                    // Update the HTML content dynamically
                    let stars = '';
                    for (let i = 1; i <= rating; i++) {
                        stars += `<div class="tw-mt-2 tw-inline-flex">
                                <img src="{{ asset('static/images/review/star-symbol-icon.svg') }}" alt="" class="tw-h-5 tw-w-5">
                              </div>`;
                    }
                    if (rating < 5) {
                        for (let i = 1; i <= 5 - rating; i++) {
                            stars += `<div class="tw-mt-2 tw-inline-flex">
                                    <img src="{{ asset('static/images/review/star-full-icon.svg') }}" alt="" class="tw-h-5 tw-w-5">
                                  </div>`;
                        }
                    }

                    let reviewContent = `
                    <div class="row tw-mb-3 tw-flex tw-justify-between tw-items-center">
                        <div class="col-8">
                            ${stars}
                        </div>
                        <div class="col-4 text-end">
                            <a href="javascript:void(0)" data-id="${response.review.id}" data-cart="${cart}" data-order="${order}" data-product="${id}" id="btn-edit" class="!tw-mr-3 mt-2 !tw-text-xs">Edit</a>
                            <a href="javascript:void(0)" data-id="${response.review.id}" data-cart="${cart}" data-order="${order}" data-product="${id}" id="btn-delete" class="!tw-mr-3 mt-2 !tw-text-red-500 hover:!tw-text-red-700 !tw-text-xs">Delete</a>
                        </div>
                    </div>
                    <p class="!tw-text-xs tw-mt-1 tw-text-gray-400">
                        ${comment}
                    </p>
                `;

                    $(`#cart_${cart}`).html(reviewContent);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        showConfirmButton: true,
                        confirmButtonText: 'Ok',
                    })
                }
            },
            error: function(response) {
                $("#loader").hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Something went wrong!",
                    showConfirmButton: true,
                })
            }
        });
    });
</script>
