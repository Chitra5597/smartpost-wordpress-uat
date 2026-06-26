<?php
/*
Plugin Name: SmartPost Customer Feedback
Description: Legacy customer complaint and feedback system.
Version: 1.0
Author: SmartPost Team
*/

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Create database table
 */
register_activation_hook(__FILE__, 'sp_feedback_table');

function sp_feedback_table()
{
    global $wpdb;

    $table = $wpdb->prefix . "feedback";

    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        attachment VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";
    dbDelta($sql);
}


/**
 * Admin menu
 */
add_action('admin_menu', 'sp_feedback_menu');


function sp_feedback_menu()
{
    add_menu_page(
        "Customer Feedback",
        "Feedback",
        "manage_options",
        "sp-feedback",
        "sp_feedback_page"
    );
}


/**
 * Legacy Admin Page
 */
function sp_feedback_page()
{

    if (isset($_POST['submit_feedback']))
    {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        /*
        Legacy issue:
        No sanitization
        No nonce validation
        */
        
        
        $filename = $_FILES['attachment']['name'];

        move_uploaded_file(
            $_FILES['attachment']['tmp_name'],
            ABSPATH . "uploads/" . $filename
        );


        global $wpdb;

        $table = $wpdb->prefix . "feedback";


        $wpdb->insert(
            $table,
            [
                "name" => $name,
                "email" => $email,
                "message" => $message,
                "attachment" => $filename
            ]
        );


        /*
        Legacy email implementation
        */
        mail(
            "admin@smartpost.com",
            "New Feedback Received",
            $message
        );


        echo "Feedback submitted successfully";
    }

?>

<h2>Customer Feedback</h2>


<form method="post" enctype="multipart/form-data">

Name:
<input type="text" name="name"><br><br>


Email:
<input type="email" name="email"><br><br>


Message:
<textarea name="message"></textarea><br><br>


Attachment:
<input type="file" name="attachment"><br><br>


<input type="submit" name="submit_feedback" value="Submit">


</form>


<?php

}