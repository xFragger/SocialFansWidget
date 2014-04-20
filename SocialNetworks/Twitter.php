<?php


namespace SocialFansWidget\SocialNetworks;


use SocialFansWidget\AbstractSocialNetwork;
use SocialFansWidget\SocialNetworkException;

class Twitter extends AbstractSocialNetwork
{
    const TWITTERURL = 'https://twitter.com/';

    private $data;

    static public function sanitizeName($urlOrName)
    {
        if (preg_match('/(?:https?:\/\/)?(?:(?:www\.)?twitter\.com\/)?([^\/]+)/i', $urlOrName, $matches)) {
            return $matches[1];
        }
        return '';
    }

    protected function getFansWord()
    {
        return __('Follower', 'SocialFansWidget');
    }

    protected function getName()
    {
        return $this->options['id'];
    }

    protected function getLink()
    {
        return self::TWITTERURL . $this->getName();
    }

    protected function getFanCount()
    {
        $data = $this->getData();
        return $data['followers'];
    }

    private function getData()
    {
        if (!$this->data)
        {
            $result = wp_remote_get(self::TWITTERURL . $this->options['id']);
            $body = wp_remote_retrieve_body($result);
            if (!$body) {
                throw new SocialNetworkException(
                    sprintf(
                        __('could not retrieve twitter data: %', 'SocialFansWidget'),
                        $result->get_error_message()
                    )
                );
            }

            $this->data = array();
            if (preg_match_all('/<a class="js-nav" href="\/([^"]+)" data-element-term="[^"]+" data-nav="([^"]+)" .*<strong title="([\d.]+)"/iU', $body, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $this->data[$match[2]] = $match[3];
                    $this->data['link_' . $match[2]] = $match[1];
                }
            }

        }
        return $this->data;
    }
}
