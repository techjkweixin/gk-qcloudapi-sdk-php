<?php

namespace Gkcosapi\Cospackage\statusException;
class StatusException
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function response($data, $code = null)
    {
        if ($code) $this->setStatusCode($code);
        return response()->json($data, $this->getStatusCode());
    }
}
