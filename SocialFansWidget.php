<?php
/**
 * Plugin Name: SocialFansWidget
 * Version: 1.0
 * Text Domain: SocialFansWidget
 * Author: Michael Freund <michael@familie-freund.de>
 * Author URI: https://www.facebook.com/MiFreund
 */

/*
  Copyright (C) 2014 Michael Freund

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'SocialNetworkException.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'AbstractSocialNetwork.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'SocialAdapter.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Widget.php';

//Method to prevent scoping issues of fucking global variables
function register()
{
    \SocialFansWidget\Widget::addHooks(__FILE__);
}
register(); //TODO: php-version-check
