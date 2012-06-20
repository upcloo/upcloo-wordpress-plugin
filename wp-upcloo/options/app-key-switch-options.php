<div class="wrap">
    <h3 if="upcloo-enable-vsitekey"><?php _e("Use virtual sitekey as main", "wp_upcloo"); ?></h3>
    <form method="post" action="options.php#upcloo-enable-vsitekey">
    	<?php wp_nonce_field('update-options'); ?>
    	<table class="form-table" >
        	 <tr valign="top">
                <th width="92" scope="row"><?php _e("Switch keys", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option(UPCLOO_ENABLE_VSITEKEY_AS_PRIMARY);?>
                    <input type="checkbox" name="<?php echo UPCLOO_ENABLE_VSITEKEY_AS_PRIMARY?>" value="1" <?php checked("1" == $index_post); ?> />
                    <strong><?php _e("Enable virtual sitekey as primary sitekey", "wp_upcloo");?></strong>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Virtual Sitekey", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option(UPCLOO_VSITEKEY_AS_PRIMARY);?>
                    <input type="text" name="<?php echo UPCLOO_VSITEKEY_AS_PRIMARY?>" value="<?php echo $index_post ?>" />
                    <strong><?php _e("Virtual sitekey", "wp_upcloo");?></strong>
                </td>
            </tr>
        </table>
        
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ENABLE_VSITEKEY_AS_PRIMARY,UPCLOO_VSITEKEY_AS_PRIMARY))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>