<?php
/*
Plugin Name: my beautiful tubes
Plugin URI: http://gadgets-code.com/my-beautiful-tubes-tutorial
Description: A plugin which allows blogger to embed youtube videos on the post and page and get more views for that video.
Version: 1.8.0
Author: Gadgets-Code.Com
Author URI: http://gadgets-code.com
License: GPLv2
*/

/* Copyright 2013 Gadgets-Code.Com (e-mail : morning131@hotmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, please visit <http://www.gnu.org/licenses/>.

*/

/* Include various files need for this major plugin file */

include_once('my-beautiful-tubes-meta-box-setting.inc.php');
include_once('my-beautiful-tubes-side-widget.inc.php');
include_once('my-beautiful-tubes-displays-content.inc.php');

wp_register_style('myBeautyStyleSheet', plugins_url( 'my-beautiful-tubes-style.css' , __FILE__ ), array(), '3', 'all' );
wp_enqueue_style( 'myBeautyStyleSheet');
?>