<?php declare(strict_types=1);


namespace Komrad\Rest\Constants;


class Core
{
    const REST_HOME_URL = '/rest';

    const METHOD_NAMESPACE = 'Komrad\\Rest\\Methods\\';
    const DELIMITER = '/';
    const GET_PARAMS_DELIMITER = '?';

    const REQUEST_VARS = 'request';
    const POST_VARS = 'post';
    const GET_VARS = 'get';
    const BODY_VARS = 'body';

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const OPTIONS = 'OPTIONS';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';
}