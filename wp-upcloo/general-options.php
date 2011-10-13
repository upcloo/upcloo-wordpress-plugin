<div class="wrap">
<h2><?php _e("UpCloo General Options");?></h2>

    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>

        <table class="form-table" >
            <tr valign="top">
            <th width="92" scope="row"><?php echo _e("Enter your User Key");?></th>
                <td width="406">
                    <input name="upcloo_userkey" type="text" value="<?php echo get_option('upcloo_userkey'); ?>" />
                    (eg. your-business-name)</td>
            </tr>
            <tr valign="top">
            <th width="92" scope="row"><?php _e("Enter your Site Key");?></th>
                <td width="406">
                    <input name="upcloo_sitekey" type="text" value="<?php echo get_option('upcloo_sitekey'); ?>" />
                    (eg. your-site-name)</td>
            </tr>
        </table>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="upcloo_userkey,upcloo_sitekey" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>
</div>
