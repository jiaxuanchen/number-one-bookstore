<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this codew absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Hassanain Jamal
//
// TODO: Add control the new expected behavior to
// register
// log in
// flag one quote
// unflag all quotes
// log out
//
require_once './DataBaseAdaptor.php';
session_start();
if (isset ($_POST ['author']) && isset ($_POST ['quote'])) {
    $author = $_POST ['author'];
    $quote = $_POST ['quote'];
    $myDatabaseFunctions->addNewQuote($quote, $author);
    header("Location: ./index.php?mode=showQuotes");
} elseif (isset ($_POST ['action']) && isset ($_POST ['ID'])) {
    $action = $_POST ['action'];
    $ID = $_POST ['ID'];
    if ($action === 'increase') {
        $myDatabaseFunctions->raiseRating($ID);
    }
    if ($action === 'decrease') {
        $myDatabaseFunctions->lowerRating($ID);
    }
    if ($action === 'flag') {
        $myDatabaseFunctions->flag($ID);
    }

    if ($action === 'all') {
        $myDatabaseFunctions->unFlagAll();
    }

    if ($action === 'over') {
        session_start();
        session_destroy();
    }

    header("Location: ./index.php?mode=showQuotes");
} elseif (isset ($_POST ['firstName']) && isset ($_POST ['lastName'])) {

    $username = htmlspecialchars($_POST ['firstName']);
    $password = $_POST ['lastName'];

    if ($myDatabaseFunctions->check($username) === 0) {


        $myDatabaseFunctions->createAccount($username, $password);
        $_SESSION['wrong'] = '';


        header("Location: ./index.php?mode=showQuotes");
    } else {
        $_SESSION['wrong'] = '<p>The username already taken</p>';
        header("Location: ./index.php?mode=register");
    }

} elseif (isset ($_POST ['user']) && isset ($_POST ['number'])) {
    $username = htmlspecialchars($_POST ['user']);
    $password = $_POST ['number'];
    if ($myDatabaseFunctions->areYouUser($username, $password)) {
        $_SESSION ['user'] = $username;
        $_SESSION['wrong'] = '';
        header("Location: ./index.php?mode=showQuotes");
    } else {
        $_SESSION ['wrong'] = '<p>Invalid Account/Password</p>';
        header("Location: ./index.php?mode=login");
    }
}

?>