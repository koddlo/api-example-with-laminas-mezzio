<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

return [
    ConfigAggregator::ENABLE_CACHE => true,
    'debug' => false,
    'mezzio' => [
        'error_handler' => [
            'template_404' => 'error::404',
            'template_error' => 'error::error'
        ]
    ]
];
