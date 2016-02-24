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
     * were done in the Role object.
     * 
     * @param $v The role value to be set
     */
    public function setRole($v);

    /**
     * Gets the role value of the roleable object.
     * 
     * @return int The current role value
     */
    public function getRole();

    /**
     * Gets the full collection of possible roles of the roleable.
     * 
     * The array can contain any scalar values, but they must be unique 
     * along the collection. 
     * 
     * This returned values represent your roles values. The internal 
     * values of the Roleable are set depending on the order of the collection 
     * following the rules of a flag field.
     * So [role0, role1, role2, ..., roleN] will become [1, 2, 4, ..., (1 << N)]
     * 
     * You can add new roles at the end of the array and nothing created earlier 
     * will be affected, but be aware that changing the order of the collection 
     * after having used it will cause that previous assigned roles will have now 
     * other values, so don't change the order the roles once set and used.
     * 
     * @return mixed[]
     * @see https://en.wikipedia.org/wiki/Flag_field
     */
    public function getValidRoles();
}
