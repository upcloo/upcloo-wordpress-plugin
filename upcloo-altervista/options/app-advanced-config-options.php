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
                <th width="92" scope="row">
                    <?php echo __("UpCloo Widget Title", "wp_upcloo")?><br />
                    <span style="font-size: 10px"><?php _e("Override UpCloo default widget title", "wp_upcloo");?></span>
                </th>
                <td width="406">
                <input name="<?php echo UPCLOO_ALTERVISTA_BOX_TITLE; ?>" type="text" style="width: 250px" value="<?php echo get_option(UPCLOO_ALTERVISTA_BOX_TITLE, ""); ?>" />
                </td>
            </tr>

            <tr valign="top">
                <th width="92" scope="row"><?php echo __("Type of content where show related links", "wp_upcloo");?><br/><span style="font-size: 9px"><?php _e("Select type of content that UpCloo has to analyze (tipically just 'post' is a good choice).", "wp_upcloo");?></span></th>
                <td width="406">
                    <?php
                        $postsType = get_post_types();
                        $selected = get_option(UPCLOO_ALTERVISTA_POSTS_TYPE);

                        if (!is_array($selected)) {
                            $selected = array();
                        }
                        foreach ($postsType as $key => $type):
                    ?>
                    <input id="upcloo-checkbox-posttype-<?php echo $key;?>" <?php echo ((in_array($key, $selected)) ? 'checked="checked"' : '')?> type="checkbox" name="<?php echo UPCLOO_ALTERVISTA_POSTS_TYPE?>[]" value="<?php echo $key?>" /> <label for="upcloo-checkbox-posttype-<?php echo $key;?>"><?php echo $type;?></label><br />
                    <?php
                        endforeach;
                    ?>
                </td>

            </tr>

            <tr valign="top">
                <th width="92" scope="row">
                    <?php echo __("UpCloo inline manual placeholder", "wp_upcloo")?><br />
                    <span style="font-size: 10px"><?php _e("Remember that you have to add by hand the UpCloo placeholder into your template", "wp_upcloo");?>:<br/> <?php echo htmlentities("<div class='upcloo-widget' id='{your-option-id}'></div>");?></span>
                </th>
                <td width="406">
                <input name="<?php echo UPCLOO_ALTERVISTA_MANUAL_PLACEHOLDER; ?>" type="checkbox" <?php echo ((get_option(UPCLOO_ALTERVISTA_MANUAL_PLACEHOLDER) ? "checked='checked'" : '')); ?> />
                </td>
            </tr>

			<tr valign="top">
                <th width="92" scope="row"></th>
                <td width="406" align='right'>
                	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                	<input type="hidden" name="action" value="update" />
            		<input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ALTERVISTA_POSTS_TYPE, UPCLOO_ALTERVISTA_MANUAL_PLACEHOLDER, UPCLOO_ALTERVISTA_BOX_TITLE))?>" />
                </td>
			</tr>
          </tbody>
        </table>
    </form>
</div>
