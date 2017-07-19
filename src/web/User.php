<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\web;

use yii\web\User as BaseUser;
use jlorente\roles\models\Roleable;

/**
 * Implementation of \yii\web\User for the roles plugin to allow authentication 
 * of user sessions with differents roles.
 * 
 * A user MUST own the role in order to authenticate the session with it.
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends BaseUser implements Roleable {

    use UserTrait;
}
