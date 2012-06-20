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
</div>