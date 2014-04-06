Feature: The plugin works correctly
    In order to see related posts on a web page
    As guest of the website
    I need to visit a web post

    Background:
        Given I have a vanilla wordpress installation
            | name             | email                   | username | password |
            | UpCloo WordPress | walter.dalmut@gmail.com | admin    | test     |
        And there are plugins
            | plugin            | status  |
            | upcloo/upcloo.php | enabled |
        And there are posts
            | post_title    | post_content            | post_status | post_author | post_type |
            | A simple post | The simple post content | publish     | 1           | post      |
            | A draft       | The draft content       | draft       | 1           | post      |
            | About Us      | This is the page        | publish     | 1           | page      |
            | Contact Us    | A simple contact page   | draft       | 1           | page      |
        And the upcloo plugin is correctly configured with sitekey "en-test"

    Scenario: UpCloo is not visibile directly
        When I go to "/"
        Then I should not see the UpCloo related posts box

    Scenario: UpCloo is visibile on a blog post
        When I go to "/"
        And I follow "A simple post"
        Then I should see the UpCloo related posts box

    Scenario: UpCloo is not visible by default on pages
        When I go to "/"
        And I follow "About Us"
        Then I should not see the UpCloo related posts box

    Scenario: UpCloo is visibile on pages when enabled
        Given UpCloo is enabled on pages
        When I go to "/"
        And I follow "About Us"
        Then I should see the UpCloo related posts box

    Scenario: UpCloo is not visible on drafts previews
        Given I am logged in as "admin" with password "test"
        And I go to preview of post "A draft"
        Then I should see "A draft"
        And I should not see the UpCloo related posts box

    Scenario: UpCloo is not visible on a page draft previews
        Given UpCloo is enabled on pages
        And I am logged in as "admin" with password "test"
        And I go to preview of page "Contact Us"
        Then I should see "Contact Us"
        And I should not see the UpCloo related posts box

