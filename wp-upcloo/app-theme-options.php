<div class="wrap">
    <h3 id="upcloo-templating"><?php _e("Template selector", "wp_upcloo");?></h3>
    <p class="warning">
    	<?php _e("Use the advanced method only if you know or have someone that know CSS (Cascading StyleSheet)", "wp_upcloo"); ?>
    </p>
    <form method="post" action="options.php#upcloo-templating">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            	<tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Select you preferrered method", "wp_upcloo");?></td>
                    <td width="406">
                        <input name="<?php echo UPCLOO_TEMPLATE_BASE?>" type="radio" value="0" <?php echo ((get_option(UPCLOO_TEMPLATE_BASE, "wp_upcloo") == 0) ? 'checked="checked"' : '') ?>/>
                        <strong><?php echo _e("(Default)");?></strong><br />
                        <input name="<?php echo UPCLOO_TEMPLATE_BASE?>" type="radio" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_BASE, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                        <strong><?php echo _e("(Advanced)");?></strong>
                    </td>
                </tr>
                <tr><td><h3><?php _e("Only if advanced is selected", "wp_upcloo");?></h3></td><td></td></tr>
                <tr valign="top" style="border-top: 1px solid #f1f1f1;">
                    <td width="92" scope="row"><?php echo _e("Show post title", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_TITLE?>" type="hidden" value="0" />
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_TITLE?>" type="checkbox" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_SHOW_TITLE, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post featured image", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_FEATURED_IMAGE?>" type="hidden" value="0" />
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_FEATURED_IMAGE?>" type="checkbox" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_SHOW_FEATURED_IMAGE, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post summary", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_SUMMARY?>" type="hidden" value="0" />
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_SUMMARY?>" type="checkbox" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_SHOW_SUMMARY, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post tags", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_TAGS?>" type="hidden" value="0" />
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_TAGS?>" type="checkbox" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_SHOW_TAGS, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post categories", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_CATEGORIES?>" type="hidden" value="0" />
                    	<input name="<?php echo UPCLOO_TEMPLATE_SHOW_CATEGORIES?>" type="checkbox" value="1" <?php echo ((get_option(UPCLOO_TEMPLATE_SHOW_CATEGORIES, "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_TEMPLATE_BASE, UPCLOO_TEMPLATE_SHOW_TITLE, UPCLOO_TEMPLATE_SHOW_FEATURED_IMAGE, UPCLOO_TEMPLATE_SHOW_SUMMARY, UPCLOO_TEMPLATE_SHOW_TAGS, UPCLOO_TEMPLATE_SHOW_CATEGORIES))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>