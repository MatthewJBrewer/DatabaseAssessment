<?php

/**
* Message Class
*
* Responsible for handling messages sent through the form on the landing page.
*/

namespace DatabaseExample;

use Webmozart\Assert\Assert;

class Message {

    public $formData; // This attribute represents the (presumtively) POST data passed in the construction of the object.

    public $success = false; // This attribute will remain false unless the PDO query in insertMessage() is successfully completed.
    public $validationError; // This attribute will be populated with a string if an errors.

    /**
     * Construct
     *
     * Creates a new Message object and attempts to validate, sanitize, and create the message in the database using
     * the form data passed.
     *
     * @param array $formData
     */
    public function __construct(array $formData) {

        $this->formData = $formData;

        // Validate provided form data
        $validInput = $this->validateInput();

        // If the input is valid, use the input to create the database row
        if ($validInput == true) {

            // Call the insertMessage() method that creates the database row
            $this->insertMessage();

        }

    }

    /**
     * Validate Input
     *
     * Validates all of the input fields that should be passed in the creation of the Message object.
     *
     * @return boolean
     */
    private function validateInput() {

        /**
         * Validate and  Sanitize Input
         */
        try {

            // First name
                // Validates against the maximum length set in the database. Validates against the minimum length
                // for most names. Validates using a regular expression to ensure that there are no special characters.
                // Does allow for a single space in the middle of the name.
            Assert::minLength($this->formData["firstName"], 2, "Must complete the first name field.");
            Assert::maxLength($this->formData["firstName"], 36, "First name field is too long.");
            Assert::regex($this->formData["firstName"], "/^([\w\d]+)( )?([\w\d]+)?$/", "First name includes invalid characters.");


            // Last name
                // Validates against the maximum length set in the database. Validates against the minimum length
                // for most names. Validates using a regular expression to ensure that there are no special characters.
                // Does allow for a single space in the middle of the name.
            Assert::minLength($this->formData["lastName"], 2, "Must complete the last name field.");
            Assert::maxLength($this->formData["lastName"], 36, "First last field is too long.");
            Assert::regex($this->formData["lastName"], "/^([\w\d]+)( )?([\w\d]+)?$/", "Last name includes invalid characters.");


            // Job title
                // Validates the job title against the maximum length set in the database.
            Assert::maxLength($this->formData["jobTitle"], 256, "The ob title field is too long.");


            // Email address
                // Validates against a regular expression that checks for the presence of basic email elements such as
                // the domain name and TLD.
            Assert::regex($this->formData["emailAddress"], "/^(([\w\d_.-]+)(@)([\w\d_.-]+)([.])(com|net|org|edu))$/", "Provided email address is invalid.");


            // Phone number
                // Validates against a regular expression designed to interpret normal phone numbers.
            Assert::regex($this->formData["phoneNumber"], "/^(([+]?[\d]{1,2}[\s-]?)([(]?[\d]{3}[)]?)|([(]?[\d]{3}[)]?))?[\s-]?(\d{3})[\s-]?(\d{4})$/m", "Provided phone number is invalid.");


            // Message
                // Removes any HTML characters from the message. Validates the message length against the maximum
                // length set in the database.
            $this->formData["message"] = htmlspecialchars($this->formData["message"]);
            Assert::maxLength($this->formData["message"], 65565, "The message is too long.");

        } catch(\InvalidArgumentException $exception) {

            // Make the error message available as part of the object so that it can be used.
            $this->validationError = $exception->getMessage();

            return false;
        }

        return true;

    }

    /**
     * Insert Message
     *
     * Creates new database row with the form data provided upon the creation of the Message object.
     * Make sure that the data is validated and sanitized before calling this.
     *
     * @return void
     */
    private function insertMessage() {

        // Database connection is established in init.php; this will use that connection.
        global $database;

        // Establish INSERT query for adding a row into the "messages" table.
        $newQuery = $database->connection->prepare("INSERT INTO messages (first_name, last_name, job_title,  email_address, phone_number, message_text) VALUES (:first_name, :last_name, :job_title, :email_address, :phone_number, :message_text)");

        // Replace the prepared statement's placeholders with the data provided in the constructor.
        $newQuery->bindParam(":first_name", $this->formData["firstName"]);
        $newQuery->bindParam(":last_name", $this->formData["lastName"]);
        $newQuery->bindParam(":job_title", $this->formData["jobTitle"]);
        $newQuery->bindParam(":email_address", $this->formData["emailAddress"]);
        $newQuery->bindParam(":phone_number", $this->formData["phoneNumber"]);
        $newQuery->bindParam(":message_text", $this->formData["message"]);

        // Create the row using the prepared query.
        $this->success = $newQuery->execute();

    }

}
