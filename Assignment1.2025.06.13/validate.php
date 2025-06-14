<?php
// purpose: validate user input
class validate {
    public function checkEmpty($data, $fields) {
        // create function that takes two arguments
        $msg = null;
        // create message variable and assigns value of null
        foreach ($fields as $value) {
            // iterate over each element in the $fields array
            // assigns each array element the name of $value
            if (empty($data[$value])) {
                // if the corresponding element in $data (i.e. the data submitted by the user) is empty
                $msg .= "<p>$value field cannot be empty</p>";
                // append string and current $value value to $msg
            }
        }
        // return msg; if for each loop did not find empty elements, return message will be null
        return $msg;
    }

    /* commenting out validAge() and validEmail() as I didn't actually end up using them;
    went with employee hour records instead of anything that required age or email input */

    /*public function validAge($age) {
        // create function that takes one argument
        if (preg_match("/^[0-9]+$/", $age)) {
            // use preg_match regex to check if $age contains only the numbers 0-9 inclusive
            // if pattern matches, return true

            // syntax:
            //- delimiters to wrap the expression
            //- ^ to indicate start of the string
            //- [0-9] to indicate acceptable values
            //- + to indicate one or more of the preceding element; i.e. 0 - 9 inclusive
            //- $ to indicate the end of the string

            return true;
        }
        // if pattern doesn't match, return false
        return false;
    }*/

    /*public function validEmail($email) {
        // create function that takes on argument
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // filter_var() is a built-in function, and FILTER_VALIDATE_EMAIL is a built-in filter
            // use both to check if value of $email is valid according to standard email formatting rules
            // if valid, return true
            return true;
        }
        // otherwise, return false
        return false;
    }*/
}
?>
