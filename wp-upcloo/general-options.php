<div class="wrap">
<h2><?php _e("UpCloo General Options", "wp_upcloo");?></h2>
    <p>
<?php _e("UpCloo is a new service created for web site with a lot of contents (from 10.000 to milions).", "wp_upcloo");?>
    </p>
    <p>
<?php _e("If you manage contents on your web site (news, pages, reviews, products, comments...) then you're likely to spend a lot of time (and money!) to create correlations between different contents.", "wp_upcloo");?>
    </p>
    <p>
<?php _e("UpCloo can index your pages and send, whenever a visitor goes on you web site, the best correlations at the moment through a simple xml feed, so you can show links and correlations inside or outside the text of your page.", "wp_upcloo");?>
    </p>
    <p>
        <strong>
<?php _e("Don't worry anymore about \"more like this\" and \"maybe you're interested at\": UpCloo manages all your correlations with a cloudy, smart and brilliant semantic engine.", "wp_upcloo");?>
        </strong>
    </p>
    <div>
    <h2><?php _e("UpCloo Security", "wp_upcloo");?></h2>
        <?php _e("All information that you send to UpCloo Cloud System are secured using RSA 1024 bit.", "wp_upcloo");?>
    </div>
    <h2><?php _e("UpCloo Application Configuration", "wp_upcloo");?></h2>
    <h3 id="upcloo-app-config"><?php _e("Login parmeters", "wp_upcloo");?></h3>
    <form method="post" action="options.php#upcloo-app-config">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th width="92" scope="row"><?php echo _e("Enter your User Key", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_USERKEY?>" type="text" value="<?php echo get_option(UPCLOO_USERKEY, "wp_upcloo"); ?>" />
                    <strong><?php echo __("(eg. your-business-name)")?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Enter your Site Key", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_SITEKEY?>" type="text" value="<?php echo get_option(UPCLOO_SITEKEY, "wp_upcloo"); ?>" />
                    <strong><?php echo __("(eg. your-site-name)")?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php echo _e("Enter your Password", "wp_upcloo");?></th>
                <td width="406">
                    <input name="<?php echo UPCLOO_PASSWORD?>" type="password" value="" />
                    <strong>
                        <?php _e("(eg. You account password [blank for security reasons])", "wp_upcloo");?>
                    </strong>
                </td>
            </tr>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_USERKEY, UPCLOO_SITEKEY, UPCLOO_PASSWORD))?>" />
            </tbody>
        </table>
        <p class="submit">
            <script type="text/javascript">
                ;var confirmThat = function() {
                    if (!confirm("Do you want to set this password?")) {
                        return false;
                    }
                };
            </script>
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" onclick="javascript:confirmThat()" />
        </p>
    </form>
    
    <h3 if="upcloo-enable-vsitekey"><?php _e("Use virtual sitekey as main", "wp_upcloo"); ?></h3>
    <form method="post" action="options.php#upcloo-enable-vsitekey">
    	<?php wp_nonce_field('update-options'); ?>
    	<table class="form-table" >
        	 <tr valign="top">
                <th width="92" scope="row"><?php _e("Switch keys", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option("upcloo_enable_vsitekey_as_primary");?>
                    <input type="checkbox" name="upcloo_enable_vsitekey_as_primary" value="1" <?php checked("1" == $index_post); ?> />
                    <strong><?php _e("Enable virtual sitekey as primary sitekey", "wp_upcloo");?></strong>
                </td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Virtual Sitekey", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_post = get_option("upcloo_vsitekey_as_primary");?>
                    <input type="text" name="upcloo_vsitekey_as_primary" value="<?php echo $index_post ?>" />
                    <strong><?php _e("Virtual sitekey", "wp_upcloo");?></strong>
                </td>
            </tr>
        </table>
        
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="upcloo_vsitekey_as_primary,upcloo_enable_vsitekey_as_primary" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>

    <h3 id="upcloo-other-features"><?php _e("Other features", "wp_upcloo");?></h3>
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
                <th width="92" scope="row"><?php _e("Use Categories during Indexing", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_category = get_option(UPCLOO_INDEX_CATEGORY);?>
                    <input type="checkbox" name="<?php echo UPCLOO_INDEX_CATEGORY?>" value="1" <?php checked("1" == $index_category); ?> />
                    <strong><?php _e("Use categories during index creation", "wp_upcloo");?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Use Tags during Indexing", "wp_upcloo");?></th>
                <td width="406">
                    <?php $index_tag = get_option(UPCLOO_INDEX_TAG);?>
                    <input type="checkbox" name="<?php echo UPCLOO_INDEX_TAG?>" value="1" <?php checked("1" == $index_tag); ?> />
                    <strong><?php _e("Use tags during index creation", "wp_upcloo");?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Max Number of Links", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_MAX_SHOW_LINKS);?>
                    <input name="<?php echo UPCLOO_MAX_SHOW_LINKS?>" type="text" value="<?php echo get_option(UPCLOO_MAX_SHOW_LINKS, ""); ?>" />
                    <strong><?php _e("Let blank for all", "wp_uplcoo");?></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Default Language", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_DEFAULT_LANG);?>
                    <input name="<?php echo UPCLOO_DEFAULT_LANG?>" type="text" value="<?php echo get_option(UPCLOO_DEFAULT_LANG, ""); ?>" />
                    <strong><?php _e("it (italian), en (english), etc...", "wp_uplcoo");?></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Rewrite public UpCloo label", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_REWRITE_PUBLIC_LABEL);?>
                    <input name="<?php echo UPCLOO_REWRITE_PUBLIC_LABEL?>" type="text" value="<?php echo get_option(UPCLOO_REWRITE_PUBLIC_LABEL, ""); ?>" />
                    <strong><?php _e("Let blank for use default label (May be you are interested at)", "wp_uplcoo");?></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Image missing path", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_MISSING_IMAGE_PLACEHOLDER);?>
                    <input name="<?php echo UPCLOO_MISSING_IMAGE_PLACEHOLDER?>" type="text" value="<?php echo get_option(UPCLOO_MISSING_IMAGE_PLACEHOLDER, ""); ?>" />
                    <strong><a href="#upcloo-templating"><?php _e("Public path of no image [eg. /images/no-image.png] - used only for advanced templating method", "wp_uplcoo");?></a></strong></td>
			</tr>
			<tr valign="top">
                <th width="92" scope="row"><?php _e("Summary Length", "wp_upcloo");?></th>
                <td width="406">
                    <?php $show_on_page = get_option(UPCLOO_SUMMARY_LEN);?>
                    <input name="<?php echo UPCLOO_SUMMARY_LEN?>" type="text" value="<?php echo get_option(UPCLOO_SUMMARY_LEN, "120"); ?>" />
                    <strong><?php _e("Minimum length for summary. If you set blank this field UpCloo use 120 characters by default.", "wp_uplcoo");?></strong></td>
			</tr>
        </table>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_SUMMARY_LEN, UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY, UPCLOO_ENABLE_MAIN_CORRELATION, UPCLOO_MISSING_IMAGE_PLACEHOLDER, UPCLOO_INDEX_TAG, UPCLOO_INDEX_CATEGORY, UPCLOO_MAX_SHOW_LINKS, UPCLOO_DEFAULT_LANGUAGE, UPCLOO_REWRITE_PUBLIC_LABEL))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
    
    <h3 id="upcloo-posts-types"><?php _e("Handle posts type", "wp_upcloo");?></h3>
    <p class="warning">
    	<?php _e("Select what kind of post you want to send to UpCloo", "wp_upcloo"); ?>
    </p>
    <form method="post" action="options.php#upcloo-post-types">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            	<tr valign="top">
                    <th width="92" scope="row"><?php echo _e("Select Posts Type", "wp_upcloo");?></th>
                    <td width="406">
                    	<?php 
                    	    $postsType = get_post_types();
                    	    $selected = get_option(UPCLOO_POSTS_TYPE);
                    	    
                    	    if (!is_array($selected)) {
                    	        $selected = array();
                    	    }
                    	?>
                    	<select name="<?php echo UPCLOO_POSTS_TYPE?>[]" multiple="multiple" size="10" style="width:380px; height: 200px;">
                    		<?php
                    		    foreach ($postsType as $key => $type):
                    		?>
                    		<option <?php echo ((in_array($key, $selected)) ? 'selected="selected"' : '')?> value="<?php echo $key?>"><?php echo $type?></option>
                    		<?php 
                    		    endforeach;
                    		?>
                    	</select>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_POSTS_TYPE))?>" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
    
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
                        <input name="upcloo_template_base" type="radio" value="0" <?php echo ((get_option("upcloo_template_base", "wp_upcloo") == 0) ? 'checked="checked"' : '') ?>/>
                        <strong><?php echo _e("(Default)");?></strong><br />
                        <input name="upcloo_template_base" type="radio" value="1" <?php echo ((get_option("upcloo_template_base", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                        <strong><?php echo _e("(Advanced)");?></strong>
                    </td>
                </tr>
                <tr><td><h3><?php _e("Only if advanced is selected", "wp_upcloo");?></h3></td><td></td></tr>
                <tr valign="top" style="border-top: 1px solid #f1f1f1;">
                    <td width="92" scope="row"><?php echo _e("Show post title", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="upcloo_template_show_title" type="hidden" value="0" />
                    	<input name="upcloo_template_show_title" type="checkbox" value="1" <?php echo ((get_option("upcloo_template_show_title", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post featured image", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="upcloo_template_show_featured_image" type="hidden" value="0" />
                    	<input name="upcloo_template_show_featured_image" type="checkbox" value="1" <?php echo ((get_option("upcloo_template_show_featured_image", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post summary", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="upcloo_template_show_summary" type="hidden" value="0" />
                    	<input name="upcloo_template_show_summary" type="checkbox" value="1" <?php echo ((get_option("upcloo_template_show_summary", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post tags", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="upcloo_template_show_tags" type="hidden" value="0" />
                    	<input name="upcloo_template_show_tags" type="checkbox" value="1" <?php echo ((get_option("upcloo_template_show_tags", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="92" scope="row"><?php echo _e("Show post categories", "wp_upcloo");?></td>
                    <td width="406">
                    	<input name="upcloo_template_show_categories" type="hidden" value="0" />
                    	<input name="upcloo_template_show_categories" type="checkbox" value="1" <?php echo ((get_option("upcloo_template_show_categories", "wp_upcloo") == 1) ? 'checked="checked"' : '') ?>/>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="upcloo_template_base, upcloo_template_show_title, upcloo_template_show_featured_image, upcloo_template_show_summary, upcloo_template_show_tags, upcloo_template_show_categories" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
    <h3><?php _e("Massive Sender", "wp_upcloo");?></h3>
    <p class="warning">
    	<?php _e("The massive sender function send all your contents to the UpCloo cloud for initiate your index.", "wp_upcloo"); ?>
    </p>
    <p class="warning">
    	<?php _e('Consider that a massive send is expensive. Use this feature only if you know exactly what that means.', 'wp_upcloo') ?>
    	<?php _e('If your confirm this operation you accept all UpCloo rules and UpCloo T.O.S..', 'wp_upcloo') ?>
    </p>
	<table class="form-table">
        <tbody>
        	<tr>
        		<td>
        			<input style="cursor: pointer;" type="checkbox" checked="checked" name="upcloo_send_only_misses" id="upcloo_send_only_misses" />
        			<label for="upcloo_send_only_misses"><?php _e('Send only missing contents', 'wp_upcloo') ?></label>
    			</td>
        	</tr>
        	<tr valign="top">
        		<td><input style="cursor: pointer;" type="button" name="upcloo_sender_enable_button" value="<?php _e('Send now all my contents', 'wp_upcloo') ?>" /></td>
        	</tr>
        	<tr>
        		<td><?php _e("This operation takes a while depending on your posts count...", "wp_upcloo")?></td>
        	</tr>
    	</tbody> 
	</table>   
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('input[name=upcloo_sender_enable_button]').bind('click', function(event){
		var elem = $(this);
		elem.unbind("click");

		var placeholder = elem.parent().parent().parent();

		var tr = $('<tr/>').append('<td/>');
		tr.find('td').append('<input style="cursor: pointer;" type="button"/>');
		var input = tr.find('input');

		input.attr('value', '<?php _e('Confirm', 'wp_upcloo')?>');

		input.bind('click', function(){

			var onlyMissing = (jQuery('#upcloo_send_only_misses').prop("checked")) ? "1" : "0";

			//Remove the placeholder
			placeholder.remove();

			var data = {
	    		"action": 'upcloo_ajax_importer',
	    		"onlyMissing": onlyMissing
	    	};
	    
	    	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	    	jQuery.get(ajaxurl, data, function(response) {
	    		if (response && response.completed) {
		    		alert("OK");
	    		}
	    	}, 'json');
		});
		
		placeholder.append(tr);

		var infoBlock = $('<p/>');
		infoBlock.append("<?php echo _e("Status of checkbox (only-missing) is read on confirm button click.", "wp_upcloo")?>");
		placeholder.append(infoBlock);
	});
});
</script>