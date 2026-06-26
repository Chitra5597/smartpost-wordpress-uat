<?php
/*
Plugin Name: SmartPost Notification Service
Description: Legacy email notification and scheduler system.
Version: 1.0
Author: SmartPost Team
*/

if (!defined('ABSPATH')) {
    exit;
}


/**
 * Plugin Activation
 */
register_activation_hook(__FILE__, 'sp_notification_activate');

function sp_notification_activate()
{
    sp_create_log_table();

    // Legacy cron scheduling
    if (!wp_next_scheduled('sp_daily_notification_event')) {
        wp_schedule_event(
            time(),
            'hourly',
            'sp_daily_notification_event'
        );
    }
}


/**
 * Create Notification Log Table
 */
function sp_create_log_table()
{
    global $wpdb;

    $table = $wpdb->prefix . "notification_logs";

    $sql = "
    CREATE TABLE IF NOT EXISTS $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100),
        subject VARCHAR(255),
        status VARCHAR(50),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}


/**
 * Cron Hook
 */
add_action(
    'sp_daily_notification_event',
    'sp_send_notifications'
);


/**
 * Legacy Email Process
 */
function sp_send_notifications()
{
    $email = "customer@smartpost.com";

    $subject = "SmartPost Daily Update";

    $message = "
        Dear Customer,

        Your shipment status has been updated.

        Thank you,
        SmartPost Team
    ";


    /*
     Legacy issue:
     Using PHP mail()
     We will replace with wp_mail()
     during upgrade
    */

    $result = mail(
        $email,
        $subject,
        $message
    );


    global $wpdb;

    $table = $wpdb->prefix . "notification_logs";


    $wpdb->insert(
        $table,
        [
            'email' => $email,
            'subject' => $subject,
            'status' => $result ? 'Sent' : 'Failed'
        ]
    );
}


/**
 * Admin Menu
 */
add_action('admin_menu', 'sp_notification_menu');


function sp_notification_menu()
{
    add_menu_page(
        'Notifications',
        'Notifications',
        'manage_options',
        'sp-notification',
        'sp_notification_page',
        'dashicons-email'
    );
}


/**
 * Admin Settings Page
 */
function sp_notification_page()
{

    /*
     Legacy problems:
     - No nonce
     - No sanitization
     - Direct option update
    */

    if (isset($_POST['save_settings'])) {

        update_option(
            'sp_admin_email',
            $_POST['admin_email']
        );

        echo "<h3>Settings Saved</h3>";
    }

    $email = get_option(
        'sp_admin_email',
        'admin@smartpost.com'
    );

?>

<div class="wrap">

<h1>Notification Settings</h1>


<form method="post">

Admin Email:
<input
    type="email"
    name="admin_email"
    value="<?php echo $email; ?>"
/>

<br><br>

<input
    type="submit"
    name="save_settings"
    value="Save Settings"
/>

</form>


<h2>Run Notification Manually</h2>


<form method="post">

<input
    type="submit"
    name="send_now"
    value="Send Test Notification"
/>

</form>


<?php

if (isset($_POST['send_now'])) {

    sp_send_notifications();

    echo "<h3>Notification Triggered</h3>";
}

?>

</div>


<?php
}