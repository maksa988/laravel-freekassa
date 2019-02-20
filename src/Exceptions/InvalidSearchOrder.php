<?php

namespace Maksa988\FreeKassa\Exceptions;

use Throwable;

class InvalidSearchOrder extends \Exception
{
    /**
     * InvalidSearchOrder constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, $previous = null)
    {
        if (empty($message)) {
            $message = 'FreeKassa config: searchOrder callback not set';
        }

        parent::__construct($message, $code, $previous);
    }
}
