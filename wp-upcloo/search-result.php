<?php get_header(); ?>
<?php $results = UpCloo_Registry::getInstance()->get("results"); ?>
    <div id="primary">
        <div id="content" role="main">
            <h1 class="entry-title"><?php echo __("Search results", "wp_upcloo"); ?></h1>
            
            <?php 
                if (count($results->getSuggestions()) > 0) :
                    $s = $results->getSuggestions();
                    $q = explode(" ", $_GET["s"]);
                    
                    foreach ($q as $i => $t) {
                        if (array_key_exists($t, $s)) {
                            $q[$i] = $s[$t][0];
                        }
                    }
            ?>
            <?php echo __("Did you mean") . ": <strong>" . implode(" ", $q) . "</strong>"?>
            <?php endif; ?>

            <?php if (count($results->getDocs()) <= 0) : ?>
                <h3><?php echo __("Your search did not match any entries.", "wp_upcloo") ?></h3>
            <?php else : ?>
                <div class="main">
                <?php foreach ($results->getDocs() as $doc) : ?>
                    <h2><a href="<?php echo $doc["url"];?>" title="<?php echo $doc["title"]?>"><?php echo $doc["title"]?></a></h2>
                    <p class="meta"><?php echo __("Written by")?> <?php $doc["author"] ?></p>
                    <p><?php echo $doc["summary"]?></p>
                    <p><a href="<?php echo $doc["url"]?>"><?php echo __("Read more", "wp_upcloo")?>...</a></p> 
                <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div><!-- #content -->
    </div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>