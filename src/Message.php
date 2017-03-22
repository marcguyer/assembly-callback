<?php

namespace Assembly\Callback;

/**
 * Dummy callback type for "message" type received when registering a
 * new callback
 */
class Message extends Callback
{

    /**
     * Returns the local object since this cannot be validated
     *
     * @return stdClass
     */
    protected function getRemoteObject()
    {
        return $this->getObject();
    }

}
