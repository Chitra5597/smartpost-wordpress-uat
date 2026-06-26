<?php
/*
Plugin Name: SmartPost Shipment Tracker
Description: Legacy shipment tracking system.
Version: 1.0
Author: SmartPost Team
*/

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Legacy PHP Issue
|--------------------------------------------------------------------------
| This code will break in PHP 7+
| We will fix this during upgrade.
*/
function sp_parse_tracking_data($data)
{
    return explode(",", $data);
}


add_action('admin_menu', 'sp_shipment_menu');

function sp_shipment_menu()
{
    add_menu_page(
        'Shipment Tracker',
        'Shipment',
        'manage_options',
        'sp-shipment',
        'sp_shipment_page'
    );
}


function sp_shipment_page()
{
    echo "<h1>Shipment Tracking System</h1>";

    $tracking = "P1001,P1002,P1003";

    $result = sp_parse_tracking_data($tracking);

    echo "<pre>";
    print_r($result);
    echo "</pre>";
}