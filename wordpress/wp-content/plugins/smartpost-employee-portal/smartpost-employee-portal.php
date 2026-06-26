<?php
/*
Plugin Name: SmartPost Employee Portal
Description: Legacy employee management and leave request system.
Version: 1.0
Author: SmartPost Team
*/

if (!defined('ABSPATH')) {
    exit;
}


/*
|--------------------------------------------------------------------------
| Create Employee Roles
|--------------------------------------------------------------------------
*/

register_activation_hook(__FILE__, 'sp_employee_activate');

function sp_employee_activate()
{
    add_role(
        'postal_manager',
        'Postal Manager',
        [
            'read' => true,
            'manage_leave' => true
        ]
    );

    add_role(
        'delivery_agent',
        'Delivery Agent',
        [
            'read' => true
        ]
    );


    add_role(
        'customer_support',
        'Customer Support',
        [
            'read' => true
        ]
    );


    sp_create_leave_table();
}


/*
|--------------------------------------------------------------------------
| Create Leave Table
|--------------------------------------------------------------------------
*/

function sp_create_leave_table()
{
    global $wpdb;

    $table = $wpdb->prefix . "employee_leaves";


    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        employee_id INT,
        employee_name VARCHAR(100),
        leave_date DATE,
        reason TEXT,
        status VARCHAR(20) DEFAULT 'Pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";


    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}



/*
|--------------------------------------------------------------------------
| Admin Menu
|--------------------------------------------------------------------------
*/

add_action('admin_menu', 'sp_employee_menu');


function sp_employee_menu()
{
    add_menu_page(
        'Employee Portal',
        'Employee Portal',
        'read',
        'sp-employee',
        'sp_employee_page',
        'dashicons-groups'
    );
}


/*
|--------------------------------------------------------------------------
| Legacy Dashboard
|--------------------------------------------------------------------------
*/

function sp_employee_page()
{

    /*
    Legacy WordPress function.
    Deprecated in modern WordPress.
    We will replace during upgrade.
    */
    get_currentuserinfo();

    global $current_user;


    if(isset($_POST['submit_leave']))
    {

        /*
        Legacy issues:
        - No nonce
        - No sanitization
        - No capability check
        */

        global $wpdb;


        $table = $wpdb->prefix . "employee_leaves";


        $wpdb->insert(
            $table,
            [
                'employee_id' => $current_user->ID,
                'employee_name' => $_POST['name'],
                'leave_date' => $_POST['leave_date'],
                'reason' => $_POST['reason']
            ]
        );


        echo "<h3>Leave request submitted</h3>";
    }


    ?>

    <div class="wrap">

        <h1>Employee Dashboard</h1>

        <h3>
            Welcome 
            <?php echo $current_user->display_name; ?>
        </h3>


        <form method="POST">

            Name:
            <input 
                type="text"
                name="name"
            />

            <br><br>


            Leave Date:
            <input 
                type="date"
                name="leave_date"
            />

            <br><br>


            Reason:
            <textarea name="reason"></textarea>

            <br><br>


            <input 
                type="submit"
                name="submit_leave"
                value="Apply Leave"
            />

        </form>


    </div>


<?php
}