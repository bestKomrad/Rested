<?php declare(strict_types=1);

namespace Komrad\Rest\Headers;

abstract class AbstractHeader
{
    protected static $headers;

    /**
     * Header constructor.
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->addHeaders($headers);
    }

    /**
     * @param array $headers
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
    }

    /**
     * @param string $header
     */
    public function addHeader(string $header)
    {
        if (!empty($header)) {
            $this->headers[] = $header;
        }
    }

    public static function show()
    {
        foreach (static::$headers as $header) {
            header($header);
        }
    }
}