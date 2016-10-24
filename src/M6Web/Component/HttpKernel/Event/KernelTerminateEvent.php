<?php
namespace M6Web\Component\HttpKernel\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evènement surchargeant le kernel.terminate
 */
class KernelTerminateEvent extends Event
{

    private $code;
    private $startTime;

    /**
     * constructeur
     *
     * @param Request $request   request
     * @param int     $code      code
     * @param float   $startTime start time en ms
     */
    public function __construct(Request $request, $code, $startTime)
    {
        $this->request   = $request;
        $this->code      = $code;
        $this->startTime = $startTime;
    }

    /**
     * retourne le statuscode
     * @return int
     */
    public function getStatusCode()
    {
        return $this->code;
    }

    /**
     * retourne le nom de la route passée à l'event
     * @return string
     */
    public function getRouteName()
    {
        if ($this->request->get('_route')) {
            return $this->request->get('_route');
        } else {
            return "undefined";
        }
    }

    /**
     * retourne le nom de la méthode
     *
     * @return string
     */
    public function getMethodName()
    {
        return $this->request->getMethod();
    }

    /**
     *  pour le bundle statsd
     * retourne des millisecondes
     *
     * @return float
     */
    public function getTiming()
    {
        return (microtime(true) - $this->startTime) * 1000;
    }

    /**
     * retourne la memoire consommée
     *
     * @return float
     */
    public function getMemory()
    {
        $mem = memory_get_peak_usage(true);
        if ($mem > 1024) {
            return intval($mem / 1024);
        }

        return 0;
    }

    /**
     * retourne le host
     *
     * @return string
     */
    public function getHost()
    {
        return str_replace('.', '_', $this->request->getHost());
    }
}
