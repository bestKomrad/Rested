<?php declare(strict_types=1);

namespace Komrad\Rest\Headers;

class JsonHeader extends AbstractHeader
{
    protected static $headers = ['Content-type:application/json;charset=utf-8'];
}