<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Dependencies:
    require_once "src/Stylist.php";
    require_once "src/Client.php";

    //Tell app how to access db:
    $server = 'mysql:host=localhost:3306;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            // Client::deleteAll();
        }

        //Test that Client can getName:
        function test_getName()
        {
            //Arrange
            $name = "George";
            $stylist_id = 1;
            $test_client = new Client($name, $stylist_id);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        //Test that Client can getStylistId:
        function test_getStylistId()
        {
            //Arrange
            $name = "George";
            $stylist_id = 1;
            $test_client = new Client($name, $stylist_id);

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals($stylist_id, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "George";
            $stylist_id = 1;
            $id = 2;
            $test_client = new Client($name, $stylist_id, $id);

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

    }

?>
