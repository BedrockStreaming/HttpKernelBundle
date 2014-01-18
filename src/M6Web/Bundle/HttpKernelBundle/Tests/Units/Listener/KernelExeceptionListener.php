<?php
namespace M6Web\Bundle\HttpKernelBundle\Listener\Tests\Units;

use \mageekguy\atoum;
use M6Web\Bundle\HttpKernelBundle\Listener\KernelExceptionListener as TestedListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use M6Web\Component\HttpKernel\Exception\RedirectException;

/**
 * classe testant le KernelExceptionListener
 */
class KernelExceptionListener extends atoum\test
{

    /**
     * @param string    $type      Type de request
     * @param Request   $request   Request
     * @param Exception $exception Exception
     *
     * @return \mock\Symfony\Component\HttpKernel\Event\GetResponseEvent
     */
    protected function buildMockEvent($type, $request, $exception)
    {
        $kernelInterface = new \mock\Symfony\Component\HttpKernel\HttpKernelInterface();

        $event = new \mock\Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent(
            $kernelInterface,
            $request,
            $type,
            $exception
        );

        return $event;
    }

    /**
     * build mocked request
     *
     * @return \mock\Symfony\Component\HttpFoundation\Request
     */
    protected function buildMockRequest()
    {
        return  new \mock\Symfony\Component\HttpFoundation\Request();
    }

     /**
     * mock EventDispatcher
     *
     * @return \mock\Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected function buildMockEventDispatcher()
    {
        return new \mock\Symfony\Component\EventDispatcher\EventDispatcherInterface;
    }

    /**
     * Test on kernel exception method with a redirect exception
     */
    public function testOnKernelExceptionWithRedirecteException()
    {
        $event = $this->buildMockEvent(HttpKernelInterface::MASTER_REQUEST, $this->buildMockRequest(), new RedirectException('http://test.fr'));

        $listener = new TestedListener($this->buildMockEventDispatcher());

        $this->if($listener->onKernelException($event))
            ->then
            ->object($event->getResponse())
                ->isInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse');
    }

    /**
     * Test on kernel exception method with twig exception and http exception as previous
     */
    public function testOnKernelExceptionWithTwigAndHttpException()
    {
        $exception = new \Twig_Error_Runtime('test', -1, null, new HttpException(404));

        $event = $this->buildMockEvent(HttpKernelInterface::MASTER_REQUEST, $this->buildMockRequest(), $exception);

        $listener = new TestedListener($this->buildMockEventDispatcher());

        $this->if($listener->onKernelException($event))
            ->then
            ->object($event->getException())
                ->isInstanceOf('Symfony\Component\HttpKernel\Exception\HttpException');
    }

    /**
     * Test on kernel exception method with twig exception
     */
    public function testOnKernelExceptionWithTwigException()
    {
        $exception = new \Twig_Error_Runtime('test', -1, null, new \Exception('test'));

        $event = $this->buildMockEvent(HttpKernelInterface::MASTER_REQUEST, $this->buildMockRequest(), $exception);

        $listener = new TestedListener($this->buildMockEventDispatcher());

        $this->if($listener->onKernelException($event))
            ->then
            ->object($event->getException())
                ->isIdenticalTo($exception);
    }
}
