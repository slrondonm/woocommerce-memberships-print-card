<?php
namespace WMPC\Libs;
/**
 * 
 * 
 */

class WMPC_Utils
{

    public static function include_pluggables($function_name) {
        if(!function_exists($function_name)) {
          require_once(ABSPATH . WPINC .'/pluggable.php');
        }
    }

    public static function is_user_logged_in() {

        self::include_pluggables('is_user_logged_in');
        
        return is_user_logged_in();
    }

    public static function get_currentuserinfo() {
        global $woocommerce;

        self::include_pluggables('wp_get_current_user');
        
        $current_user = wp_get_current_user();
    
        if(isset($current_user->ID) && $current_user->ID > 0) {
            return $woocommerce->get('my-account/' . $current_user->ID);
        }
        else {
            return false;
        }
    }

    public static function mysql_lifetime() {
        return self::db_lifetime();
    }

    public static function db_lifetime() {
        return '0000-00-00 00:00:00';
    }
}
