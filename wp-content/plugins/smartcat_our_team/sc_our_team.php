<?php
/*
  Plugin Name: Our Team Showcase Pro
  Plugin URI: http://smartcatdesign.net/downloads/our-team-showcase/
  Description: Display your team members in a very attractive way as a widget or page with a shortcode
  Version: 3.1
  Author: SmartCat
  Author URI: http://smartcatdesign.net
 * 
 * @author          Bilal Hassan <bilal@smartcat.ca>
 * @copyright       Smartcat Design <http://smartcatdesign.net>
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
    die;
}
if (!defined('SC_TEAM_PATH'))
    define('SC_TEAM_PATH', plugin_dir_path(__FILE__));
if (!defined('SC_TEAM_URL'))
    define('SC_TEAM_URL', plugin_dir_url(__FILE__));
if (!defined('SMARTCAT_STORE_URL'))
    define('SMARTCAT_STORE_URL', 'http://smartcatdesign.net');
if (!defined('SMARTCAT_OUR_TEAM_STORE_ITEM_NAME'))
    define('SMARTCAT_OUR_TEAM_STORE_ITEM_NAME', 'Our Team Showcase Pro');

require_once ( plugin_dir_path( __FILE__ ) . 'inc/class/class.smartcat-team.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'inc/class/class.smartcat-updater.php' );


// activation and de-activation hooks

register_activation_hook( __FILE__, array( 'SmartcatTeamPlugin', 'activate' ) );
register_deactivation_hook( __FILE__, array('SmartcatTeamPlugin', 'deactivate')  );

SmartcatTeamPlugin::instance();

add_action('admin_init', 'smartcat_our_team_updater', 0);

function smartcat_our_team_updater() {

    $license_key = trim( get_option('smartcat_our_team_key') );

    
    $edd_updater = new EDD_SL_Plugin_Updater(SMARTCAT_STORE_URL, __FILE__, array(
        'version' => SmartcatTeamPlugin::VERSION,
        'license' => $license_key,
        'item_name' => SmartcatTeamPlugin::NAME,
        'author' => 'Smartcat'
        )
    );
}

