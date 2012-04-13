<?php get_header(); ?>
<?php $results = UpCloo_Registry::getInstance()->get("results"); ?>
    <div id="primary">
        <div id="content" role="main">
            <h1 class="page-title">Result for search: <strong><?php echo $_GET["s"]?></strong></h1>
            
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
                <hr />
                <?php foreach ($results->getDocs() as $doc) : ?>
                    <h3 class="entry-title"><a href="<?php echo $doc["url"];?>" title="<?php echo $doc["title"]?>"><?php echo $doc["title"]?></a></h3>
                    <?php if (!empty($doc["author"])) : ?><p class="meta"><?php echo __("Written by")?> <?php $doc["author"] ?></p><?php endif; ?>
                    <p><?php echo $doc["summary"]?></p>
                    <p><a href="<?php echo $doc["url"]?>"><?php echo __("Read more", "wp_upcloo")?>...</a></p> 
                <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php 
                $page = (array_key_exists("page", $_GET) ? $_GET["page"] : 1);
                $start = $results->getStart();
                $elements = $results->getCount();
                
                $pages = ceil($elements - UPCLOO_SEARCH_RESULTS);
                
                $p = array();
                for ($i=1; $i<=$pages; $i++) { $p[] = "<a href=\"?s={$_GET["s"]}&page={$i}\">{$i}</a>"; }
                $pages = implode(" ", $p);
            ?>
            <span><?php echo __("Pages", "wp_upcloo")?>: </span><span><?php echo $pages ?></span>
            <hr />
        </div><!-- #content -->
    </div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>