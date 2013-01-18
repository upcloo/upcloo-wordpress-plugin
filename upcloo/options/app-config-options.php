<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!", "wp_upcloo") . '</p></div>';
}

?>

<div class="wrap">
<?php screen_icon("options-general")?>
<h2><?php _e("UpCloo General Options", "wp_upcloo");?></h2>
    <h3 id="upcloo-app-config"><?php _e("Welcome To UpCloo", "wp_upcloo");?></h3>
    <h4><?php _e("UpCloo takes tipically 10 minutes to show first correlations. It improves results during next hours and continues to analyze and working for you in a completely automated way.", "wp_upcloo")?></h4>
    <form method="post" action="options.php#upcloo-app-config">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th width="92" scope="row"></th>
                    <td width="406" align='right'>
                        <a class="button-secondary" href='http://www.upcloo.com/index/integration/wordpress.html' target='_blank' ><?php _e("Plugin Doc", 'wp_upcloo') ?></a>

                        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />
                    </td>
                </tr>

                <tr valign="top">
                <th width="92" scope="row"><?php _e("Your sitekey", "wp_upcloo");?> (<a href='http://www.upcloo.com/newsletter/iscrizione.html' target='_blank'><?php _e("signup for free", "wp_upcloo");?></a>)</th>
                    <td width="406">
                        <input name="<?php echo UPCLOO_SITEKEY?>" type="text" value="<?php echo get_option(UPCLOO_SITEKEY, ""); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                <th width="92" scope="row"><?php _e("Your option ID", "wp_upcloo");?></th>
                    <td width="406">
                        <input name="<?php echo UPCLOO_CONFIG_ID?>" type="text" value="<?php echo get_option(UPCLOO_CONFIG_ID, "upcloo_1000"); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th width="92" scope="row"></th>
                    <td width="406" align='right'>
                       <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                       <input type="hidden" name="action" value="update" />
                       <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_SITEKEY, UPCLOO_CONFIG_ID))?>"/>
                    </td>
                </tr>
          </tbody>
        </table>
    </form>
</div>
