<?php


namespace SocialFansWidget;


use SocialFansWidget\SocialNetworks\Facebook;
use SocialFansWidget\SocialNetworks\Twitter;

class Widget extends \WP_Widget
{
    /** @var \SocialFansWidget\SocialAdapter  */
    private $social;

    public function __construct()
    {
        $this->social = SocialAdapter::getInstance();

        parent::__construct(
            'SocialFansWidget',
            __('SocialFans', 'SocialFansWidget'),
            array(
                'description' => __('Widget to show the actual number of fans/likes for different social networks and link to the profiles/pages', 'SocialFansWidget')
            )
        );
    }

    public static function addHooks($file)
    {
        add_action('widgets_init', function () {
            register_widget(__CLASS__);
        });
        add_action('wp_enqueue_scripts', function () use ($file) {
            wp_enqueue_style('SocialFansWidget', plugins_url('Style/SocialFansWidget.css', $file));
        });
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        $vars = array(
            'networks' => $this->social->getNetworkData($instance)
        );

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo $args['before_widget'];
        include __DIR__ . DIRECTORY_SEPARATOR . 'Templates/widget.tpl.php';
        echo $args['after_widget'];
    }



    public function form($instance) {
        $defaults = array(
            'title' => '',
            'facebookpagename' => '',
            'facebookprofilename' => '',
            'twittername' => ''
        );

        $vars = $this->getFormVars($instance, $defaults);

        include __DIR__ . DIRECTORY_SEPARATOR . 'Templates/form.tpl.php';
    }

    public function update($new_instance, $old_instance) {
        return array(
            'title' => !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '',
            'facebookpagename' => !empty($new_instance['facebookpagename'])
                    ? Facebook::sanitizeName($new_instance['facebookpagename']) : '',
            'facebookprofilename' => !empty($new_instance['facebookprofilename'])
                    ? Facebook::sanitizeName($new_instance['facebookprofilename']) : '',
            'twittername' => !empty($new_instance['twittername'])
                    ? Twitter::sanitizeName($new_instance['twittername']) : '',
        );

    }

    private function getFormVars($instance, $defaults) {
        $vars = array();
        foreach ($defaults as $k => $v) {
            $vars[$k] = isset($instance[$k]) ? $instance[$k] : $v;
        }
        return $vars;
    }
}
