<?php

use App\Commands\MainMenu\Cancel;
use App\Services\Translation;

$service = new Translation();

return [
    $service->get('main_menu') => Cancel::class,
    $service->get('next') => \App\Commands\MainMenu\Order\WhenNeeded::class,
    $service->get('order_pickup_address') => \App\Commands\MainMenu\Order\Address::class,
];
