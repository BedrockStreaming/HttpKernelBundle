<?php
namespace M6Web\Bundle\HttpKernelBundle\Listener;

use M6Web\Component\HttpKernel\Event\KernelTerminateEvent;

/**
 * listener sur kernel.terminal
 */
class KernelTerminateListener
{
    protected $dispatcher;
    protected $container;

    /**
     * constructueur injectant le dispatch
     * @param object $dispatcher dispatcher
     * @param object $container  container sf2
     */
    public function __construct($dispatcher, $container)
    {
        $this->dispatcher = $dispatcher;
        $this->container  = $container;
    }

    /**
     * on kernel terminate
     * @param object $event event
     *
     * @return void
     */
    public function onKernelTerminate($event)
    {
        if (method_exists($this->container->get('kernel'), 'getKstartTime')) {
            $startTime = $this->container->get('kernel')->getKstartTime();
        } else {
            $startTime = 0;
        }

        $this->dispatcher->dispatch('m6kernel.terminate',
            new KernelTerminateEvent(
                $event->getRequest(),
                $event->getResponse()->getStatusCode(),
                $startTime
            ));
    }
}
