# features/Login.feature
Feature: Login
	
	Scenario Outline: login false
		In order to login a User with false username or password
	  When login "<usr>" with "<pw>"
	  Then you soud see error Message "USR_PW_NOT_CORRECT"
	  
	Examples:
	  | usr		| pw		|
	  | mrbirne	| asdf		|
	  | bob		| asdfd		|
	  | bob		| blub		|
		
	Scenario: login right
		In order to login a User correctly
	  When login "mrbrine" with "asdfd"
	  Then you soud be loged in
	  
	Scenario: logout
		In order to logout a User
	  When login "mrbrine" with "asdfd"
	  And logout
	  Then you soud be loged out
	  