#language: en

Feature: Addition
    """
    I want to send a contact mail to the webmaster
    of the page and i tipe in worng data becouse I
    always forget to fill in somthing, but at the
    last time I'll do it right :-).
    """

Scenario Outline: input wrong data
    Given I have viste the contact page
    When I enter "<name>" into the "name"field
    And I enter "<mail>" into the "mail"field
    And I enter "<subject>" into the "subject"field
    And I enter "<body>" into the "body"field
    And I click "contact"
    Then I shoud see an error on "<fields>"
    
    Examples:
      | name        | mail              | subject               | body                      | fields                    |
      | nothing     | nothing           | nothing               | nothing                   | name, mail, subject, body |
      | Bob Peter   | nothing           | nothing               | nothing                   | mail, subject, body       |
      | nothing     | bob.peter@da.de   | nothing               | nothing                   | name, subject, body       |
      | nothing     | nothing           | This is a Test Mail   | nothing                   | name, mail, body          |
      | nothing     | nothing           | nothing               | This is some body content | name, mail, subject       |

Scenario Outline: input wright data
    Given I have viste the contact page
    When I enter "<name>" into the "name"field
    And I enter "<mail>" into the "mail"field
    And I enter "<subject>" into the "subject"field
    And I enter "<body>" into the "body"field
    And I click "contact"
    Then I shoud see that my mail was send correctly

    Examples:
      | name        | mail              | subject               | body                                                      |
      | Bob Peter   | bot.peter@da.de   | This is a Test Mail   | This is a test Mail for the webmaster hop he gets it :-). |