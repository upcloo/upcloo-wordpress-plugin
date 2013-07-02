<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!") . '</p></div>';
}
?>

<div class="wrap">
<?php screen_icon("options-general")?>
    <h2><?php _e("UpCloo General Options");?></h2>
    <form method="post" action="options.php#upcloo-app-config">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <td colspan="2" class="upcloo_title"><?php _e("Start now using UpCloo for free. Select the best layout for your widget:")?>:</td>
                </tr>

                <?php if (get_option(UPCLOO_ALTERVISTA_USE_IMAGE, 0)) : ?>
                <tr valign="top">
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example1.png" alt="upcloo_2000" class="upcloo_image" />
                    </td>
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example2.png" alt="upcloo_2001" class="upcloo_image" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <label class="upcloo_sel"> <input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2000) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2000" />&nbsp;<?php _e("Popover view")?></label>
                    </td>
                    <td align="center">
                        <label class="upcloo_sel"><input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2001) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2001" />&nbsp;<?php _E("Below your body")?></label>
                    </td>
                </tr>
                <?php else: ?>
                <tr valign="top">
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example3.png" alt="upcloo_2002" class="upcloo_image" />
                    </td>
                    <td width="406" align="center">
                        <img src="http://r.upcloo.com/a/example4.png" alt="upcloo_2003" class="upcloo_image" />
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <label class="upcloo_sel"> <input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2002) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2002" />&nbsp;<?php _e("Popover view")?></label>
                    </td>
                    <td align="center">
                        <label class="upcloo_sel"><input <?php echo ((get_option(UPCLOO_ALTERVISTA_CONFIG_ID) == upcloo_2003) ? "checked='checked'" : "")?> name="<?php echo UPCLOO_ALTERVISTA_CONFIG_ID?>" type="radio" value="upcloo_2003" />&nbsp;<?php _e("Below your body")?></label>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td align="center" class="upcloo_text"><?php _e("The box appears in box after the page scroll")?></td>
                    <td align="center" class="upcloo_text"><?php _e("The box appears automatically below your post body");?></td>
                </tr>
                <tr valign="top">
                    <td colspan="2" align='center'>
                       <input type="submit" class="button-primary"  value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                       <input type="hidden" name="action" value="update" />
                       <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ALTERVISTA_CONFIG_ID))?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="upcloo_title" style="font-size:14px;color:#555;font-weight:normal;">
                    	&nbsp;<br/><br/>
                    	<?php _e("UpCloo starts showing the correlations in your most recent posts. It could be required a while to show correlations in whole website.")?>
                    	<strong><?php _e("Now you can wait relax. UpCloo will provide the best correlations for you!")?></strong>
                    </td>
                </tr>
                <tr>
                <td colspan="2" class="upcloo_title" style="font-size:11px;color:#777;">
                    <?php _e("If you have any problem, ask to us!")?>
                    <a target="_blank" href="http://www.upcloo.com/form/quest/modulo/6.html"><?php _e("Click here")?></a>
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
