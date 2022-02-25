<?php declare ( strict_types = 1 );

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require __DIR__ . '/functions.php';
$apps = require __DIR__ . '/apps.php';

$css = trim( file_get_contents( __DIR__ . '/header.css' ) );
$style = <<<HTML
<style>
{$css}
</style>
HTML;

$header = get_include_contents( __DIR__ . '/header.php', compact( 'apps' ) );
$header = tidy_html( $header );
$header = $style . "\n" . $header;
file_put_contents( __DIR__ . '/header.html', $header );
