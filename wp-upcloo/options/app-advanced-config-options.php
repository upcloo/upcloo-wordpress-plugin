<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!", "wp_upcloo") . '</p></div>';
}

?>

<div class="wrap">
<?php screen_icon("options-general")?>
<h2><?php _e("UpCloo Advanced Options", "wp_upcloo");?></h2>
    <form method="post" action="options.php#upcloo-app-advanced-config">
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
                <th width="92" scope="row"><?php echo __("Type of content where show related links", "wp_upcloo");?><br/><span style="font-size: 9px"><?php _e("Select type of content that UpCloo has to analyze (tipically just 'post' is a good choice).", "wp_upcloo");?></span>
</th>
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
                <th width="92" scope="row"><?php echo __("Position of the PopOver", "wp_upcloo");?></th>
                <td width="406">
                    <select name="<?php echo UPCLOO_POPOVER_POSITION;?>">
                        <option <?php echo ((get_option(UPCLOO_POPOVER_POSITION) == 'br') ? "selected='selected'" : "")?> value="br"><?php _e("Bottom Right", "wp_upcloo");?></option>
                        <option <?php echo ((get_option(UPCLOO_POPOVER_POSITION) == 'bl') ? "selected='selected'" : "")?> value="bl"><?php _e("Bottom Left", "wp_upcloo");?></option>
                        <option <?php echo ((get_option(UPCLOO_POPOVER_POSITION) == 'tr') ? "selected='selected'" : "")?> value="tr"><?php _e("Top Right", "wp_upcloo");?></option>
                        <option <?php echo ((get_option(UPCLOO_POPOVER_POSITION) == 'tl') ? "selected='selected'" : "")?> value="tl"><?php _e("Top Left", "wp_upcloo");?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php echo __("Fade in (pixel from border)", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_POPOUT?>" type="text" value="<?php echo get_option(UPCLOO_POPOUT, "500"); ?>" style='width:50%;'/>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php echo __("Fade out (pixel from border)", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_POPIN;?>" type="text" value="<?php echo get_option(UPCLOO_POPIN, "100"); ?>" style='width:50%;'/>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php echo __("Missing image URL (eg. http://www.yourdomain.tld/path-to.img.png)", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_DEFAULT_IMAGE;?>" type="text" value="<?php echo get_option(UPCLOO_DEFAULT_IMAGE); ?>" style='width:90%' />
                </td>
            </tr>

            <tr valign="top">
                <th width="92" scope="row">
                    <?php echo __("Personal CSS", "wp_upcloo")?>
                </th>
                <td width="406">
                    &lt;style&gt;<br />
                    <textarea style="font-family: courier, arial, verdana; width: 95%; height: 150px;" name="<?php echo UPCLOO_CSS_INLINE;?>"><?php echo get_option(UPCLOO_CSS_INLINE); ?></textarea><br />
                    &lt;/style&gt;<br/>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row">
                    <?php echo __("Track UpCloo using Google Analytics", "wp_upcloo")?>
                </th>
                <td width="406">
                <input name="<?php echo UPCLOO_GAN_TRACKER; ?>" type="checkbox" <?php echo ((get_option(UPCLOO_GAN_TRACKER) ? "checked='checked'" : '')); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row">
                    <?php echo __("UpCloo inline manual placeholder", "wp_upcloo")?>
                </th>
                <td width="406">
                <input name="<?php echo UPCLOO_MANUAL_PLACEHOLDER; ?>" type="checkbox" <?php echo ((get_option(UPCLOO_MANUAL_PLACEHOLDER) ? "checked='checked'" : '')); ?> />
                </td>
            </tr>


			<tr valign="top">
                <th width="92" scope="row"></th>
                <td width="406" align='right'>
                	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                	<input type="hidden" name="action" value="update" />
            		<input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_POSTS_TYPE, UPCLOO_POPOVER_POSITION, UPCLOO_CSS_INLINE, UPCLOO_POPIN, UPCLOO_POPOUT, UPCLOO_DEFAULT_IMAGE, UPCLOO_GAN_TRACKER, UPCLOO_MANUAL_PLACEHOLDER))?>" />
                </td>
			</tr>
          </tbody>
        </table>
    </form>
</div>
