<?php

function estis_wc_subscribe_after_checkout()
{

    if (isset($_POST['checkbox_input'])) {
        $api_key = get_option(ESTIS_WC_PREFIX . '_api_key');
        $url = 'https://v1.estismail.com/mailer/users';

        if (!estis_wc_remote_get($url, $api_key)) {
            update_option(ESTIS_WC_PREFIX . '_checkout_err_notice', true);
            return;
        };

        $url = 'https://v1.estismail.com/mailer/emails';

        $params = array(
            'email' => $_POST['billing_email'],
            'list_id' => get_option(ESTIS_WC_PREFIX . '_list_value'),
            'name' => $_POST['billing_first_name'] . " " . $_POST['billing_last_name'],
            'city' => $_POST['billing_city'],
            'phone' => $_POST['billing_phone'],
            'activation_letter' => get_option(ESTIS_WC_PREFIX . '_double-opt')
        );

        $query = estis_wc_remote_post($url, $params, $api_key);

        if (!$query) {
            update_option(ESTIS_WC_PREFIX . '_checkout_err_notice', true);
        } else {
            delete_option(ESTIS_WC_PREFIX . '_checkout_err_notice');
        }
    }
}