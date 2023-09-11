<?php declare(strict_types=1);

namespace Komrad\Rest\Core;

use Komrad\Rest\Methods\MethodInterface;
use Komrad\Rest\Exceptions\MethodException;
use Komrad\Rest\Exceptions\RequestException;
use Komrad\Rest\Constants\Core as CoreConstants;

class Request
{
    protected $requestVars = [];
    protected $requestBody = [];

    public function __construct(array $requestVars = [])
    {
        if (empty($requestVars)) {
            $this->requestVars = $_REQUEST;
        }
    }

	/**
	 * @return array
	 * @throws RequestException
	 */
    public function getVariables(): array
    {
        return [
			CoreConstants::REQUEST_VARS => $this->getRequestVars(),
			CoreConstants::POST_VARS => $this->getPostVars(),
			CoreConstants::GET_VARS => $this->getGetVars(),
			CoreConstants::BODY_VARS => $this->getBody(true),
        ];
    }

	/**
	 * @param MethodInterface $method
	 * @throws MethodException
	 * @throws RequestException
	 */
    public function pass(MethodInterface $method)
    {
        $methodVars = $method->getNecessaryVariables();
        $vars = $this->getVariables();
        $payload = [];

        foreach ($methodVars as $varType => $methodVar) {
            foreach ($methodVar as $var) {
                if (empty($vars[$varType][$var])) {
                    throw new MethodException('No variables needed for the method');
                }

                $payload[$var] = $vars[$varType][$var];
            }
        }

        $method->setPayload($payload);
    }

    /**
     * @return array
     */
    private function getPostVars(): array
    {
        return $_GET;
    }

    /**
     * @return array
     */
    private function getGetVars(): array
    {
        return $_POST;
    }

    /**
     * @return array
     */
    private function getRequestVars(): array
    {
        return $_REQUEST;
    }

    /**
     * @param bool $blockEmptyBody
     * @return array
     * @throws RequestException
     */
    private function getBody($blockEmptyBody = false): array
    {
        $body = file_get_contents('php://input');
        $this->requestBody = json_decode($body, true) ?? [];
        if (!empty($body) && empty($this->requestBody) && !$blockEmptyBody) {
            throw new RequestException('request body is empty or not a valid json');
        }

        return $this->requestBody;
    }

}