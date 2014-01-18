<?php
namespace M6Web\Component\HttpKernel\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * evenement surchargeant le kernel.exception de sf2
 */
class KernelExceptionEvent extends Event
{
    private $code;

    /**
     * constructeur
     * @param int $code code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * retourne le statuscode
     * @return int
     */
    public function getStatusCode()
    {
        return $this->code;
    }
}
