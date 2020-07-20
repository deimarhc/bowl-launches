/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
require('bootstrap');
require('multiple-select');

// any CSS you import will output into a single css file (app.scss in this case)
import 'multiple-select/dist/multiple-select.css';
import 'multiple-select/dist/themes/bootstrap.css'
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

jQuery(document).ready(function() {
    // Enable multiple select.
    $('select').multipleSelect({ selectAll: false });

    // Order search input.
    $("#search-orders-input").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $("#orders-table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Nav active links.
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

    // Add some classes dinamically.
    $('.multiple-list-group fieldset').addClass('list-group-item mb-0');
});
