<div class="wrap">
    <h3 id="upcloo-roi-monitor"><?php _e("ROI Monitor Parameters", "wp_upcloo");?></h3>
    <p class="warning">
    	<?php _e("Consider that you have Google Analytics Tracker script activated and visibile on your pages or almost where UpCloo is engaged.", "wp_upcloo"); ?>
    </p>
    <form method="post" action="options.php#upcloo-roi-monitor">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            	<tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Enable UTM Tagging", "wp_upcloo");?></th>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_UTM_TAG?>" type="hidden" value="0" />
                        <input name="<?php echo UPCLOO_UTM_TAG?>" type="checkbox" <?php echo ((get_option(UPCLOO_UTM_TAG, "wp_upcloo")) ? 'checked' : ''); ?> />
                        <strong><?php _e("(Enable Google UTM Tag Feature)");?></strong>
                    </td>
                </tr>
                <tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Enter base UTM Campaign", "wp_upcloo");?></th>
                    <td width="406">
                        <input name="<?php echo UPCLOO_UTM_CAMPAIGN?>" type="text" value="<?php echo get_option(UPCLOO_UTM_CAMPAIGN, "wp_upcloo"); ?>" />
                        <strong><?php echo _e("(eg. upcloo-check)");?></strong>
                    </td>
                </tr>
                <tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Enter base UTM Medium", "wp_upcloo");?></th>
                    <td width="406">
                        <input name="<?php echo UPCLOO_UTM_MEDIUM?>" type="text" value="<?php echo get_option(UPCLOO_UTM_MEDIUM, "wp_upcloo"); ?>" />
                        <strong><?php echo _e("(eg. mywebsite)");?></strong>
                    </td>
                </tr>
                <tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Enter base UTM Source", "wp_upcloo");?></th>
                    <td width="406">
                        <input name="<?php echo UPCLOO_UTM_SOURCE?>" type="text" value="<?php echo get_option(UPCLOO_UTM_SOURCE, "wp_upcloo"); ?>" />
                        <strong><?php echo _e("(eg. upcloo-base-links)");?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_UTM_CAMPAIGN, UPCLOO_UTM_TAG, UPCLOO_UTM_MEDIUM, UPCLOO_UTM_SOURCE))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>