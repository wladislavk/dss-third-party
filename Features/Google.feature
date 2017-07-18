Feature: Google check
  In order to check if Microsoft is still alive
  As some user
  I want to check if microsoft.com is googlable

  Scenario: Google for Microsoft
    When I open "google.com" web page
    Then I see a search form
    When I print "microsoft" in the search form
    And I submit the search form
    Then I see a link to "microsoft.com" in the "1" place on the results page
