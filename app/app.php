<?php

    //App dependencies:
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    // require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

    //Tell app how to access db:
    $server = 'mysql:host=localhost:3306;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Point app to twig templates:
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //Necessary for patch/delete routes:
    // use Sympfony\Component\HttpFoundation\Request;
    // Request::enableHttpMethodParameterOverride();

    //Homepage:
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //List stylists on homepage:
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    return $app;
?>
