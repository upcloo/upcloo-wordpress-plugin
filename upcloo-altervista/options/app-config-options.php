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
                <tr>
                <td colspan="2" class="upcloo_title"><?php _e("Select your best related post widget", "wp_upcloo")?>:</td>
                </tr>
                <?php if (get_option(UPCLOO_ALTERVISTA_USE_IMAGE, 0)) : ?>
                <tr valign="top">
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example1.png" alt="upcloo_2000" class="upcloo_image" />
                    </td>
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example2.png" alt="upcloo_2100" class="upcloo_image" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <label class="upcloo_sel"> <input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2000) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2000" />&nbsp;<?php _e("Popover view", "wp_upcloo")?></label>
                    </td>
                    <td align="center">
                        <label class="upcloo_sel"><input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2100) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2100" />&nbsp;<?php _E("Below your body", "wp_upcloo")?></label>
                    </td>
                </tr>
                <?php else: ?>
                <tr valign="top">
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example3.png" alt="upcloo_2200" class="upcloo_image" />
                    </td>
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example4.png" alt="upcloo_2300" class="upcloo_image" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <label class="upcloo_sel"> <input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2200) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2200" />&nbsp;<?php _e("Popover view", "wp_upcloo")?></label>
                    </td>
                    <td align="center">
                        <label class="upcloo_sel"><input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2300) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2300" />&nbsp;<?php _e("Below your body")?></label>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td align="center" class="upcloo_text"><?php _e("The box appears in box after the page scroll", "wp_upcloo")?></td>
                    <td align="center" class="upcloo_text"><?php _e("The box appears automatically below your post body", "wp_upcloo");?></td>
                </tr>
                <tr valign="top">
                    <td colspan="2" align='center'>
                       <input type="submit" class="button-primary"  value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                       <input type="hidden" name="action" value="update" />
                       <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ALTERVISTA_CONFIG_ID))?>"/>
                    </td>
                </tr>
          </tbody>
        </table>
    </form>
</div>

<style type='text/css'>
    img.upcloo_image {
        padding:5px;
        border:1px solid #eaeaea;
        background:#fafafa;
        max-width:98%;
        box-shadow: 1px 1px 1px #f1f1f1;
    }
    label.upcloo_sel {
        padding:5px 10px;
        background:#f1f1f1;
        color:#000;
        box-shadow:1px 1px 1px #336699;
        -moz-box-shadow: 1px 1px 1px #336699;
        -webkit-box-shadow: 1px 1px 1px #336699;
        font-size:14px;
        font-weight:bold;
        letter-spacing:1px;
        width:180px;
        display:block;
        text-align:center;
        transition:0.2s linear all;
        -webkit-transition: 0.2s linear all;
        -moz-transition:0.2s linear all;

    }
    label.upcloo_sel:hover{
        background:#555;
        color:#fff;
    }
    td.upcloo_text {
        font-size:12px;
        color:#777;
    }
    td.upcloo_title {
        padding:5px 2%;
        width:96%;
        font-size:16px;
        font-weight:bold;
    }
</style>