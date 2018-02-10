<?php
function estis_wc_remote_get($url, $key)
{
    $response = wp_remote_get($url,
        array(
            'timeout' => 3,
            'httpversion' => '1.1',
            'sslverify' => true,
            'headers' => array('X-Estis-Auth' => $key))
    );

    if (wp_remote_retrieve_response_code($response) !== 200) {
        update_option(ESTIS_WC_PREFIX . '_login_err', $response['body']);
        return false;
    } else {
        delete_option(ESTIS_WC_PREFIX . '_login_err');
        return json_decode($response['body'], true);
    }
}

function estis_wc_remote_post($url, $params, $api_key)
{

    $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 15,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array('X-Estis-Auth' => $api_key),
            'body' => $params,
            'cookies' => array()
        )
    );

    if (wp_remote_retrieve_response_code($response) !== 201) {
        update_option(ESTIS_WC_PREFIX . '_plug_checkout_err', $response['body']);
        return false;
    } else {
        delete_option(ESTIS_WC_PREFIX . '_plug_checkout_err');
        return ($response);
    }
}