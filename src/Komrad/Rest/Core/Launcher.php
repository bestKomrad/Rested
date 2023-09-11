<?php

namespace Komrad\Rest\Core;

use Exception;
use JsonException;
use Komrad\Rest\Constants\Core as CoreConstants;
use Komrad\Rest\Exceptions\MethodException;
use Komrad\Rest\Headers\JsonHeader;

class Launcher
{
    /**
     * @param string $currentDirectory
     * @throws JsonException
     */
    public static function start(string $currentDirectory = '', string $methodsNamespace = ''): void
    {
		JsonHeader::show();
		try {
            if (empty($currentDirectory)) {
                $currentDirectory = CoreConstants::REST_HOME_URL;
            }

            if (empty($methodsNamespace)) {
                $methodsNamespace = CoreConstants::METHOD_NAMESPACE;
            }

			$currentMethod = (new Watcher($currentDirectory))->setMethodsNamespace($methodsNamespace)->load();

			(new Request())->pass($currentMethod);
			$response = $currentMethod->execute();
			if (!empty($response)) {
                ob_end_clean();
                echo json_encode($response, JSON_THROW_ON_ERROR);
            }
		} catch (Exception  $e) {
			echo json_encode([
                'success' => false,
                'error_message' => $e->getMessage()
            ], JSON_THROW_ON_ERROR);
		}
	}
}