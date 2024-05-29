import raterJs from "rater-js";
raterJs({
  element: document.querySelector("#basic"),
  starSize: 36,
  rateCallback: function rateCallback(rating, done) {
    this.setRating(rating);
    done();
  },
});
