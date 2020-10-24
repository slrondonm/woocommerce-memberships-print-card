<?php

namespace WMPC;

/**
 * 
 */
if (!defined('ABSPATH')) {
    exit;
}

use WMPC\Libs\WMPC_Options;
use WMPC\Libs\WMPC_Product;
use WMPC\Libs\WMPC_Utils;

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

    public static function load_scripts() {
        wp_enqueue_script('print-admin-page-js', WMPC_SCRIPTS_URL . 'js/printThis.js', array());
        wp_enqueue_script('mant-admin-page-js', WMPC_SCRIPTS_URL . 'js/admin_page.js', array('jquery'));
        wp_enqueue_style('mant-admin-page-css', WMPC_SCRIPTS_URL . 'css/wmpc-main.css');    }

    public static function menu()
    {
        $page_title = "WooCommerce";

        $exist = self::toplevel_menu_exists($page_title);

        if (!$exist) {
            add_menu_page(
                $page_title . ' - Printable Membership Cards',
                $page_title,
                'manage_options',
                'wc-toolbox',
                array(self::class, 'admin_page'),
                'dashicons-hammer'
            );
            add_submenu_page(
                'woocommerce',
                $page_title . ' - Printable Membership Cards',
                'Membership Cards',
                'manage_options',
                'wc-toolbox',
                array(self::class, 'admin_page')
            );
        } else {
            add_submenu_page(
                'woocommerce',
                $page_title . ' - Printable Membership Cards',
                'Printable Membership Cards',
                'manage_options',
                'wc-toolbox-membership-cards',
                array(self::class, 'admin_page')
            );
        }
    }

    public static function save_admin_page()
    {
        if (!isset($_POST['wmpc-admin-page-submit'])) {
            return;
        }

        $options = array();

        $options['registered_label'] = (isset($_POST['wmpc-registered-label'])) ? sanitize_text_field(stripslashes($_POST['wmpc-registered-label'])) : '';
        $options['memberships_label'] = (isset($_POST['wmpc-memberships-label'])) ? sanitize_text_field(stripslashes($_POST['wmpc-memberships-label'])) : '';
        $options['renews_expires_label'] = (isset($_POST['wmpc-renews-expires-label'])) ? sanitize_text_field(stripslashes($_POST['wmpc-renews-expires-label'])) : '';
        $options['membership_number_label'] = (isset($_POST['wmpc-membership-number-label'])) ? sanitize_text_field(stripslashes($_POST['wmpc-membership-number-label'])) : '';
        $options['membership_number_prefix'] = (isset($_POST['wmpc-membership-number-prefix'])) ? sanitize_text_field(stripslashes($_POST['wmpc-membership-number-prefix'])) : __('M-NUM-', WMPC_SLUG);
        $options['membership_background_img_url'] = (isset($_POST['wmpc-background-img-url'])) ? sanitize_text_field(stripslashes($_POST['wmpc-background-img-url'])) : '';
        $options['show_site_title'] = isset($_POST['wmpc-show-site-title']);

        update_option('wmpc_options', $options);
    }

    public static function admin_page()
    {
        $options = self::get_options();
        include(WMPC_PATH . '/templates/admin/admin_page.php');
    }

    public static function get_options()
    {
        $options = get_option('wmpc_options', array());
        $options['registered_label'] = (isset($options['registered_label'])) ? trim(stripslashes($options['registered_label'])) : __('Registered', WMPC_PREFIX);
        $options['memberships_label'] = (isset($options['memberships_label'])) ? trim(stripslashes($options['memberships_label'])) : __('Membership(s)', WMPC_PREFIX);
        $options['renews_expires_label'] = (isset($options['renews_expires_label'])) ? trim(stripslashes($options['renews_expires_label'])) : __('Renews/Expires', WMPC_PREFIX);
        $options['membership_number_label'] = (isset($options['membership_number_label'])) ? trim(stripslashes($options['membership_number_label'])) : __('Membership #', WMPC_PREFIX);
        $options['membership_number_prefix'] = (isset($options['membership_number_prefix'])) ? stripslashes($options['membership_number_prefix']) : __('M-NUM-', WMPC_PREFIX);
        $options['membership_background_img_url'] = (isset($options['membership_background_img_url'])) ? trim(stripslashes($options['membership_background_img_url'])) : '';
        $options['show_site_title'] = (isset($options['show_site_title'])) ? (bool)$options['show_site_title'] : false;

        return $options;
    }

    public static function toplevel_menu_exists($title)
    {
        global $menu;
        foreach ($menu as $item) {
            if (strtolower($item[0]) == strtolower($title)) {
                return true;
            }
        }
        return false;
    }

    public static function get_member_name($user) {
        $name = $user->first_name . ' ' . $user->last_name;
    
        if(empty(trim($name))) {
            $name = $user->user_login;
        }
    
        return $name;
    }

    public static function wmpc_custom_members_area_sections( $sections ) {
        $new_sections = array();
        $new_sections['print-member-card'] = __('Carnet de Miembro', WMPC_SLUG);

        foreach ($sections as $key => $section) {
            $new_sections[$key] = $section;
        }

        if ('print-member-card' === $new_sections) {
            self::get_templates('print-member-card', $new_sections);
        }

        return $new_sections;
    }

    public static function get_templates($section, $args)
    {
        // bail out: no args, no party
		if ( empty( $args['user_membership'] ) && empty( $args['user_id'] ) && ( ! $args['user_membership'] instanceof \WC_Memberships_User_Membership ) ) {
			return;
        }
        
        // $customer_memberships = wc_memberships_get_user_membership();
        
        if ('print-member-card' === $section) {
            wc_get_template(WMPC_PATH . '/templates/myaccount/print-member-card.php', ['customer_memberships' => $args['user_memberships'], 'user_id' => $args['user_id']]);
        }
    }

    public static function run()
    {
        add_action('admin_menu', [self::class, 'menu']);
        add_action('admin_init', [self::class, 'save_admin_page']);
        add_action('admin_enqueue_scripts',   array(self::class, 'load_scripts'));

        add_filter( 'wc_membership_plan_members_area_sections', [self::class, 'wmpc_custom_members_area_sections']);

        add_action('wc_memberships_print_member_card_sections', [self::class, 'get_templates']);

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
