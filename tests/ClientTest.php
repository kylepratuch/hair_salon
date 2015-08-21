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
            Client::deleteAll();
        }

        //Test that Client can save to db:
        function test_save()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client-> save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals($test_client, $result[0]);
        }

        //Test that Client can getName:
        function test_getName()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client-> save();

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        //Test that Client can getStylistId:
        function test_getStylistId()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $id = null;
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals($stylist_id, $result);
        }

        //Test that Client can getId:
        function test_getId()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test that Client can getAll:
        function test_getAll()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            $name2 = "Judy";
            $test_client2 = new Client($name2, $stylist_id, $id);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        //Test that Client can deleteAll:
        function test_deleteAll()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            $name2 = "Judy";
            $test_client2 = new Client($name2, $stylist_id, $id);
            $test_client2->save();

            //Act
            Client::deleteAll();
            $result = Client::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //Test that Client can find by id in db:
        function test_find()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            $name2 = "Judy";
            $test_client2 = new Client($name2, $stylist_id, $id);
            $test_client2->save();

            //Act
            $result = Client::find($test_client->getId());

            //Assert
            $this->assertEquals($test_client, $result);
        }

        //Test that Client can update an entry in db:
        function test_update()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            $new_name = "Jim";
            $new_test_client = new Client($new_name, $stylist_id, $test_client->getId());

            //Act
            $test_client->update($new_name);

            //Assert
            $this->assertEquals($test_client, $new_test_client);
        }

        function test_delete()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "George";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $stylist_id, $id);
            $test_client->save();

            $name2 = "Judy";
            $test_client2 = new Client($name2, $stylist_id, $id);
            $test_client2->save();

            //Act
            $test_client2->delete();

            //Assert
            $this->assertEquals([$test_client], Client::getAll());
        }
    }

?>
