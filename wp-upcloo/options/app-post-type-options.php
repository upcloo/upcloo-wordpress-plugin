<div class="wrap">
    <?php screen_icon("options-general")?>
    <h2 id="upcloo-posts-types"><?php _e("Handle posts type", "wp_upcloo");?></h2>
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
</div>