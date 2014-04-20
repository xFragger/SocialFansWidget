<?php

namespace SocialFansWidget\SocialNetworks;

use SocialFansWidget\AbstractSocialNetwork;
use SocialFansWidget\SocialNetworkException;

class Facebook extends AbstractSocialNetwork
{
    const FANTYPE_PROFILE = 'profile';
    const FANTYPE_PAGE = 'page';

    const APIURL = 'https://graph.facebook.com/';
    const PAGEURL = 'https://www.facebook.com/';

    private $data;

    static public function sanitizeName($urlOrName)
    {
        if (preg_match('/(?:https?:\/\/)?(?:(?:www\.)?facebook\.com\/)?([^\/]+)/i', $urlOrName, $matches)) {
            return $matches[1];
        }
        return '';
    }

    protected function getFansWord()
    {
        return __('Fans', 'SocialFansWidget');
    }

    protected function getFanCount()
    {
        $data = $this->getData();
        if (isset($data['likes'])) {
            return $data['likes'];
        }
        return -1;
    }

    protected function getName()
    {
        $data = $this->getData();
        return $data['name'];
    }

    protected function getUsername()
    {
        $data = $this->getData();
        if (isset($this->data['username']) && $this->data['username']) {
            return $data['username'];
        }
        return $data['name'];
    }

    protected function getLink()
    {
        $data = $this->getData();
        return self::PAGEURL . $data['id'];
    }

    private function getData()
    {
        if (!$this->data) {
            $url = self::APIURL . $this->options['id'];
            $result = wp_remote_get($url);
            $body = wp_remote_retrieve_body($result);
            if (!$body) {
                throw new SocialNetworkException(
                    sprintf(
                        __('could not retrieve facebook data: %', 'SocialFansWidget'),
                        $result->get_error_message()
                    )
                );
            }
            $this->data = json_decode($body, true);
            if (isset($this->data['error'])) {
                $this->data = array(
                    'name' => __('Fehler beim laden', 'SocialFansWidget'),
                    'username' => $this->options['id'],
                    'likes' => -2
                );
            }
        }
        return $this->data;
    }
}
