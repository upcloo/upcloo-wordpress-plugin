<?php
if (array_key_exists("settings-updated", $_GET)) {
    echo '<div class="updated"><p>' . __("Your configuration is saved correctly!") . '</p></div>';
}
?>
<div class="wrap">
<h2 class="upclooh2">UpCloo <strong>Related Post Plugin</strong> for Altervista</h2>
<h3 class="upclooh3"><?php _e("Thanks to this plugin you can easily show the best related posts on your contents,<br>choosing the best layout for your blog. It's fully automated and very easy to use.");?></h3>
<form action="options.php#upcloo-app-enable" method="post" class="upclooform">
    <?php wp_nonce_field('update-options'); ?>
    <input type="hidden" value="1" name="<?php echo UPCLOO_ALTERVISTA_ENABLED; ?>"/>
        <input type="submit" value="<?php _e("Click here to activate the UpCloo Plugin!");?>" name="activate" class="upclooinput">

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="<?php echo implode(",", array(UPCLOO_ALTERVISTA_ENABLED))?>"/>
</form>
<h3 class="upclooh3 upclooh3bis"><?php _e("It's free and you can edit and deactivate whenever you want.");?></h3>
<h3 class="upclooh3 upclooh3bis"><a target="_blank" href="http://www.upcloo.com/lista/nota/terms-of-service/15/1.html">Terms of Service</a> - <a target="_blank" href="http://www.upcloo.com/form/quest/modulo/6.html"><?php _e("Request Support");?></a></h3>
</div>

<style type="text/css">
h2.upclooh2 {
text-align:center;
margin-top:40px;
font-size:27px;
padding-bottom:15px;
border-bottom:1px solid #eaeaea;
}
h3.upclooh3 {
line-height:1.5;
font-weight:normal;
font-size:16px;
text-align:center;

}
h3.upclooh3bis {
color:#667;
font-size:15px;
}

h3.upclooh3bis a {
font-size:14px;
color:#3593AD;
}
form.upclooform {
width:100%;
padding:10px 0;
text-align:center;
display:block;
}
input.upclooinput {
padding:10px 20px;
background:#2b7b9f;
border:0;
color:#fff;
font-size:18px;
text-shadow:1px 1px 1px #222;
-webkit-text-shadow:1px 1px 1px #222;
-moz-text-shadow:1px 1px 1px #222;
text-shadow:1px 1px 1px #222;
-webkit-text-shadow:1px 1px 1px #222;
-moz-text-shadow:1px 1px 1px #222;
border-radius:5px;
cursor:pointer;
box-shadow:1px 1px 1px #ababab;
-webkit-box-shadow:1px 1px 1px #ababab;
-moz-box-shadow:1px 1px 1px #ababab;
letter-spacing:1px;
-webkit-transition: 0.2s linear all;
-moz-transition: 0.2s linear all;
transition: 0.2s linear all;
}

input.upclooinput:hover {
background:#0E7023;
}


</style>
