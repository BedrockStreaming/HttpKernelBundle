<?php
namespace M6Web\Component\HttpKernel\Exception;

/**
 * evenement surchargeant le kernel.exception de sf2
 */
class RedirectException extends \Exception
{
    /**
     * constructeur
     * @param string $url to redirect to
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * retourne l'url
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
