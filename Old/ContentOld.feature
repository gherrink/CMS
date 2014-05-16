# features/Content.feature
Feature: Content
	
	Background:
	  Given: there are contents:
		| content 	| text				|
		| 1			|					|
		| 2			| Content mit Text	|
	
	Scenario Outline: enter text
	  When enter text <text> to <content>
		And layout changed to <layout>
		And commit changes
	  Then show success Message "Content successfully changed"
	  But show error Message "Content can't be changed"
	  
	  Examples:
		| text				| content	| layout 	|
		| Überschrift		| 1			| <h3>		|
		| Einfacher Text	| 1			| 			|
		| Fetter Text		| 1			| <b>		|
		
	Scenario Outline: enter table
	  When enter table with <cols> and <cells>
	  Then you shod see a Table with <cols> and <cells>
	  But show error Message "Table can't be created"
	  
	  Examples:
		| cols	| cells	|
	  
	Scenario Outline: upload picture
	  When upload a picture with the <path>
	  Then you shod see the picture
	  But show error Message "Picture can't be uploaded"
	  
	  Examples:
		| path		|
		