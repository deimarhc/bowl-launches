/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
require('bootstrap');

// any CSS you import will output into a single css file (app.scss in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

jQuery(document).ready(function() {

    const location = window.location.pathname;
    // remove active class from all
    $(".navbar .nav-item").removeClass('active');

// add active class to div that matches active url
    $("a[href='" + location + "'], a[class='nav-item']").addClass('active');
});
