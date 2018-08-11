Feature: Is the home page loading
  In order to find out if the site is loading
  As every browser can see
  I want to check the homepage status

  Scenario: The webpage is running
    Given I am on homepage
    Then the response status code should be 200
    And I should see "Laravel"