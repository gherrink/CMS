# features/Register.feature
Feature: Register
	
	Background: 
	  Given there are users:
		| username	| mail					| firtname	| lastname	|
		| mrbirne	| busch.maurice@gmx.net | Maurice	| Busch		|
		
		
	Scenario Outline: register user
	  Given user enter nickname <username>
		And user enter name <firstname> and <lastname>
		And user enter mailadress <mail>
		And user enter passwords <password> and <passwordrepead>
	  When register user
	  Then show success Message "User registered successfully"
	  But show error Message "User can't be registered"
	  
	  Examples:
		| username 	| fistname 	| lastname 	| mail 					| password 	| passwordrepead 	|
		| bob		| Bob		| Hainz		| bob.heinz@example.de	| bob1234	| bob1234			|
		| mrbirne	| Maurice	| Busch		| mrbirne@irgendwas.de	| asdf1234	| asdf1234			|
		| peter		| Peter		| Nachname	| busch.maurice@gmx.net	| blub1234	| blub1234			|
	  
	Scenario Outline: send register mail
	  When send registermail to <user>
	  Then show success Message "Registermail send successfully"
	  But show error Message "Registermail can't be send"
	  
	  Examples:
		| user |
	  
	Scenario Outline: click register link
	  When <user> clicks registerlink <link>
	  Then show success Message "Mail successfully validated"
	  But show error Message "Mail can't be validated"
	  
	  Examples:
		| user | link |
	  