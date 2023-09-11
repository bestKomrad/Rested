<?php declare(strict_types=1);

namespace Komrad\Rest\Methods;

interface MethodInterface
{
    public function execute(): ?array;
    public function getAvailableRequestMethod(): array;
    public function getNecessaryVariables(): array;
    public function getPayload(): array;
    public function setPayload(array $payload);
}