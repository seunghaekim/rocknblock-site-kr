const gulp = require("gulp");

module.exports = function seo() {
  return gulp.src("src/seo/**/*").pipe(gulp.dest("build/"));
};
