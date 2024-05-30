import raterJs from "rater-js";

document.addEventListener("DOMContentLoaded", (event) => {
  let ratingInput = document.querySelector("#rating");
  let ratingEdit = document.querySelector("#rating-edit");

  let rater = raterJs({
    element: document.querySelector("#basic"),
    starSize: 36,
    rateCallback: function rateCallback(rating, done) {
      this.setRating(rating);
      ratingInput.value = rating; // Set the rating value to the hidden input
      done();
    },
  });
  let raterEdit = raterJs({
    element: document.querySelector("#basic-edit"),
    starSize: 36,
    rateCallback: function rateCallback(rating, done) {
      this.setRating(rating);
      ratingEdit.value = rating; // Set the rating value to the hidden input
      done();
    },
  });
  $(document).on("click", "#btn-comment", function () {
    let id = $(this).data("id");
    let order = $(this).data("order");
    let cart = $(this).data("cart");
    $("#order_id").val(order);
    $("#product_id").val(id);
    $("#cart_id").val(cart);
    $("#modal-comment").modal("show");
    $("#rating").val(0);
    $("#comment").val("");
    rater.clear(); // Reset the stars to zero
  });

  $(document).on("click", "#btn-edit", function () {
    let reviewId = $(this).data("id");
    let cartId = $(this).data("cart");
    let orderId = $(this).data("order");
    let productId = $(this).data("product");
    $.ajax({
      url: `/review/edit/${reviewId}`, // Ganti dengan endpoint yang sesuai
      method: "GET",
      success: function (response) {
        $("#cart_id").val(cartId);
        $("#order_id").val(orderId);
        $("#product_id").val(productId);
        $("#modal-comment-edit").modal("show");
        $("#review_id").val(reviewId);
        $("#rating-edit").val(response.data.rating);
        $("#comment-edit").val(response.data.comment);
        raterEdit.setRating(response.data.rating);
      },
    });
  });
});
