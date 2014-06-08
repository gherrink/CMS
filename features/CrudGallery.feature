Feature: Show Gallery
    In order to create, read, update and delete a gallery
    As a site moderator
    I need to be able to edit galleries

    Scenario: show existing gallery
	Given I am logged in as moderator
	And I am visting the gallery page
	Then I should see the gallery "Erste Galerie"

    Scenario: create gallery successful
	Given I am logged in as moderator
	And I am visting the gallery page
	When I open the gallery creation form
	And I enter "TestGallery" into the "label"field
	And I enter "VISITOR" into the "roleaccess"field
	And I fill in "TestGallery" into the "GalleryLanguage[0][head]" field
	And I create the gallery
	Then the url should match "gallery/edit"
	And I should see the gallery "TestGallery"

#    Scenario Outline: create gallery fails
#	Given I am logged in as moderator
#	And I am visting the gallery page
#	When I open the gallery creation form
#	And I enter "<label>" into the "label"field
#	And I enter "<roleaccess>" into the "roleaccess"field
#	And I fill in "<title>" into the "GalleryLanguage[0][head]" field
#	And I try to create the gallery
#	Then I shoud see an error on "<fields>"

#	Examples:
#	| label | roleaccess | title | fields |
#	|| VISITOR | Bla | label |

