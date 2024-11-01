<?php

/**
 * File: LogHandlerInterface.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Api\Api;

use Exception;

interface LogHandlerInterface
{
    /**
     * Log error details.
     *
     * @param Exception $exception
     * @return void
     */
    public function logError(Exception $exception): void;
}
