<?php

/* - - - Functions - - - */

// - - Data - - //

// Username

function validateUsername(string $username): string|null
{
    $username = trim($username);

    // return specific error messages for if statements
    if (empty($username)) {
        return "Username is required.";
    }
    if (strlen($username) < 5 || strlen($username) > 15) {
        return "Please enter a username between 5 and 15 characters.";
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return "Username can only contain letters, numbers, and underscores.";
    }

    // if all checks pass and input is valid, return null
    return null;
}

// First Name
function validateFirstName(string $firstName): string|null
{
    $firstName = trim($firstName);

    // return specific error messages for if statements
    if (empty($firstName)) {
        return "First name is required.";
    }
    if (strlen($firstName) < 1 || strlen($firstName) > 20) {
        return "Please enter a name between 1 and 20 characters.";
    }
    if (!preg_match('/^[a-zA-Z\s\'-]+$/', $firstName)) {
        return "First name can only contain letters, spaces, hyphens, and apostrophes.";
    }

    return null;
}

// Last Name
function validateLastName(string $lastName): string|null
{
    $lastName = trim($lastName);

    // return specific error messages for if statements
    if (empty($lastName)) {
        return "Last name is required.";
    }
    if (strlen($lastName) < 1 || strlen($lastName) > 20) {
        return "Please enter a name between 1 and 20 characters.";
    }
    if (!preg_match('/^[a-zA-Z\s\'-]+$/', $lastName)) {
        return "Last name can only contain letters, spaces, hyphens, and apostrophes.";
    }

    return null;
}

// Email Address
function validateEmail(string $emailAddress): string|null
{
    $emailAddress = trim($emailAddress);

    if (empty($emailAddress)) {
        return "Email is required.";
    }
    // using filter_var() for email validation; built-in PHP function that's used to validate data
    // its inputs are the value being validated (i.e. the email address, and the type of filter)
    // in this case, FILTER_VALIDATE_EMAIL checks where the input is a properly formed email address
    // if the validation returns true, then we move on to trying to update the email address
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        return "That is not a valid email address.";
    }

    return null;
}

// Phone Number
function validatePhoneNumber(string $phoneNumber): string|null
{
    $phoneNumber = trim($phoneNumber);

    // return specific error messages for if statements
    if (empty($phoneNumber)) {
        return "Phone number is required.";
    }
    if (strlen($phoneNumber) != 10) {
        return "Please enter a ten-digit number (area code + local number).";
    }
    if (!preg_match('/^[0-9]+$/', $phoneNumber)) {
        return "Phone number can only consist of digits.";
    }

    return null;
}

// - - Content - - //

// Title
function validateTitle(string $title): string|null
{
    $title = trim($title);

    // return specific error messages for if statements
    if (empty($title)) {
        return "Title is required.";
    }
    if (strlen($title) < 1 || strlen($title) > 30) {
        return "Please enter a title between 1 and 30 characters.";
    }

    // prevent anything valid characters
    // going to keep the full regex breakdown here for future references
    /*
    Delimiters: / - the start and end of the regex pattern

    Anchors:    ^   - Asserts position at start of the string
                $ - Asserts position at end of the string
                ^ and $ together ensures that the entire string matches the regex pattern

    Character class []:
        a-z     lowercase letters
        A-Z     uppercase letters
        0-9     digits
        \s      whitespace characters (i.e. space, tab, newline)
        .,!?    these specific punctuation marks
        \'      single quotes (escaped with backslash)
        "       double quote
        -       hyphen (at the end to avoid being interpreted as a range)

    Quantifier + means "one or more" of preceding element
    */
    if (!preg_match('/^[a-zA-Z0-9\s.,!?\'"-]+$/', $title)) {
        return "Title contains invalid characters.";
    }

    return null;
}

// Body
function validateBody(string $body): string|null
{
    $body = trim($body);

    // return specific error messages for if statements
    if (empty($body)) {
        return "Body text is required.";
    }
    if (strlen($body) < 1 || strlen($body) > 300) {
        return "Please enter text between 1 and 300 characters.";
    }
    if (!preg_match('/^[a-zA-Z0-9\s.,!?\'"-]+$/', $body)) {
        return "Body contains invalid characters.";
    }

    return null;
}
