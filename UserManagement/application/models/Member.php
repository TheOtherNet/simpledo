<?php

/**
 * User Model
 *
 * PHP Version 5
 *
 * @category Controllers
 * @package  LCDV
 * @author   David Francos Cuartero <me@davidfrancos.net>
 * @license  GPL2+ <http://foo.car>
 * @link     http://lcdv.com/
 */
/**
 * User
 *
 * @uses Eloquent
 * @category Controllers
 * @package  LCDV
 * @author   David Francos Cuartero <me@davidfrancos.net>
 * @license  GPL2+ <http://foo.car>
 * @link     http://lcdv.com/
 */
class Member extends Eloquent
{
    public static $hidden = array('password');

     public function logins() {
          return $this->has_many('Logins', 'id_tarjeta');
     }
}
