Feature: Show Gallery
    In order to create, read, update and delete a gallery
    As a site moderator
    I need to be able to edit galleries

    Scenario: show existing gallery
	Given I am logged in as gallery moderator
	And I am visting the gallery page
	Then I should see the gallery "Erste Galerie"

    Scenario: create gallery successful
	Given I am logged in as gallery moderator
	And I am visting the gallery page
	When I open the gallery creation form
	And I enter "TestGallery" into the "label"field
	And I enter "VISITOR" into the "roleaccess"field
	And I fill in "TestGallery" into the "GalleryLanguage[0][head]" field
	And I create the gallery
	Then the url should match "gallery/edit"
	And I should see the gallery "TestGallery"

    Scenario Outline: update gallery
	Given I am logged in as gallery moderator
	And I am visting the gallery page
        When I open the "<label>" gallery with name "<gallerybefore>"
	And I open the gallery update form
	And I fill in "<value>" into the "<field>" field
	And I update the gallery
	And I am visting the gallery page
	Then I should see the gallery "<galleryafter>"
	
	Examples:
	| label	        | gallerybefore | field 	 	   	  | value	   | galleryafter   |
	| ErsteGalerie  | Erste Galerie | Gallery[label] 	  | ZweiteGalerie  | Erste Galerie  |
        | ZweiteGalerie | Erste Galerie | Gallery[roleaccess] 	  | VISITOR        | Erste Galerie  |
	| ZweiteGalerie | Erste Galerie | GalleryLanguage[0][head] | Zweite Galerie | Zweite Galerie |

    Scenario: delete gallery successful
	Given I am logged in as gallery moderator
	And I am visting the gallery page
	When I open the "LoeschGalerie" gallery with name "LoeschGalerie"
	And I delete the gallery
	Then the url should match "gallery"
	And I should not see the gallery "LoeschGalerie"

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

