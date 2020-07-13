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
    let pathname = window.location.pathname;
    // remove active class from all.
    $(".navbar .nav-item").removeClass('active');
    if (undefined !== pathname && pathname.includes('admin')) {
        let split = pathname.split('/');
        if (split.length > 3) {
            split = split.slice(0, 3);
            pathname = split.join('/');
        }
        // add active class to div that matches active url.
        $("a[href*='" + pathname + "'], a[class='nav-item']").addClass('active');
    }
});
