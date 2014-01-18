<?php
namespace M6Web\Component\HttpKernel;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * SF2 Kernel extension
 */
abstract class Kernel extends BaseKernel
{
    /**
     * Kernel start time
     *
     * @var float
     */
    protected $kstartTime;

    /**
     * {@inheritdoc}
     *
     */
    public function __construct($environment, $debug)
    {
        $this->kstartTime = microtime(true);

        return parent::__construct($environment, $debug);
    }

    /**
     * Get Kernel start time
     *
     * @return float
     */
    public function getKstartTime()
    {
        return $this->kstartTime;
    }

}
