const gulp = require("gulp");
const webp = require("gulp-webp");

module.exports = function imgsWebp() {
  return gulp
    .src("src/img/**/*.{jpg,jpeg,png}")
    .pipe(
      webp({
        quality: 90,
      })
    )
    .pipe(gulp.dest("build/img"));
};
