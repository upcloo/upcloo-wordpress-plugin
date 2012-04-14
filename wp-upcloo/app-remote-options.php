<div class="wrap">
    <h3 id="upcloo-remote-import"><?php _e("Remote Import System", "wp_upcloo");?></h3>
    <p class="warning">
    	<?php _e("Consider that you have to request remote indexing using UpCloo remote control panel.", "wp_upcloo"); ?>
    	<?php _e("See this link for more information about this procedure:") ?> 
    		<a href="https://github.com/corley/upcloo-wordpress-plugin/wiki/Enable-Template-MetaTags-for-Remote-Importer">UpCloo Remote Importer Wiki Page</a>
    </p>
    <form method="post" action="options.php#upcloo-remote-import">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            	<tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Enable MetaTags for Remote UpCloo Importer", "wp_upcloo");?></th>
                    <td width="406">
                    	<input name="<?php echo UPCLOO_ENABLE_TEMPLATE_REMOTE_META?>" type="hidden" value="0" />
                        <input name="<?php echo UPCLOO_ENABLE_TEMPLATE_REMOTE_META?>" type="checkbox" <?php echo ((get_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META, "wp_upcloo")) ? 'checked' : ''); ?> />
                        <strong><?php _e("(Enable only for one-time remote import after that turn if off.)");?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ENABLE_TEMPLATE_REMOTE_META))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>