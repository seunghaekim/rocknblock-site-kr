const gulp = require("gulp");

module.exports = function plugins() {
  return gulp.src("src/plugins/**/*").pipe(gulp.dest("build/plugins/"));
};
