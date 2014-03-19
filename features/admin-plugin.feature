Feature: Manage UpCloo plugin
    In order to use the UpCloo plugin
    As a valid user of the blog
    I need to set up the plugin

    Background:
        Given I have a vanilla wordpress installation
            | name             | email                   | username | password |
            | UpCloo WordPress | walter.dalmut@gmail.com | admin    | test     |
        And there are plugins
            | plugin            | status  |
            | upcloo/upcloo.php | enabled |
        And I am logged in as "admin" with password "test"


    Scenario: A message notifies that i have to configure the plugin
        When I go to "/wp-admin"
        Then I should see "Remember that your have to configure UpCloo Plugin"

    Scenario: Configure the UpCloo sitekey in order to use the platform
        When I go to "/wp-admin/admin.php?page=upcloo_options_menu"
        And I fill in "upcloo_sitekey" with "en-test"
        And I press "Save Changes"
        Then the "upcloo_config_id" field should contain "upcloo_1000"
        And the "upcloo_sitekey" field should contain "en-test"
        And I should not see "Remember that your have to configure UpCloo Plugin"

    Scenario: Enable UpCloo also on pages
        When I go to "/wp-admin/admin.php?page=upcloo_menu_advanced"
        And I check "page"
        And I press "Save Changes"
        Then the "page" checkbox should be checked
