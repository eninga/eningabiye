<?php

use Silex\Application;
use src\controller\IndexController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// web/index.php

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add("src", dirname(__DIR__));
$app = new Application();
$app['debug'] = true;
$app->mount("/", new IndexController());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$blogPosts = array(
    1 => array(
        'date' => '2011-03-29',
        'author' => 'igorw',
        'title' => 'Using Silex',
        'body' => '...',
    ),
    2 => array(
        'date' => '2011-03-29',
        'author' => 'igorw',
        'title' => 'Using Symfony',
        'body' => '...',
    ),
);

$app->get('/blog', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
        $output .= '<br />';
    }

    return $output;
});

$app->post('/feedback', function (Request $request) {
    $message = $request->get('message');
    mail('eningabiye@yahoo.fr', '[YourSite] Feedback', $message);

    return new Response('Thank you for your feedback!', 201);
});
// definitions


$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message);
});
$app->run();
?>