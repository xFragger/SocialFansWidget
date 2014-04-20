<?php


namespace SocialFansWidget;


use SocialFansWidget\SocialNetworks\Facebook;

class SocialAdapter
{
    const UPDATEINTERVAL = 3600;

    private static $instance;

    private static $possibleNetworks = array(
        'facebookpagename'    => array('class' => 'Facebook', 'opts' => array('fantype' => Facebook::FANTYPE_PAGE)),
        'facebookprofilename' => array('class' => 'Facebook', 'opts' => array('fantype' => Facebook::FANTYPE_PROFILE)),
        'twittername'         => array('class' => 'Twitter', 'opts' => array())
    );

    protected function __construct() {

    }

    /**
     * @return SocialAdapter
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getNetworkData($instance)
    {
        $output = array();

        foreach (self::$possibleNetworks as $field => $data) {
            $id = isset($instance[$field]) ? $instance[$field] : null;
            if ($id) {
                $output[] = $this->getNetworkDataFor($data['class'], $id, $data['opts']);
            }
        }

        return $output;
    }

    private function getNetworkDataFor($class, $id, $options)
    {
        $options['id'] = $id;
        $className = 'SocialFansWidget\\SocialNetworks\\' . $class;

        $cacheKey = 'SocalFansWidget|' . md5($className . '|' . serialize($options));
        $cacheResult = get_option($cacheKey);
        if ($cacheResult) {
            if ($cacheResult['lastUpdate'] + self::UPDATEINTERVAL < time()) {
                delete_option($cacheKey); //next one should fetch new data //TODO: async fetch!
            }
            return $cacheResult;
        }

        /** @var \SocialFansWidget\AbstractSocialNetwork $instance */
        $instance = new $className($options);

        $result =  $instance->toArray();
        add_option($cacheKey, $result, '', true);
        return $result;
    }
} 
