<?php
namespace WMPC\Libs;
/**
 * 
 * 
 */
class WMPC_Options
{  
    public $dynamic_attrs;

    public function __construct($options = array()) {
        return $options;
    }
    
    public static function fetch($force = false)
    {
        static $wmpc_options;

        if(!isset($wmpc_options) or $force) {
        $wmpc_options_array = get_option(WMPC_SLUG);

        if(!$wmpc_options_array)
            $wmpc_options = new WMPC_Options(); // Just grab the defaults
        else if(is_object($wmpc_options_array) and is_a($wmpc_options_array, 'WMPC_Options')) {
            $wmpc_options = $wmpc_options_array;
        }
        else if(!is_array($wmpc_options_array))
            $wmpc_options = new WMPC_Options(); // Just grab the defaults
        else
            $wmpc_options = new WMPC_Options($wmpc_options_array); // Sets defaults for unset options
        }
        return MeprHooks::apply_filters('wmpc_fetch_options', $wmpc_options);
    }

    public static function account_page_url()
    {
        # code...
    }
}
