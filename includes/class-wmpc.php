<?php
namespace WMPC;
/**
 * 
 */
 if (!defined('ABSPATH')) {
     exit;
 }

class WMPC
{
    private static $wmpc;
    private static $version;

    public function __construct()
    {
        if (defined('WMPC_VERSION')) {
            self::$version = WMPC_VERSION;
        } else {
            self::$version = '0.1.0';
        }

        self::$wmpc = WMPC_SLUG;
        
    }

    public function render_memberships_card($user_id)
    {
        
    }


    public function get_options()
    {
        $options = get_option('wmpc_optios', array());

        
    }

    public static function run()
    {
        return self::$wmpc;
    }

    public function get_wmpc()
    {
        return self::$wmpc;
    }

    public function get_version()
    {
        return self::$version;
    }
}
