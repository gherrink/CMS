# language: en
# Source: http://github.com/aslakhellesoy/cucumber/blob/master/examples/i18n/en/features/addition.feature
# Updated: Tue May 25 15:51:43 +0200 2010
Feature: Login
  """
  As a person with and without an account I'm trying to login. Then
  I remember that I have no Useraccount but I'm still to silly to
  enter the correct register datas. At the end I'll get it and can
  try to log me in and log me out.
  """

  Scenario Outline: login wrong
    Given I am visting the login page
    When I enter "<user>" into the "userid"field
    And I enter "<password>" into the "password"field
    And I click "login"
    Then I shoud see password and username does not match

    Examples: 
      | user        | password      |
      | bod         | testPW123     |
      | asdf        | password      |
      | 343askldf   | trylogin      |
      | admin       | admin         |

  Scenario Outline: register wrong
    Given I am visiting the register page
    When I enter "<userid>" into the "userid"field
    And I enter "<firstname>" into the "firstname"field
    And I enter "<lastname>" into the "lastname"field
    And I enter "<password>" into the "password"field
    And I enter "<password_repead>" into the "password_repead"field
    And I enter "<mail>" into the "mail"field
    And I click "register"
    Then I shoud see an error on "<fields>"

    Examples:
      | userid      | firstname         | lastname          | password          | password_repead   | mail              | fields                                                        |
      | nothing     | nothing           | nothing           | nothing           | nothing           | nothing           | userid, firstname, lastname, password, password_repead, mail  |
      | bob123      | nothing           | nothing           | nothing           | nothing           | nothing           | firstname, lastname, password, password_repead, mail          |
      | nothing     | Bob               | nothing           | nothing           | nothing           | nothing           | userid, lastname, password, password_repead, mail             |
      | nothing     | nothing           | Diedeldumm        | nothing           | nothing           | nothing           | userid, firstname, password, password_repead, mail            |
      | nothing     | nothing           | nothing           | test              | nothing           | nothing           | userid, firstname, lastname, password, password_repead, mail  |
      | nothing     | nothing           | nothing           | test123           | nothing           | nothing           | userid, firstname, lastname, password, password_repead, mail  |
      | nothing     | nothing           | nothing           | Test              | nothing           | nothing           | userid, firstname, lastname, password, password_repead, mail  |
      | nothing     | nothing           | nothing           | Test1234          | nothing           | nothing           | userid, firstname, lastname, password_repead, mail            |
      | nothing     | nothing           | nothing           | nothing           | Test1234          | nothing           | userid, firstname, lastname, password, password_repead, mail  |
      | nothing     | nothing           | nothing           | Test1234          | Test1234          | nothing           | userid, firstname, lastname, mail                             |
      | nothing     | nothing           | nothing           | nothing           | nothing           | bob.bob@domain.de | userid, firstname, lastname, password, password_repead        |

  Scenario Outline: register
    Given I am visiting the register page
    When I enter "<userid>" into the "userid"field
    And I enter "<firstname>" into the "firstname"field
    And I enter "<lastname>" into the "lastname"field
    And I enter "<password>" into the "password"field
    And I enter "<password_repead>" into the "password_repead"field
    And I enter "<mail>" into the "mail"field
    And I click "register"
    Then I shoud see that I am registered

    Examples:
      | userid      | firstname         | lastname          | password          | password_repead   | mail              |                         
      | bobtest     | Bob               | Diedeldumm        | TestPW1234        | TestPW1234        | bot.bob@domain.de |

  Scenario Outline: login
    Given I am visting the login page
    When I enter "<user>" into the "userid"field
    And I enter "<password>" into the "password"field
    And I click "login"
    Then I am logedin with "<user>"

    Examples: 
      | user        | password      |
      | bobtest     | TestPW1234    |

  Scenario Outline: logout
    Given I am logedin with "<user>"
    When I logout as "<user>"
    Then I shoud see that I am logged out as "<user>"

    Examples:
      | user        |
      | bobtest     |