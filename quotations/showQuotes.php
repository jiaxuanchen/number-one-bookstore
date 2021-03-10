<!-- 
This is the home page for Final Project, Part 1, Fall 2016 Quotes Enhanced.  

Any user can flag quotes, add quotes, or register as a user.  If registered and logged in, the
user can unflag all quotes to see all quotes in the data base. Yes some of the behavior is 
contrived, in order to review many concepts in the context of a larger web service.  

File name quotes.php 

Show the home page view with tabs to login, registration, and to add a new quote and most importantly to
show all unflagged quotes in the data base sorted by ranking
    
Author: Rick Mercer
-->

<?php
require_once './DataBaseAdaptor.php';
$arrayOfQuotes = $myDatabaseFunctions->getQuotesAsArray();
?>


<h1>Quotes</h1>

<!-- Add a horizontal menu -->
<div class="HorizontalMenu">
    <ul>
        <li><a href="register.html">Register</a></li>

        <li><a href="login.html">Login</a></li>
        <li><a href="addQuote.html">Add Quote</a></li>
    </ul>
</div>
<?php
session_start(); // Need this in each file before $_SESSION['key'] is used.
if (isset($_SESSION ['user'])) {
    ?>
    <div class="ButtonView">
        <form action="controller.php" method="post">
            <input type="hidden" name="ID" value="set">

            <button name="action" value="all">Unflag All</button>

            <button name="action" value="over">Logout</button>

        </form>
    </div>
    <?php
} ?>

<!--  Show all quotes on a separate row -->
<?php foreach ($arrayOfQuotes as $quote) { ?>

    <div class="container">
        <?= '"' . $quote['quote'] . '"' ?>
        <br>
        <p class="author">
            &nbsp;&nbsp;--
            <?= $quote['author'] ?>
            <br>
        </p>

        <form action="controller.php" method="post">
            <input type="hidden" name="ID" value="<?= $quote['id'] ?>">
            &nbsp;&nbsp;&nbsp;
            <button name="action" value="increase">+</button>

            <span id="rating"> <?= $quote['rating'] ?> </span>
            <button name="action" value="decrease">-</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button name="action" value="flag">flag</button>
            <input type="hidden" name="mode" value="showQuotes">


        </form>

    </div>
    <br>

<?php } // End for loop  ?>
