<?php

function estis_wc_add_checkbox()
{

    $check_box_text = get_option(ESTIS_WC_PREFIX . '_checkout_checkbox_text') ? get_option(ESTIS_WC_PREFIX . '_checkout_checkbox_text') : 'Subscribe me';

    ?>
    <input type="checkbox" name="checkbox_input[]" checked id="checkbox_input"/>
    <label for="checkbox_input"><?php echo($check_box_text); ?></label>
    <?php

}

?>