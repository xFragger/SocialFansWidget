<?php
$defaults = array(
    $networks = array()
);
if (isset($vars) && is_array($vars)) {
    foreach ($defaults as $k => $v) {
        if (!isset($vars[$k]) || empty($vars[$k])) {
            $vars[$k] = $defaults[$k];
        }
    }
}

foreach ($vars['networks'] as $network) {
    ?>
        <div class="SocialFans <?php echo strtolower($network['networkName'])?>">
            <a href="<?php echo $network['url']?>" title="<?php esc_attr_e($network['name'])?>">
                <span>
                    <span class="SocialFansNetwork">
                        <?php echo $network['networkName']?>
                    </span>
                    <br>
                    <span class="SocialFansCount">
                        <?php if ($network['fansCount'] > -1) {
                            esc_html_e($network['fansWord']);
                            echo ': ';
                            esc_html_e($network['fansCount']);
                        } else if ($network['fansCount'] === -1) {
                            esc_html_e('/' . $network['username']);
                        }
                        ?>
                    </span>
                </span>
            </a>
        </div>
    <?php
}
