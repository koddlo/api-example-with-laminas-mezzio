<?php

declare(strict_types=1);

use Mezzio\Cors\Configuration\ConfigurationInterface;

return [
    ConfigurationInterface::CONFIGURATION_IDENTIFIER => [
        'allowed_headers' => ['Authorization'],
        'allowed_max_age' => '3600',
        'credentials_allowed' => true,
        'exposed_headers' => []
    ],
];
