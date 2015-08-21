<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //Dependencies:
    require_once "src/Stylist.php";
    // require_once "src/Client.php";

    //Tell app how to access db:
    $server = 'mysql:host=localhost:3306;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        //Test that Stylist can getName:
        function test_getName()
        {
            //Arrange
            $name = "Erin";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        //Test that Stylist can getId:
        function test_getId()
        {
            //Arrange
            $name = "Erin";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //Test that Stylist can save to db:
        function test_save()
        {
            //Arrange
            $name = "Erin";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        //Test that Stylist can getAll from db:
        function test_getAll()
        {
            //Arrange
            $name = "Erin";
            $name2 = "Kyle";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        //Test that Stylist can deleteAll from db:
        function test_deleteAll()
        {
            //Arrange
            $name = "Erin";
            $name2 = "Kyle";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //Test that Stylist can find by id in db:
        function test_find()
        {
            //Arrange
            $name = "Erin";
            $name2 = "Kyle";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::find($test_stylist->getId());

            //Assert
            $this->assertEquals($test_stylist, $result);
        }

        //Test that Stylist can update entries in db:
        function test_update()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $new_name = "Kyle";

            //Act
            $test_stylist->update($new_name);

            //Assert
            $this->assertEquals("Kyle", $test_stylist->getName());
        }

        //Test that Stylist can delete entries from db:
        function test_delete()
        {
            //Arrange
            $name = "Erin";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            //Act
            $test_stylist->delete();

            //Assert
            $this->assertEquals([], Stylist::getAll());
        }
    }



 ?>
