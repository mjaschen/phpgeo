<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;

$dir = 'src';

$versions = GitVersionCollection::create($dir)
    ->addFromTags('0.*')
    ->addFromTags('1.*')
    ->addFromTags('2.*')
    ->add('master', 'master branch');

return new Sami(
    dirname(__DIR__) . '/src',
    [
        'title'             => 'phpgeo API',
        'versions'          => $versions,
        'build_dir'         => __DIR__ . '/api/%version%',
        'cache_dir'         => __DIR__ . '/cache/%version%',
        'remote_repository' => new GitHubRemoteRepository('mjaschen/phpgeo', dirname($dir)),
    ]
);
