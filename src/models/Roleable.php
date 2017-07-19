<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\models;

/**
 * Interface to be used in those classes that have the role property and can 
 * be manipulated by the RoleControl class.
 * 
 * It is a good practice to set the valid roles values of the Roleable as 
 * constants of the class and then called the method of RoleControl with this 
 * constant values i.e.
 * ```php 
 *  class User extends ActiveRecord implements Roleable {
 *      
 *      //roles
 *      const ROLE_USER = 'user';
 *      const ROLE_ADMIN = 'admin';
 *      const ROLE_SUPERADMIN = 'superadmin';
 * 
 *      public getValidRoles() {
 *          return [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_SUPERADMIN];
 *      }
 *  }
 *  
 *  $user = new User();
 *  RoleControl::add($user, User::ROLE_USER);
 *  RoleControl::add($user, User::ROLE_ADMIN);
 *  RoleControl::check($user, User::ROLE_ADMIN); //true
 *  RoleControl::check($user, User::ROLE_SUPERADMIN); //false
 * ```
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
interface Roleable {

    /**
     * Sets the role value of the roleable object. No validation are needed since they 
     * were done it in the Role object.
     * 
     * @param int $v The role value to be set
     */
    public function setRole($v);

    /**
     * Gets the role value of the roleable object.
     * 
     * @return int The current internal role value
     */
    public function getRole();
}
