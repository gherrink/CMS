Feature: Change Language
    In order to change the text language of the website
    As a user
    I need to select the language

    Scenario: change from german to english
	Given I am visiting the index page
	And the current language is "Deutsch"
	And I can see the homepage description
	When I select the language "English"
	Then there should be the english homepage description

