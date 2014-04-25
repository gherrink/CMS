# features/Site.feature
Feature: Site
	CRUD Site
	
	Background: 
	  Given ther are users:
	    | user		| right 			|
	    | mrbirne	| Site Moderator	|
	    | bob		| User				|
	    
	  And ther are layouts:
	  	| layout | positions |
	  	| 1		 | 1		 |
	  	| 2		 | 2		 |
	
	
	Scenario Outline: create site
	  Given user <user> is logged in
	  When create site <site name> with <layout>
	  Then show success Message "Site successfull created"
	  But show error Message "Site cant be created"
	  
	Examples:
	  | user	| site name	| layout |
	  | mrbirne | Homepage	| 1		 |
	  | mrbinre	| Homepage	| 1		 |
	  | mrbrine | About		| 20	 |
	  | bob		| Example	| 1	 	 |
	  
	Scenario Outline: new content
	  Given user <user> is logged in
	  And site name is <site>
	  When create content on site <position>
	  Then show success Message "Conten sucessfully created"
	  But show error Message "Conten can't be created"
	  
	  Examples:
	    | user		| site	| postition |
	    | mrbirne 	| 1		| 1			|
	    | mrbirne 	| 1		| 5			|
	    | mrbirne 	| 1		| 1			|
	    | bob		| 2		| 2			|
	
	Scenario Outline: add content
	  Given user <user> is logged in
	  And site name is <site>
	  When add <content> to site <position>
	  Then show success Message "Content added sucessfully"
	  But show error Message "Content can't be added"
	  
	  Examples:
		| user		| site	| content	| position	|
		| mrbirne	| 2		| 1			| 1			|
		| mrbirne	| 2		| 25		| 1			|
		| mrbirne	| 2		| 1			| 5			|
		| mrbirne	| 2		| 1			| 1			|
		| bob		| 2		| 1			| 1			|
	