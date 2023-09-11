<?php


namespace Test\Rest\Methods;

use Komrad\Rest\Constants\Core;
use Komrad\Rest\Methods\AbstractMethod;

class Prints extends AbstractMethod
{

    protected array $necessaryVariables = [
        Core::REQUEST_VARS => [
            'fromDate',
            'toDate'
        ]
    ];

    public function execute(): ?array
    {
        $fromDate = $this->getPayload()['fromDate'];
        $toDate = $this->getPayload()['toDate'];

        exec('echo "from '.$fromDate.' to '.$toDate.'"');
    }
}