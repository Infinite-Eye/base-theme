<?php

// Load composer
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    die('Need to run composer install');
}
require_once $autoload;


add_action('wp_enqueue_scripts', function () {
    $asset = include get_parent_theme_file_path('public/css/main.asset.php');

    wp_enqueue_style(
        'theme-style',
        get_parent_theme_file_uri('public/css/main.css'),
        $asset['dependencies'],
        $asset['version']
    );
});

add_action('enqueue_block_editor_assets', function () {
    $script_asset = include get_parent_theme_file_path('public/js/editor.asset.php');
    $style_asset  = include get_parent_theme_file_path('public/css/editor.asset.php');

    wp_enqueue_script(
        'theme-editor',
        get_parent_theme_file_uri('public/js/editor.js'),
        $script_asset['dependencies'],
        $script_asset['version'],
        true
    );

    wp_enqueue_style(
        'theme-editor',
        get_parent_theme_file_uri('public/css/editor.css'),
        $style_asset['dependencies'],
        $style_asset['version']
    );
});
