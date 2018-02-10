<?php
$display = get_option(ESTIS_WC_PREFIX . '_checkout_err_notice');
$list_err = get_option(ESTIS_WC_PREFIX . '_plug_checkout_err');

function estis_wc_admin_notice_checkout_err()
{
    $plug = get_plugin_data(ESTIS_WC_ABS_PATH);
    $mes = 'subscribe to unexistance list';
    ?>

    <style>
        #estimail_wc_checkout_notice {
            display: block;
            border-left: 4px solid #e35950;
        }
    </style>
    <div class="update-nag is-dismissible" id="estimail_wc_checkout_notice">
        <form action="admin-post.php" method="POST">
            <input type="hidden" name="action" value="est_wc_notice_delete"/>
            <b class="">
                <?php echo($plug['Name']); ?>:
            </b>
            <?php _e('checkout Err:', 'estismail-wc-translate'); ?>
            <?php _e($mes, 'estismail-wc-translate'); ?>.
            <input type="hidden" name="estismail">
            <a href="<?php echo (admin_url()) . "/admin.php?page=wc-settings&tab=estismail"; ?>"><?php _e('Edit woocomerse settings', 'estismail-wc-translate'); ?></a>
            <p>
                <button class="button"
                ">
                <?php _e('Ok', 'estismail-wp-translate') ?>
                </button>
            </p>

        </form>
    </div>
    <?php
}

if ($list_err && $display) {
    add_action('admin_notices', 'estis_wc_admin_notice_checkout_err');
}

$login_err = get_option(ESTIS_WC_PREFIX . '_login_err');
function estis_wc_login_err()
{
    $plug = get_plugin_data(ESTIS_WC_ABS_PATH);
    $mes = "Cannot connect with current api-key";
    ?>
    <style>
        #estimail_wc_checkout_notice {
            display: block;
            border-left: 4px solid #e35950;
        }
    </style>
    <div class="update-nag is-dismissible" id="estimail_wc_checkout_notice">
        <form action="admin-post.php" method="POST">
            <input type="hidden" name="action" value="est_wc_notice_delete"/>
            <b class="">
                <?php echo($plug['Name']); ?>:
            </b>
            <?php _e('checkout Err:', 'estismail-wc-translate'); ?>
            <?php _e($mes, 'estismail-wc-translate'); ?>.
            <input type="hidden" name="estismail">
            <a href="<?php echo (admin_url()) . "/admin.php?page=wc-settings&tab=estismail"; ?>"><?php _e('Edit woocomerse settings', 'estismail-wc-translate'); ?></a>
            <p>
                <button class="button"
                ">
                <?php _e('Ok', 'estismail-wc-translate') ?>
                </button>
            </p>

        </form>
    </div>
    <?php
}

if ($login_err && $display) {
    add_action('admin_notices', ESTIS_WC_PREFIX . '_login_err');
}