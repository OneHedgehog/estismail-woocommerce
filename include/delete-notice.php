<?php
function estismail_wc_delete_notice()
{
    delete_option(ESTIS_WC_PREFIX . '_checkout_err_notice');
    wp_redirect($_SERVER['HTTP_REFERER']);
}