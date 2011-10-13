<div class="wrap">
<h2><?php _e("UpCloo General Options");?></h2>
    <p>
        UpCloo is a new service created for web site with a lot of contents (from 10.000 to milions).
    </p>
    <p>
        If you manage contents on your web site (news, pages, reviews, products, comments...) then you're likely to spend a lot of time (and money!) to create correlations between different contents.
    </p>
    <p>
        UpCloo can index your pages and send, whenever a visitor goes on you web site, the best correlations at the moment through a simple xml feed, so you can show links and correlations inside or outside the text of your page.
    </p>
    <p>
        <strong>
            Don't worry anymore about "more like this" and "maybe you're interested at": UpCloo manages all your correlations with a cloudy, smart and brilliant semantic engine.
        </strong>
    </p>

    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>

        <table class="form-table" >
            <tr valign="top">
                <th width="92" scope="row"><?php echo _e("Enter your User Key");?></th>
                <td width="406">
                    <input name="upcloo_userkey" type="text" value="<?php echo get_option('upcloo_userkey'); ?>" />
                    <strong>(eg. your-business-name)</strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Enter your Site Key");?></th>
                <td width="406">
                    <input name="upcloo_sitekey" type="text" value="<?php echo get_option('upcloo_sitekey'); ?>" />
                    <strong>(eg. your-site-name)</strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Use Categories during Indexing");?></th>
                <td width="406">
                    <?php $index_category = get_option("upcloo_index_category");?>
                    <input type="checkbox" name="upcloo_index_category" value="1" <?php checked("1" == $index_category); ?> />
                    <strong><?php _e("Use categories during index creation");?></strong></td>
            </tr>
            <tr valign="top">
                <th width="92" scope="row"><?php _e("Use Tags during Indexing");?></th>
                <td width="406">
                    <?php $index_tag = get_option("upcloo_index_tag");?>
                    <input type="checkbox" name="upcloo_index_tag" value="1" <?php checked("1" == $index_tag); ?> />
                    <strong><?php _e("Use tags during index creation");?></strong></td>
            </tr>
        </table>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="upcloo_userkey,upcloo_sitekey,upcloo_index_category,upcloo_index_tag" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>

    </form>
</div>
