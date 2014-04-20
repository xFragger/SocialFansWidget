<?php

    $fields = array(
        'title' => __('Title:'),
        'facebookpagename' => __('Facebook Page (https://www.facebook.com/name or name):', 'SocialFansWidget'),
        'facebookprofilename' => __('Facebook Profile (https://www.facebook.com/name or name):', 'SocialFansWidget'),
        'twittername' => __('Twitter Profile (https://www.twitter.com/name or name):', 'SocialFansWidget')
    );

    $ids = array();
    $names = array();

    if (isset($vars) && is_array($vars)) {
        foreach ($defaults as $k => $v) {
            if (!isset($vars[$k]) || !trim($vars[$k])) {
                $vars[$k] = $defaults[$k];
            }
        }
    }

    foreach ($fields as $field => $void) {
        $ids[$field]   = $this->get_field_id($field);
        $names[$field] = $this->get_field_name($field);
        if (isset($vars) && !isset($vars[$field])) {
            $vars[$field] = '';
        }
    }

    foreach ($fields as $field => $title) {
        ?>
        <p>
            <label for="<?php echo $ids[$field] ?>"><?php echo $title; ?></label>
            <input class="widefat" id="<?php echo $ids[$field]; ?>" name="<?php echo $names[$field] ?>" type="text" value="<?php esc_attr_e($vars[$field]); ?>">
        </p>
        <?php
    }
?>
