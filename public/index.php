<?php

require __DIR__ . '/../vendor/autoload.php';

$config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/../app/config.yml'));

$app = new \Silex\Application($config);

/**
 * register service provider
 */
$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(
    new \Silex\Provider\TwigServiceProvider(),
    [
        'twig.path' =>
            [
                __DIR__ . '/../src/Templates',
                __DIR__.'/../vendor/knplabs/knp-paginator-bundle/Knp/Bundle/PaginatorBundle/Resources/views',
            ],
        'twig.options' => [
            'cache' => __DIR__ . '/../app/cache/app_template',
            'auto_reload' => true
        ]
    ]
);

$app->register(new Dezull\Silex\Provider\DBALPaginatorServiceProvider\DBALPaginatorServiceProvider(),
    [
        /* The following assumes you use the template path as in step #1 */
        'dezull.dbal_paginator.template.pagination' => 'Pagination/twitter_bootstrap_pagination.html.twig',
        'dezull.dbal_paginator.template.sortable' => 'Pagination/sortable_link.html.twig',
    ]
);

$app->register(new \Silex\Provider\FormServiceProvider());
$app->register(new \Silex\Provider\SessionServiceProvider());
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app->register(new \Silex\Provider\HttpFragmentServiceProvider());
$app->register(new \Silex\Provider\ValidatorServiceProvider());
$app->register(
    new \Silex\Provider\MonologServiceProvider(),
    ['monolog.logfile' => __DIR__ . '/../app/logs/development.log']
);
$app->register(new \Silex\Provider\TranslationServiceProvider());

$app->mount('/', new \ExpressLibrary\Controllers\Front($app));
$app->mount('/admin', new \ExpressLibrary\Controllers\Back($app));

$app['db'] = function() {
    return \ExpressLibrary\Db\Db::getInstance();
};

$app['slugify'] = function() {
    return new Cocur\Slugify\Slugify();
};

$app['fs'] = function() {
    return new Symfony\Component\Filesystem\Filesystem();
};

if ($app['debug']) {
    Symfony\Component\Debug\Debug::enable(E_ALL, true);
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), [
        'profiler.cache_dir' => __DIR__ . '/../app/cache/profiler'
    ]);
}

$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new \Symfony\Component\HttpFoundation\Response($message);
});

$app->run();
