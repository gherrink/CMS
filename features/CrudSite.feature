Feature: CRUD Site
    In order to create, read, update and delete a page of the website
    As a site moderator
    I need to edit the pages

    Scenario Outline: create new page successful
	Given I am logged in as site moderator
	And I am visiting the createpage page
	When I enter "<pagename>" into the "label"field
	And I enter "<right>" into the "roleaccess"field
	And I enter "<layout>" into the "layout"field
	And I set the page title to "<title>"
	And I create the page
	Then the url should match "site/edit"

	Examples:
	| pagename | right   | layout | title 		   |
	| testpage | VISITOR | COL01  |			   |
	| tespagezwei | VISITOR | COL01  | Testseite Zwei  |

#   Scenario Outline: create new page fails
#	Given I am logged in as site moderator
#	And I am visiting the createpage page
#	When I enter "<pagename>" into the "label"field
#	And I enter "<right>" into the "roleaccess"field
#	And I enter "<layout>" into the "layout"field
#	And I set the page title to "<title>"
#	And I try to create the page
#	Then I shoud see an error on the help block of "<fields>"
#
#	Examples:
#	| pagename   | right   | layout  | title | fields|
#	| ErsteSeite | VISITOR | column1 | Titel | label |
#	|	     | VISITOR | column1 | Titel | label |


    Scenario: read page
	Given I am logged in as site moderator
	And I visit the "ErsteSeite" page
	Then I should see the text "Erste Seite"

    Scenario Outline: update existing page
	Given I am logged in as site moderator
	When I am visiting the editpage page of "<labelbefore>"
	And I open the site update form
	And I fill in "<value>" into the "<field>" field
	And I update the site
	Then I should be on the editpage page of "<labelafter>"
	And I should see the text "<title>"

	Examples:
	| labelbefore | value 	     | field 			| labelafter | title |
	| ErsteSeite  | ZweiteSeite  | Site[label] 		| ZweiteSeite | Erste Seite |
	| ZweiteSeite | VISITOR      | Site[roleaccess]  	| ZweiteSeite | Erste Seite |
	| ZweiteSeite | Zweite Seite | SiteLanguage[0][head]	| ZweiteSeite | Zweite Seite |

    Scenario: delete page
	Given I am logged in as site moderator
	When I am visiting the editpage page of "LoeschSeite"
	And I delete the site
	Then the url should match "site"
	And I should not see the text "LoeschSeite"
