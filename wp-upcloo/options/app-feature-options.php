<div class="wrap">
    <?php screen_icon("options-general")?>
    <h2 id="upcloo-other-features"><?php _e("Other features", "wp_upcloo");?></h2>
    <form method="post" action="options.php#upcloo-other-features">
        <?php wp_nonce_field('update-options'); ?>

        <table class="form-table" >
        	<tr valign="top">
                <th width="92" scope="row"><?php _e("Disable Main UpCloo Results", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY);?>
                    <input type="checkbox" name="<?php echo UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY?>" value="1" <?php checked("1" == $index_post); ?> />
                    <strong><?php _e("If enabled no one can see UpCloo main correlation (widgets still works)", "wp_upcloo");?></strong></td>
            </tr>
        	<tr valign="top">
                <th width="92" scope="row"><?php _e("Show UpCloo links", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option(UPCLOO_ENABLE_MAIN_CORRELATION);?>
                    <input type="checkbox" name="<?php echo UPCLOO_ENABLE_MAIN_CORRELATION?>" value="1" <?php checked("1" == $index_post); ?> />
                    <strong><?php _e("If disabled only admins can see UpCloo correlation", "wp_upcloo");?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Max Number of Links", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_MAX_SHOW_LINKS);?>
                    <input name="<?php echo UPCLOO_MAX_SHOW_LINKS?>" type="text" value="<?php echo get_option(UPCLOO_MAX_SHOW_LINKS, ""); ?>" />
                    <strong><?php _e("Let blank for all", "wp_uplcoo");?></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Rewrite public UpCloo label", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_REWRITE_PUBLIC_LABEL);?>
                    <input name="<?php echo UPCLOO_REWRITE_PUBLIC_LABEL?>" type="text" value="<?php echo get_option(UPCLOO_REWRITE_PUBLIC_LABEL, ""); ?>" />
                    <strong><?php _e("Let blank for use default label (May be you are interested at)", "wp_uplcoo");?></strong></td>
			</tr>
        </table>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY, UPCLOO_ENABLE_MAIN_CORRELATION, UPCLOO_MAX_SHOW_LINKS, UPCLOO_REWRITE_PUBLIC_LABEL))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>
