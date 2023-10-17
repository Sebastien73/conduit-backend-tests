***
Troubleshooting : Test of functions of User CLass
***
    - Languagetoo.org
***
Test of function -> getRouteKeyName()
***

    - Input data : With empty user and called getRouteKeyName on him.

    - Expected result : return value of key bio the user.

        When I test the key bio compared with a given or created user.
        The test doesn't work correctly because the function in the User class,
        return a key username instead of key bio.

    - Obtained result : 

        Failed asserting that two strings are equal.
        Expected : 'bio'
        Actual : 'username'

    - Solution : 

        Change the key in the body function so the test works correctly.

***
Test 1 of function -> following()
***

    - Input data : With a user saved in the database that follows another user.

    - Expected result : 
        Return a follower's list of a user with the data we need.
        Data of username, email, and bio.

    - Actual result : 
        Return a follower's list of a user with the data we need.
        Data of username, email, bio, pseudo and job. 

    - Obtained result :

        Failed asserting that two objects are equal.
        Expected : 

            'items' => Array (
                0 => Array (
                    'id' => 2
                    'username' => 'Musonda'
                    'email' => 'musonda@gmail.com'
                    'bio' => 'Je songe àdevenir infirmière,...exions'
                )
            )        

        Actual : 

            'items' => Array (
                0 => Array (
                    'id' => 2
                    'username' => 'Musonda'
                    'email' => 'musonda@gmail.com'
                    'bio' => 'Je songe àdevenir infirmière,...exions'
                    'pseudo' => null
                    'job' => null
                )
            )

    - Solution :

        The keys "pseudo" and "job" do not exist in the database.
        Either create these keys in the database or do not use them in code.

***
Test 2 of function -> following()
***        

    - Input data : With a user saved in the database that follows another user.

    - Expected result : Return one.

    - Actual result : Return zero.

    - Obtained result :

        Failed asserting that actual size 0 matches expected size 1.
      
    - Solution :

        Make sure you have one piece of data saved in the table "followers".

***
Test of function -> articles()
***        

    - Input data : With a user saved in the database that have at least one articles.

    - Expected result : Return 4.

    - Actual result : Return 2.

    - Obtained result :

        Failed asserting that 2 is equal to 4 or is greater than 4.      
    
- Solution :

        Make sure the count collection of the user is greater than or equal to the expected value.
        On this test, the user has only two articles attach on him.
