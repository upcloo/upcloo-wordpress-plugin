<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkAwareInterface;
use Behat\Mink\Mink;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

use Corley\WordPressExtension\Context\WordPressContext;

/**
 * Features context.
 */
class FeatureContext extends BehatContext implements MinkAwareInterface
{
    private $mink;

    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('wordpress', new WordPressContext);
    }

    /**
     * @Given /^the upcloo plugin is correctly configured with sitekey "([^"]*)"$/
     */
    public function theUpclooPluginIsCorrectlyConfiguredWithSitekey($sitekey)
    {
        update_option(UPCLOO_SITEKEY, $sitekey);
        $this->sitekey = $sitekey;
    }

    /**
     * @Then /^I should see the UpCloo related posts box$/
     */
    public function iShouldSeeTheUpclooRelatedPostsBox()
    {
        $url = $this->mink->getSession()->getCurrentUrl();
        $page = $this->mink->getSession()->getPage()->getText();

        $url = str_replace("/", "\\/", $url);
        $url = str_replace("?", "\\?", $url);
        assertRegExp("/\"permalink\" : \"{$url}\"/", $page);
        assertRegExp("/\"siteKey\" : \"{$this->sitekey}\"/", $page);
    }

    /**
     * @Then /^I should not see the UpCloo related posts box$/
     */
    public function iShouldNotSeeTheUpclooRelatedPostsBox()
    {
        $page = $this->mink->getSession()->getPage()->getText();

        assertFalse(strpos($page, "sitekey"));
        assertFalse(strpos($page, "vsitekey"));
    }

    /**
     * @Then /Checkbox "page" is not checked, but it should be./
     */
    public function assertCheckboxChecked($checkbox)
    {
        $checked = $this->assertSession()->fieldExists($checkbox)->getAttribute('checked');
        if(!$checked) {
            throw new Exception('Checkbox should be checked');
        }
    }

    /**
     * @Given /^UpCloo is enabled on pages$/
     */
    public function upclooIsEnabledOnPages()
    {
        update_option(UPCLOO_POSTS_TYPE, array("post", "page"));
    }

    /**
     * @Given /^I go to preview of post "([^"]*)"$/
     */
    public function visitPreview($postTitle)
    {
        $post = get_page_by_title($postTitle, "OBJECT", "post");
        assertNotNull($post);

        $this->mink->getSession()->visit("/?p={$post->ID}&preview=true");
    }
}
