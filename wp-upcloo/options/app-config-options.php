<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!", "wp_upcloo") . '</p></div>';
}

?>

<div class="wrap">
<?php screen_icon("options-general")?>
<h2><?php _e("UpCloo General Options", "wp_upcloo");?></h2>
    <h3 id="upcloo-app-config"><?php _e("Welcome To UpCloo", "wp_upcloo");?></h3>
    <form method="post" action="options.php#upcloo-app-config">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Enter your Site Key", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_SITEKEY?>" type="text" value="<?php echo get_option(UPCLOO_SITEKEY, "wp_upcloo"); ?>" />
                    <strong><?php echo __("(Your signup info)")?></strong></td>
            </tr>
            <tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Select Posts Type", "wp_upcloo");?></th>
                    <td width="406">
                    	<?php
                    	    $postsType = get_post_types();
                    	    $selected = get_option(UPCLOO_POSTS_TYPE);

                    	    if (!is_array($selected)) {
                    	        $selected = array();
                    	    }
                            foreach ($postsType as $key => $type):
                        ?>
                        <input id="upcloo-checkbox-posttype-<?php echo $key;?>" <?php echo ((in_array($key, $selected)) ? 'checked="checked"' : '')?> type="checkbox" name="<?php echo UPCLOO_POSTS_TYPE?>[]" value="<?php echo $key?>" /> <label for="upcloo-checkbox-posttype-<?php echo $key;?>"><?php echo $type;?></label><br />
                        <?php
                            endforeach;
                        ?>
                    </td>
                </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Max Number of Links", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_MAX_SHOW_LINKS);?>
                    <select name="<?php echo UPCLOO_MAX_SHOW_LINKS?>">
                        <?php for ($i=1; $i<6; $i++) : ?>
                        <option <?php echo ((get_option(UPCLOO_MAX_SHOW_LINKS, "") == $i) ? "selected='selected'" : '')?> value="<?php echo $i?>"><?php echo $i?></option>
                        <?php endfor; ?>
                    </select>
                    <strong><?php _e("Let blank for all", "wp_uplcoo");?></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Rewrite public UpCloo label", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_REWRITE_PUBLIC_LABEL);?>
                    <input name="<?php echo UPCLOO_REWRITE_PUBLIC_LABEL?>" type="text" value="<?php echo get_option(UPCLOO_REWRITE_PUBLIC_LABEL, ""); ?>" />
                    <strong><?php _e("Let blank for use default label (May be you are also interested in)", "wp_uplcoo");?></strong></td>
			</tr>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_SITEKEY, UPCLOO_POSTS_TYPE, UPCLOO_MAX_SHOW_LINKS, UPCLOO_REWRITE_PUBLIC_LABEL))?>" />
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />
        </p>
    </form>
</div>
