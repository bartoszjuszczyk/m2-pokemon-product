<?php

/**
 * File: LogHandler.php
 *
 * @author Bartosz Juszczyk <b.juszczyk@bjuszczyk.pl>
 * @copyright Copyright (c) 2024.
 **/

declare(strict_types=1);

namespace Juszczyk\PokemonProduct\Model\Api;

use Exception;
use Juszczyk\PokemonProduct\Api\Api\LogHandlerInterface;
use Psr\Log\LoggerInterface;

class LogHandler implements LogHandlerInterface
{
    /**
     * LogHandler class constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(protected readonly LoggerInterface $logger)
    {
    }

    /**
     * @inheritDoc
     */
    public function logError(Exception $exception): void
    {
        $this->logger->error("### POKEMON API START ###");
        $this->logger->error($exception->getMessage());
        $this->logger->error($exception->getTraceAsString());
        $this->logger->error("### POKEMON API END ###");
    }
}
