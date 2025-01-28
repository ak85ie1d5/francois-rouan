<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'chart' => [
        'path' => './assets/chart.js',
        'entrypoint' => true
    ],
    'draggable-collection' => [
        'path' => './assets/draggable-collection.js',
        'entrypoint' => true,
    ],
    'modal-new-location' => [
        'path' => './assets/modal-new-location.js',
        'entrypoint' => true,
    ],
    'umanit-easyadmintree-tree-field' => [
        'path' => './assets/umanit-easyadmintree-tree-field.js',
        'entrypoint' => true,
    ],
    'modal-export-to-csv' => [
        'path' => './assets/modal-export-to-csv.js',
        'entrypoint' => true,
    ],
    'modal-export-to-pdf' => [
        'path' => './assets/modal-export-to-pdf.js',
        'entrypoint' => true,
    ],
    'modal-uncheck-all' => [
        'path' => './assets/modal-uncheck-all.js',
        'entrypoint' => true,
    ],
    'scroll-auto' => [
        'path' => './assets/scroll-auto.js',
        'entrypoint' => true,
    ],
    'selection-multiple' => [
        'path' => './assets/selection-multiple.js',
        'entrypoint' => true,
    ],
];
