<?php

/*
*
* Index (Landing) Page File
*
* A simple public-directory landing page file to be executd when index.php is visted.
*
*/

/**
 * Require Application Initiation
 */

require dirname(dirname(__FILE__)) . "/app/init.php";

/**
 * Page Dependencies
 */

use DatabaseExample\Message;
use Webmozart\Assert\Assert;

/**
 * POST Request Handling
 */
if (!empty($_POST)) {

    $newMessage = new Message($_POST);

}

/**
 * Standard Page Response
 */

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="resources/css/main.css">

        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet">
        <title>Database Assessment</title>
        <script src="../resources/js/jquery/jquery-3.4.1.min.js"></script>
    </head>
    <body id="index-body">
        <div id="index-form-container">
            <form class="standard-form" action="" method="post">
                <?php
                if (!empty($_POST)) {

                    if ($newMessage->success) {
                        echo('<div class="message">');
                        echo("<p>Message sent successfully.</p>");
                        echo("</div>");
                    } elseif (!empty($newMessage->validationError)) {
                        echo('<div class="message error">');
                        echo("<p>" . $newMessage->validationError . "</p>");
                        echo("</div>");
                    }

                }
                ?>
                <div id="title-container">
                    <h1>Database Assessment</h1>
                    <h2>This is a simple "contact form" that validates input and creates a new database row using the form input.</h2>
                </div>
                <div class="fieldset with-margin">
                    <div id="title-container">
                        <h1>Personal Information
                    </div>
                    <div id="field-container">
                        <div class="field-line">
                            <input type="text" name="firstName" placeholder="First name">
                        </div>
                        <div class="field-line">
                            <input type="text" name="lastName" placeholder="Last name">
                        </div>
                        <div class="field-line with-label">
                            <input type="text" name="jobTitle" placeholder="Job title">
                            <label>Optional</label>
                        </div>
                    </div>
                </div>
                <div class="fieldset with-margin">
                    <div id="title-container">
                        <h1>Contact Information</h1>
                    </div>
                    <div id="field-container">
                        <div class="field-line">
                            <input type="text" name="emailAddress" placeholder="Email address">
                        </div>
                        <div class="field-line">
                            <input type="text" name="phoneNumber" placeholder="Phone number">
                        </div>
                    </div>
                </div>
                <div class="fieldset">
                    <div id="title-container">
                        <h1>Message</h1>
                    </div>
                    <div id="field-container">
                        <div class="field-line with-label">
                            <textarea rows="6" name="message" placeholder="Please let us know why you are reaching out to us."></textarea>
                            <label>Optional</label>
                        </div>
                        <div class="field-line no-margin">
                            <input type="submit" class="button contained" value="SEND MESSAGE">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
