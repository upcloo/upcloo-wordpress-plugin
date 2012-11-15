<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!", "wp_upcloo") . '</p></div>';
}

?>

<div class="wrap">
<?php screen_icon("options-general")?>
<h2><?php _e("UpCloo General Options", "wp_upcloo");?></h2>
    <h3 id="upcloo-app-config"><?php _e("Welcome To UpCloo", "wp_upcloo");?></h3>
    <h4><?php _e("UpCloo takes tipically 10 minutes to show first correlations. It improves results during next hours and continues to analyze and working for you in a completely automated way.", "wp_upcloo")?></h4>
    <form method="post" action="options.php#upcloo-app-config">
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
            <th width="92" scope="row"><?php _e("Your sitekey", "wp_upcloo");?> (<a href='http://www.upcloo.com/newsletter/iscrizione.html' target='_blank'><?php _e("signup for free", "wp_upcloo");?></a>)</th>
                <td width="406">
                    <input name="<?php echo UPCLOO_SITEKEY?>" type="text" value="<?php echo get_option(UPCLOO_SITEKEY, "wp_upcloo"); ?>" />
                </td>
            </tr>

            <tr valign="top">
                <th width="92" scope="row"><?php _e("Max Number of Links", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_MAX_SHOW_LINKS);?>
                    <select name="<?php echo UPCLOO_MAX_SHOW_LINKS?>">
                        <?php for ($i=1; $i<6; $i++) : ?>
                        <option <?php echo ((get_option(UPCLOO_MAX_SHOW_LINKS, "") == $i) ? "selected='selected'" : '')?> value="<?php echo $i?>"><?php echo $i?>&nbsp;</option>
                        <?php endfor; ?>
                    </select>
                    </td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Box title (let blank to hide title)", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_REWRITE_PUBLIC_LABEL);?>
                    <input name="<?php echo UPCLOO_REWRITE_PUBLIC_LABEL?>" type="text" value="<?php echo get_option(UPCLOO_REWRITE_PUBLIC_LABEL, ""); ?>" style='width:50%;'/>
			</tr>
			  <tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Do you want to show images?", "wp_upcloo");?></th>
                    <td width="406">
                    	 <select name="<?php echo UPCLOO_IMAGE?>">
                         <option <?php echo (!get_option(UPCLOO_IMAGE, "") ? "selected='selected'" : '')?> value="0"><?php _e("Show only links", "wp_upcloo");?>&nbsp;</option>
                         <option <?php echo (get_option(UPCLOO_IMAGE, "") ? "selected='selected'" : '')?> value="1"><?php _e("Show links + images", "wp_upcloo");?>&nbsp;</option>
                    </select>
                    </td>
                </tr>
			<tr valign="top">
                <th width="92" scope="row"><?php echo _e("Select your type", "wp_upcloo");?></th>
                <td width="406">
                        <select name="<?php echo UPCLOO_TYPE; ?>">
                    <option <?php echo ((get_option(UPCLOO_TYPE) == "popOver") ? "selected='selected'" : '')?> value="popOver">Popover</option>
                    <option <?php echo ((get_option(UPCLOO_TYPE) == "inline") ? "selected='selected'" : '')?> value="inline">Inline</option>
                </select><br /><span style="font-size:9px;"><?php _e("'Popover' is a box that appears in a corner of your website. 'Inline' is appended at the end of your content. ", "wp_upcloo");?></span>
                </td>
            </tr>

			<tr valign="top">
                <th width="92" scope="row"><?php _e("Choose the theme", "wp_upcloo");?></th>
                <td width="406">
                <?php
                    $themes = array(
                        "light" => __("Elegant floating box with tiny shadow", "wp_upcloo"),
                        "basic" => __("Simple and clear floating box", "wp_upcloo"),
                        "strip" => __("Horizontal and high impressive strip", "wp_upcloo")
                    );
                    foreach($themes AS $theme => $description) :?>
                        <input <?php echo (get_option(UPCLOO_THEME, "light") == $theme ? "checked='checked'" : '')?> type='radio' name='<?php echo UPCLOO_THEME?>' id='<?php echo UPCLOO_THEME?>-<?php echo $theme?>' value='<?php echo $theme?>' style='vertical-align:top;'/>
                        <label for='<?php echo UPCLOO_THEME?>-<?php echo $theme?>'><?php echo $description; ?></label><br/><br/>
                    <?php endforeach;?>
                </td>
			</tr>


			<tr valign="top">
                <th width="92" scope="row"></th>
                <td width="406" align='right'>
                	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />

                	<input type="hidden" name="action" value="update" />
            		<input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_SITEKEY, UPCLOO_MAX_SHOW_LINKS, UPCLOO_REWRITE_PUBLIC_LABEL, UPCLOO_THEME, UPCLOO_IMAGE, UPCLOO_TYPE))?>" />
                </td>
			</tr>


          </tbody>
        </table>
    </form>
</div>
