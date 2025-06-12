<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        // 'csrf'     => \CodeIgniter\Filters\CSRF::class,
        // 'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        // 'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'cors'     => \App\Filters\Cors::class, // Tambahkan ini
    ];

    public array $globals = [
        'before' => [
            'cors', // Tambahkan ini
            // 'csrf',
        ],
        'after' => [
            // 'toolbar',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
