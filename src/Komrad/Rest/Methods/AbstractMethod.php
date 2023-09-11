<?php declare(strict_types=1);

namespace Komrad\Rest\Methods;

use Komrad\Rest\Constants\Core as CoreConstants;

abstract class AbstractMethod implements MethodInterface
{

    protected array $necessaryVariables = [

    ];

    public static bool $publicMethod = true;

    protected array $availableRequestMethods = [
		CoreConstants::GET,
		CoreConstants::POST
    ];
    protected array $payload;

    /**
     * @return array
     */
    public function getAvailableRequestMethod(): array
    {
        return $this->availableRequestMethods;
    }

    /**
     * @return array
     */
    public function getNecessaryVariables(): array
    {
        return $this->necessaryVariables;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}