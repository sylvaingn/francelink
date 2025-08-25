'use strict';

// Voir le README.md pour plus d'informations
import env from 'dotenv';

import gulp from 'gulp';

import gulpSass from "gulp-sass";
import * as nodeSass from "sass";

const sass = gulpSass(nodeSass);

import gulpEsbuild from 'gulp-esbuild'
import browserSync from 'browser-sync';

const browserSyncCreate = browserSync.create();
import autoprefixer from 'autoprefixer';
import postcss from 'gulp-postcss';
import minifyCss from 'gulp-minify-css';

env.config();


const dist_folder = './dist';

const scss_src = './scss/**/*.scss';
const js_src = ['./js/**/*.js'];

function buildStylesDev() {
    return gulp.src(scss_src)
        .pipe(sass({
            silenceDeprecations: ['legacy-js-api'],
        }).on('error', sass.logError))
        .pipe(gulp.dest(dist_folder));
}

function buildStylesProd() {
    const processors = [
        autoprefixer({overrideBrowserslist: ['last 99 versions']})
    ];
    return gulp.src(scss_src)
        .pipe(sass({
            silenceDeprecations: ['legacy-js-api'],
        }).on('error', sass.logError))
        .pipe(postcss(processors))
        .pipe(minifyCss())
        .pipe(gulp.dest(dist_folder));
}

function buildJsDev() {
    return gulp.src(js_src)
        .pipe(gulpEsbuild({bundle: true}))
        .pipe(gulp.dest(dist_folder));
}

function buildJsProd() {
    return gulp.src(js_src)
        .pipe(gulpEsbuild({bundle: true, minify: true, pure: ['console.log']}))
        .pipe(gulp.dest(dist_folder));
}

export const build = gulp.parallel(buildJsProd, buildStylesProd);
export const watch = function () {
    gulp.watch(js_src, gulp.series(buildJsDev));
    gulp.watch(scss_src, gulp.series(buildStylesDev));
    browserSyncCreate.init({
        proxy: process.env.LOCAL_CONFIG,
        files: ['./**']
    });
};