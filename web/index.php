<?php

require_once __DIR__.'/../vendor/autoload.php';

$dataDirectory = __DIR__ . '/../data';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

$app->get('/page/{page}', function (Silex\Application $app, $page) use ($dataDirectory) {
    $path = $dataDirectory . '/pages/*-' . $page . '.md';

    if (file_exists($path)) {
        $article = [
            'body' => Michelf\Markdown::defaultTransform(file_get_contents($path))
        ];

        return $app['twig']->render('article.twig', [
            'article' => $article,
        ]);
    }

    $app->abort('404', 'Page Not Found');
});

$app->get('/article/{article}', function (Silex\Application $app, $article) use ($dataDirectory) {
    $path = $dataDirectory . '/articles/*-' . $article . '.md';

    $file = current(glob($path));

    if ($file) {
        $baseName = substr(basename($file), 0, strrpos(basename($file), '.'));

        if (preg_match('/([0-9-]*)-(.*)/', $baseName, $matches)) {
            $article = [
                'title' => str_replace('-', ' ', $matches[2]),
                'date' => date('F jS, Y', strtotime($matches[1])),
                'body' => Michelf\Markdown::defaultTransform(file_get_contents($file))
            ];

            return $app['twig']->render('article.twig', [
                'article' => $article,
            ]);
        }
    }

    $app->abort('404', 'Article Not Found: ' . $article);
});

$app->get('/', function (Silex\Application $app) use ($dataDirectory) {
    $files = glob($dataDirectory . '/articles/*.md');

    $files = array_reverse($files);

    $articles = [];

    foreach ($files as $file) {
        $file = substr(basename($file), 0, strrpos(basename($file), '.'));

        if (preg_match('/([0-9-]*)-(.*)/', $file, $matches)) {
            $articles[] = [
                'href' => '/article/' . $matches[2],
                'title' => str_replace('-', ' ', $matches[2]),
                'date' => date('F jS, Y', strtotime($matches[1]))
            ];
        }
    }

    return $app['twig']->render('home.twig', [
        'articles' => $articles,
    ]);
});

$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return $app['twig']->render('error.twig', [
        'message' => $message,
    ]);
});

$app->run();
