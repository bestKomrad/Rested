<?php declare(strict_types=1);

namespace Komrad\Rest\Core;

use Komrad\Rest\Exceptions\MethodException;
use Komrad\Rest\Exceptions\WatcherException;
use Komrad\Rest\Methods\MethodInterface;
use Komrad\Rest\Constants\Core as CoreConstants;

class Watcher
{

    protected ?string $methodsNamespace = null;
    protected array $server;
    protected string $homeUrl;

    /**
     * Watcher constructor.
     * @param string $homeUrl
     * @param array $server
     * @throws WatcherException
     */
    public function __construct(string $homeUrl, array $server = [])
    {
        if (empty($homeUrl)) {
            throw new WatcherException('Watcher doesn`t configure');
        }
        $this->homeUrl = $homeUrl;

        if (empty($server)) {
            $this->server = $_SERVER;
        }
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return MethodInterface
     * @throws MethodException
     */
    public function load(): MethodInterface
    {
        $method = $this->getMethod($_SERVER['REQUEST_URI']);
        $requestMethod = $method->getAvailableRequestMethod();
        if (in_array($this->getRequestMethod(), $requestMethod, true)) {
            return $method;
        }

        throw new MethodException('this method does not support this request method');
    }

    /**
     * @param string $currentUrl
     * @return MethodInterface
     * @throws MethodException
     */
    private function getMethod(string $currentUrl = ''): MethodInterface
    {

        if (empty($currentUrl)) {
            $currentUrl = $this->server['SCRIPT_URL'];
        }

        $method = $this->getMethodsNamespace() . $this->parseUrl($currentUrl);

        if (!class_exists($method) || !$method::$publicMethod) {
            throw new MethodException('No methods with that name');
        }

        return new $method();
    }

    /**
     * @param $url
     * @return string
     * @throws MethodException
     */
    protected function parseUrl($url): string
    {
        if ($this->homeUrl === $url) {
            throw new MethodException('No methods');
        }

        $shortUrl = explode($this->homeUrl, $url);
        array_shift($shortUrl);
        $shortUrl = current($shortUrl);

        $shortUrl = explode(CoreConstants::GET_PARAMS_DELIMITER, $shortUrl)[0];
        $methods = explode(CoreConstants::DELIMITER, $shortUrl);
        $methods = array_filter($methods);
        $className = '';
        foreach ($methods as $method) {
            $className .= ucfirst(strtolower($method));
        }

        return $className;
    }

    /**
     * @param string $value
     * @param array $where
     * @return mixed
     * @throws MethodException
     */
    protected function ifExist(string $value, array $where): string
    {
        if (in_array(strtolower($value), $where, true)) {
            return ucfirst(strtolower($value));
        }

        throw new MethodException($value . ' not exist');
    }

    /**
     * @return string|null
     */
    protected function getMethodsNamespace(): ?string
    {
        return $this->methodsNamespace ?? CoreConstants::METHOD_NAMESPACE;
    }

    /**
     * @param string $methodsNamespace
     * @return $this
     */
    public function setMethodsNamespace(string $methodsNamespace): Watcher
    {
        $this->methodsNamespace = $methodsNamespace;

        return $this;
    }
}