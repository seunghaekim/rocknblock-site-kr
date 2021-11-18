const gulp = require("gulp");

module.exports = function manifest() {
  return gulp.src("src/manifest/**/*").pipe(gulp.dest("build/"));
};
