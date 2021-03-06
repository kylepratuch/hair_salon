<?php

    //App dependencies:
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();
    $app['debug'] = true;

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
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    //Clear all stylists and clients:
    $app->post("/clear", function() use ($app) {
        Client::deleteAll();
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //View a stylist's page:
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylists.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Save a new client:
    $app->post("/clients", function() use ($app) {
        $name = $_POST['name'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($name, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylists.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Page for updating a stylist:
    $app->get("/stylists/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $stylist));
    });

    //Update a stylist:
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($name);
        return $app['twig']->render('index.html.twig', array('stylist' => $stylist, 'stylists' => Stylist::getAll()));
    });

    //Delete a stylist:
    $app->delete("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Page for updating a client:
    $app->get("/clients/{id}/edit", function($id) use ($app) {
        $client = Client::find($id);
        $stylist = Stylist::find($client->getStylistId());
        return $app['twig']->render('client_edit.html.twig', array('client' => $client, 'stylist' => $stylist));
    });

    //Update a client:
    $app->patch("/clients/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $client = Client::find($id);
        $client->update($name);
        $stylist = Stylist::find($client->getStylistId());
        return $app['twig']->render('stylists.html.twig', array('client' => $client, 'stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Delete a client:
    $app->get("/clients/{id}/delete", function($id) use ($app) {
        $client = Client::find($id);
        $client->delete();
        $stylist = Stylist::find($client->getStylistId());
        return $app['twig']->render('stylists.html.twig', array('client' => $client, 'stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    return $app;
?>
