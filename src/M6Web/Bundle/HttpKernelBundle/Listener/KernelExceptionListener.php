<?php
namespace M6Web\Bundle\HttpKernelBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use M6Web\Component\HttpKernel\Event\KernelExceptionEvent;
use M6Web\Component\HttpKernel\Exception\RedirectException;

/**
 * Listener sur kernel.exception pour renvoyer mon event
 */
class KernelExceptionListener
{
    private $dispatcher;

    /**
     * constructueur injectant le dispatch
     * @param object $dispatcher dispatcher
     */
    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

   /**
     * on kernel exception
     * @param GetResponseForExceptionEvent $event evenement
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (method_exists($event, 'getThrowable')) {
            $exception = $event->getThrowable();
        } else {
            $exception = $event->getException();
        }

        // avoid subrequest
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if (method_exists($exception, 'getStatusCode')) {
            $this->dispatcher->dispatch('m6kernel.exception',
                new KernelExceptionEvent($exception->getStatusCode()));
        }

        if ($exception instanceof RedirectException) {
            $response = new RedirectResponse($exception->getUrl(), 301);
            $event->setResponse($response);
        }

        if ($exception instanceof \Twig_Error_Runtime
            && $exception->getPrevious() instanceof HttpException) {

            $event->setException($exception->getPrevious());
        }
    }
}
