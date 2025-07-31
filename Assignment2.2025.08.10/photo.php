<?php

// start session on page load
session_start();

// page metadata
$pageTitle = 'Photo';
$pageDescription = "Page for calling photo update function.";
$pageKeywords = 'photo, user, settings';

// include necessary templates and classes
require './templates/head.php';
require './templates/header.php';
require './inc/database.php';
require './inc/user.php';

/* - - - Run On Page Load - - - */

// check if user is logged in; otherwise, deny access
if (!isset($_SESSION['user_id'])) {
    // run footer code if user isn't logged in; otherwise, it doesn't show at all, because die() terminates the script early
    // there is surely a better way to handle this footer situation but i'm going to stick with this for now
    require './templates/footer.php';
    die("Access denied. Please login.");
}

/* - If we make it to this part of the run-on-page-load code, it's because the user is logged in. - */

// create database instance
$database = new Database();
$databaseConnection = $database->getDatabaseConnection();
$user = new User($databaseConnection);

// retrieve user ID from session
$userId = $_SESSION['user_id'];

// if the file has been submitted via POST, and we have a profile_photo value set in $_FILES array
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {

    // we call updateProfilePhoto() from our user class and pass in the userId
    $user->updateProfilePhoto($userId);

    // in future will have better error validation here

    // redirect to profile page on successful upload (in this case, where we already are)
    header("Location: profile.php");
    exit;
}
// run footer code here if the user was logged in properly when they loaded the page
require './templates/footer.php';
?>