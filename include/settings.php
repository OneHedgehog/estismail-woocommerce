<?php
function estis_wc_add_settings_tab($settings_tabs)
{
    $settings_tabs['estismail'] = 'Estismail';
    return $settings_tabs;
}

add_action('woocommerce_settings_tabs_estismail', ESTIS_WC_PREFIX . '_tab');
function estis_wc_tab()
{
    woocommerce_admin_fields(estis_wc_get_settings());
}

add_action('woocommerce_settings_tabs_estismail', ESTIS_WC_PREFIX . '_get_settings');
function estis_wc_get_settings()
{

    $settings = array(
        array(
            'name' => __('Estismail', 'estismail-wc-translate'),
            'type' => 'title',
            'desc' => __('Enter your Estismail settings below to control how WooCommerce integrates with your Estismail account.', 'estismail-wc-translate'),
            'id' => ESTIS_WC_PREFIX . '_title_main',
        ),

	    array(
            'name' => __('API key', 'estismail-wc-translate'),
            'type' => 'text',
            'value' => '_',
            'placeholder' => __('Paste your Estismail API key here', 'estismail-wc-translate'),
            'desc' => __('Enter your API key', 'estismail-wc-translate'), // NOTE Not working
            'id' => ESTIS_WC_PREFIX . '_api_key',
            'css' => 'min-width: 300px'
        ),
    );

    $api_key = get_option(ESTIS_WC_PREFIX . '_api_key');

    if ($api_key) {

        $user_params = array('fields' => json_encode(array('login', 'email', 'name')));
        $user_url = 'https://v1.estismail.com/mailer/users?' . http_build_query($user_params);
        $user_data = estis_wc_remote_get($user_url, $api_key);

        if (!$user_data) {

            $settings['1']['desc'] = __('Error . Please check your api key', 'estismail-wc-translate');

            $settings['section_end'] = array(
                'type' => 'sectionend',
                'id' => 'wc_estismail_section_end'
            );
            return apply_filters('wc_estismail_settings', $settings);
        }

        $lists_params = array('fields' => json_encode(array('id', 'title', 'about', 'sender_email_id')));
        $lists_url = 'https://v1.estismail.com/mailer/lists?' . http_build_query($lists_params);
        $lists_data = estis_wc_remote_get($lists_url, $api_key);

        $settings['api_key']['desc'] = 'Connected';
        $settings[] = array(
            'name' => __('Opt-In Field Label', 'estismail-wc-translate'),
            'type' => 'text',
            'value' => '',
            'id' => ESTIS_WC_PREFIX . '_checkout_checkbox_text',
            'desc' => __('"Subscribe me" by default', 'estismail-wc-translate'),
            'default' => 'Subscribe me!',
            'css' => 'min-width: 300px',
            'required' => 'required',
        );

        if ($lists_data) {
            $lists_title = [];
            foreach ($lists_data['lists'] as $key => $value) {
                $lists_title[$value['id']] = $value['title'];
            }
        } else {
            $lists_title = ['' => ""];
        }

        $settings[] = array(
            'name' => __('Main List', 'estismail-wc-translate'),
            'type' => 'select',
            'desc' => __('All customers will be added to this list.', 'estismail-wc-translate'),
            'id' => ESTIS_WC_PREFIX . '_list_value',
            'default' => '',
            'value' => isset($value['id']) ? $value['id'] : '',
            'options' => $lists_title,
            'css' => 'min-width: 300px'
        );

        $settings[] = array(
            'name' => __('Double opt-in', 'estismail-wc-translate'),
            'type' => 'select',
            'desc' => '',
            'id' => ESTIS_WC_PREFIX . '_double-opt',
            'default' => '',
            'css' => 'min-width: 300px',
            'options' => array(
                '1' => __('Enable double-opt in', 'estismail-wc-translate'),
                '0' => __('Disable double-opt in', 'estismail-wc-translate')
            )
        );

        $settings[] = array(
            'id' => ESTIS_WC_PREFIX . '_plugin_functionality',
            'title' => __('Enable/Disable', 'estismail-wc-translate'),
            'label' => '',
            'type' => 'checkbox',
            'desc' => __('Enable/disable the estismail plugin functionality.', 'estismail-wc-translate'),
            'default' => 'yes',
            'css' => 'min-width: 300px'
        );

        $settings[] = array(
            'name' => __('Position', 'estismail-wc-translate'),
            'type' => 'select',
            'desc' => __('Select your checkbox position', 'estismail-wc-translate'),
            'id' => ESTIS_WC_PREFIX . '_checkbox_position',
            'default' => '',
            'value' => 'woocommerce_checkout_before_customer_details',
            'css' => 'min-width: 300px',
            'options' =>
                [
                    'woocommerce_checkout_before_customer_details'     => __('Above customer details',              'estismail-wc-translate'),
                    'woocommerce_checkout_after_customer_details'      => __('Below customer details',              'estismail-wc-translate'),
                    'woocommerce_review_order_before_submit'           => __('Order review above submit',           'estismail-wc-translate'),
                    'woocommerce_review_order_after_submit'            => __('Order review below submit',           'estismail-wc-translate'),
                    'woocommerce_review_order_before_order_total'      => __('Order review above total',            'estismail-wc-translate'),
                    'woocommerce_checkout_billing'                     => __('Above billing details',               'estismail-wc-translate'),
                    'woocommerce_checkout_shipping'                    => __('Above shipping details',              'estismail-wc-translate'),
                    'woocommerce_after_checkout_billing_form'          => __('Below Checkout billing form',         'estismail-wc-translate'),
                    'woocommerce_checkout_before_terms_and_conditions' => __('Above Checkout Terms and Conditions', 'estismail-wc-translate'),
                    'woocommerce_checkout_after_terms_and_conditions'  => __('Below Checkout Terms and Conditions', 'estismail-wc-translate')
                ]
        );

    } else {
        $settings['api_key']['desc'] = '';
    }

    $settings['section_end'] = array(
        'type' => 'sectionend',
        'id' => 'wc_estismail_section_end'
    );

    return apply_filters('wc_estismail_settings', $settings);
}