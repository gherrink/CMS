# features/Rechte.feature
Feature: Rechte
	
	Background: 
		
	  Given: there are users:
		| username	| mail					| firtname	| lastname	|
		| mrbirne	| busch.maurice@gmx.net | Maurice	| Busch		|
	
	Scenario Outline: change right
	  When user <user> is selected
		And rights <rights> are selected
		And change rights
	  Then show success Message "Rights successfully changed"
	  But show error Message "Rights can't be changed"
	  
	  Examples:
		| user 		| rights								|
		| mrbrine	| Administrator					 		|
		| mrbirne	| Page Moderator, Guestbook Moderator	|