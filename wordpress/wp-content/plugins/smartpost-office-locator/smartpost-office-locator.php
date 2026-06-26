<?php
/*
Plugin Name: SmartPost Office Locator
Description: Legacy Post Office Locator System
Version: 1.0
Author: SmartPost Team
*/

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create custom table
 */
register_activation_hook(__FILE__, 'sp_create_office_table');

function sp_create_office_table()
{
    global $wpdb;

    $table = $wpdb->prefix . "post_offices";

    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        office_name VARCHAR(100),
        city VARCHAR(50),
        postal_code VARCHAR(20)
    )";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}


/**
 * Admin Menu
 */
add_action('admin_menu', 'sp_office_menu');

function sp_office_menu()
{
    add_menu_page(
        'Post Offices',
        'Post Offices',
        'manage_options',
        'sp-office',
        'sp_office_page'
    );
}


/**
 * Legacy AJAX implementation
 */
function sp_office_page()
{
?>
<h2>Post Office Locator</h2>

<input type="text" id="city" placeholder="Enter city">
<button onclick="searchOffice()">Search</button>

<div id="result"></div>


<script>

function searchOffice()
{
    var city = document.getElementById('city').value;

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data:{
            action:'search_office',
            city: city
        },
        success:function(response){
            document.getElementById('result').innerHTML=response;
        }
    });
}

</script>

<?php
}


/**
 * AJAX Handler
 */
add_action(
    'wp_ajax_search_office',
    'sp_search_office'
);


function sp_search_office()
{
    global $wpdb;

    $table = $wpdb->prefix . "post_offices";

    $city = $_POST['city']; // Intentionally no sanitization (legacy issue)

    $result = $wpdb->get_results(
        "SELECT * FROM $table WHERE city='$city'"
    );


    foreach($result as $row)
    {
        echo $row->office_name . " - " . $row->postal_code . "<br>";
    }

    wp_die();
}