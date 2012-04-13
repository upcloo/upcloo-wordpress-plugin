<?php get_header(); ?>
<?php $results = UpCloo_Registry::getInstance()->get("results"); ?>
    <div id="primary">
        <div id="content" role="main">
            <h1 class="page-title">Result for search: <strong><?php echo $_GET["s"]?></strong></h1>

            <!-- suggests -->
            <?php $suggested = upcloo_suggests($results, $_GET["s"]);?>
            <?php echo ((!empty($suggested)) ? __("Did you mean") . ": <strong><a title='".__("Search this occurrence", "wp_upcloo")."' href='/?s={$suggested}'>" . $suggested . "</a></strong>" : ""); ?>
            <!-- end suggests -->

            <?php if (count($results->getDocs()) <= 0) : ?>
                <h3><?php echo __("Your search did not match any entries.", "wp_upcloo") ?></h3>
            <?php else : ?>
                <div class="main">
                <hr />
                <?php foreach ($results->getDocs() as $doc) : ?>
                    <h3 class="entry-title"><a href="<?php echo $doc["url"];?>" title="<?php echo $doc["title"]?>"><?php echo $doc["title"]?></a></h3>
                    <span>Posted on: </span> <?php echo $doc["publish_date"] ?>
                    <hr />
                    <?php if (!empty($doc["author"])) : ?><p class="meta"><?php echo __("Written by")?> <?php $doc["author"] ?></p><?php endif; ?>
                    <?php if (!empty($doc["summary"])) : ?>
                    <p><?php echo $doc["summary"]?></p>
                    <p><a href="<?php echo $doc["url"]?>"><?php echo __("Read more", "wp_upcloo")?>...</a></p>
                    <?php endif ?> 
                <?php endforeach; ?>
                </div>
            <?php endif; ?>

                
            <?php $pages = upcloo_search_have_pages($results); if ($pages) : ?>
            <span><?php echo __("Pages", "wp_upcloo")?>: </span><span><?php echo upcloo_search_paginator($results) ?></span>
            <hr />
            <?php endif; ?>
        </div><!-- #content -->
    </div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>