<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
//ESTIS_WC_PREFIX
require_once ('constant.php');

delete_option(ESTIS_WC_PREFIX . '_title_main');
delete_option(ESTIS_WC_PREFIX . '_checkout_checkbox_text');
delete_option(ESTIS_WC_PREFIX . '_api_key');
delete_option(ESTIS_WC_PREFIX . '_list_value');
delete_option(ESTIS_WC_PREFIX . '_double-opt');
delete_option(ESTIS_WC_PREFIX . '_plugin_functionality');
delete_option(ESTIS_WC_PREFIX . '_checkbox_position');
delete_option(ESTIS_WC_PREFIX . '_login_err');
delete_option(ESTIS_WC_PREFIX . '_plug_checkout_err');