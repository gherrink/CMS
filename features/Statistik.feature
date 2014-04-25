# features/Statistik.feature
Feature: show Statistik
	Anzeigen einer Statistik

  Background:
  	Given there are sitecalles:
  	  | pageid 	| date 		 |
  	  | 1		| 14-01-2013 |
  	  | 2		| 14-01-2013 |
  	  | 3		| 14-01-2013 |
  	  | 1		| 15-01-2013 |
  	  | 2		| 15-01-2013 |
  	  | 3		| 15-01-2013 |
  	  | 1		| 16-01-2013 |
  	  | 1		| 17-01-2013 |
  	  | 1		| 18-01-2013 |
  	  | 1		| 19-01-2013 |
  	  | 2		| 19-01-2013 |
  	  | 1		| 14-02-2013 |
  	  | 2		| 14-02-2013 |
  	  | 3		| 14-02-2013 |
  	  | 1		| 15-02-2013 |
  	  | 2		| 15-02-2013 |
  	  | 3		| 15-02-2013 |
  	  | 1		| 16-02-2013 |
  	  | 1		| 17-02-2013 |
  	  | 1		| 18-02-2013 |
  	  | 1		| 19-02-2013 |
  	  | 2		| 19-02-2013 |
  	  | 3		| 14-03-2013 |
  	  | 1		| 15-03-2013 |
  	  | 2		| 15-03-2013 |
  	  | 3		| 15-03-2013 |
  	And there are sites:
  	  | pageid 	| pagename 	|
  	  | 1		| Homepage	|
  	  | 2		| About		|
  	  | 3		| Example	|

  Scenario Outline: show statistik <statistic>
  	Given actual date <actualDate>
  	When evaluate data
  	  Then show view statistik <statistic>
  	  But show errormessage "Statistic can't evaluated"
  	
  	Examples:
  	  | statistic 	| actualDate |
  	  | year		| 14-01-2013 |
  	  | month		| 14-01-2013 |
  	  | day			| 14-01-2013 |
  	  | day			| 01-01-2013 |
  	  | year		| 14-02-2013 |
  	  | month		| 14-02-2013 |
  	  | day			| 14-02-2013 |
  	  | year		| 14-03-2013 |
  	  | month		| 14-03-2013 |
  	  | day			| 14-03-2013 |