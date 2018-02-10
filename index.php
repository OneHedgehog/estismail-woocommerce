<?php

/*
* Plugin Name: Estismail Woocommerce
* Plugin URI: https://estismail.com
* Description: WooCommerce Estismail provides simple Estismail integration for WooCommerce.
* Author: Estismail
* Version: 1.0
* Author URI: https://estismail.com
* Text Domain: estismail-wc-translate
* Domain Path: /langs/
*/
require_once('constant.php');
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    function estis_wc_activation_plugin()
    {
        add_option(ESTIS_WC_PREFIX . '_checkbox_position', 'woocommerce_before_checkout_shipping_form');
        add_option(ESTIS_WC_PREFIX . '_plugin_functionality', 'yes');
    }

    register_activation_hook(__FILE__, ESTIS_WC_PREFIX . '_activation_plugin');

    $position = get_option(ESTIS_WC_PREFIX . '_checkbox_position');
    $plugin_func = get_option(ESTIS_WC_PREFIX . '_plugin_functionality');

    define('ESTIS_WC_ABS_PATH', plugin_dir_path( __FILE__ ) . "index.php");

    require_once( 'include/functions.php' );
    require_once( 'include/settings.php' );
    require_once( 'include/notices.php' );
    require_once( 'include/delete-notice.php' );

    if ($plugin_func === 'yes') {
        require_once( 'include/view.php' );
        require_once( 'include/checkout.php' );
    }

    add_filter('woocommerce_settings_tabs_array', ESTIS_WC_PREFIX . '_add_settings_tab', 100);
    add_action('woocommerce_update_options_estismail', ESTIS_WC_PREFIX . '_update_settings');
    add_action('admin_post_est_wc_notice_delete', 'estismail_wc_delete_notice');

    if ($plugin_func === 'yes') {
        add_filter((string)$position, ESTIS_WC_PREFIX . '_add_checkbox');
        add_action('woocommerce_checkout_process', ESTIS_WC_PREFIX . '_subscribe_after_checkout');
    }

    function estis_wc_update_settings()
    {
        woocommerce_update_options(estis_wc_get_settings());
    }

} else {
    function estis_wc_plugin_deactivate()
    {
        if ($active_plugins = get_option('active_plugins')) {
            $deactivate_this = array(
                'estismail-woocommerce/index.php'
            );
            $active_plugins = array_diff($active_plugins, $deactivate_this);
            update_option('active_plugins', $active_plugins);
        }
    }

    add_action('admin_init', ESTIS_WC_PREFIX . '_plugin_deactivate');

    function estis_wc_admin_notice()
    {
        ?>
        <style>div#message.updated {
                display: none;
            }</style>
        <div class="notice notice-error is-dismissible">
            <h1>
                <?php _e('WooCommerce Estismail: WooCommerce should be active!', 'estismail-wc-translate'); ?>
            </h1>
        </div>
        <?php
    }

    add_action('admin_notices', ESTIS_WC_PREFIX .'_notice');
}

add_action('plugins_loaded', ESTIS_WC_PREFIX . '_true_load_textdomain');

function estis_wc_true_load_textdomain()
{
    load_plugin_textdomain('estismail-wc-translate', false, dirname(plugin_basename(__FILE__)) . '/langs/');
}

?>