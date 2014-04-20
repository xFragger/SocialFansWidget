<?php

namespace SocialFansWidget;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'SocialNetworks/Facebook.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'SocialNetworks/Twitter.php';

abstract class AbstractSocialNetwork
{
    protected $options;

    public function __construct($options = array())
    {
        $this->options = $options;
    }

    final public function toArray()
    {
        return array(
            'networkName' => $this->getNetworkname(),
            'url'         => $this->getLink(),
            'username'    => $this->getUsername(),
            'name'        => $this->getName(),
            'fansCount'   => $this->getFanCount(),
            'fansWord'    => $this->getFansWord(),
            'lastUpdate'  => time()
        );
    }

    protected function getNetworkname()
    {
        $parts = explode('\\', get_class($this));
        return array_pop($parts);
    }

    protected function getUsername()
    {
        return $this->getName();
    }

    abstract protected function getName();
    abstract protected function getLink();
    abstract protected function getFanCount();
    abstract protected function getFansWord();

}
