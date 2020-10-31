<?php
/**
 * Redirect module
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file LICENSE.txt
 * It is also available through the world-wide-web at this URL:
 * http://www.boxbilling.com/LICENSE.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@boxbilling.com so we can send you a copy immediately.
 *
 * @copyright Copyright (c) 2010-2012 BoxBilling (http://www.boxbilling.com)
 * @license   http://www.boxbilling.com/LICENSE.txt
 * @version   $Id$
 */
class Box_Mod_Redirect_Controller_Client
{
    public function register(Box_App &$app)
    {
        $api = $app->getApiAdmin();
        $redirects = $api->redirect_get_list();
        foreach($redirects as $redirect) {
            $app->get($redirect['path'],             'do_redirect', array(), get_class($this));
        }
    }

    public function do_redirect(Box_App $app)
    {
        $sql='
            SELECT meta_value
            FROM extension_meta
            WHERE extension = "mod_redirect"
            AND meta_key = :path
            LIMIT 1
        ';
        $target = R::getCell($sql, array('path'=>'/'.$app->uri));
        
        Header( "HTTP/1.1 301 Moved Permanently" ); 
        Header( "Location: ".$target );
        exit;
    }
}