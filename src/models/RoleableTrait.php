<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\models;

/**
 * Trait that provides the common methods of a Roleable object. Has to be used 
 * in a object that implements the Roleable interface.
 * 
 * Override the roleFieldName in order to provide your custom role field name.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait RoleableTrait {

    /**
     * Return the rules of the role property. Merge this array with the rest of 
     * the rules.
     * 
     * ```php
     *  class User extends ActiveRecord implements Roleable {
     *      
     *      use RoleableTrait;
     *      
     *      public function rules() {
     *          return array_merge([
     *              //Other rules
     *          ], $this->roleRules());
     *      }
     *  }
     * ```
     * @return array
     */
    public function roleRules() {
        return [
            [$this->roleFieldName(), 'integer', 'min' => 1, 'max' => (1 << $this->rolesCount()) - 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function setRole($v) {
        $this->{$this->roleFieldName()} = $v;
    }

    /**
     * @inheritdoc
     */
    public function getRole() {
        return $this->{$this->roleFieldName()};
    }

    /**
     * Adds a role to the object.
     * 
     * @param mixed $v The role to add.
     */
    public function addRole($v) {
        RoleControl::add($this, $v);
    }

    /**
     * Checks if the object has the rol.
     * 
     * @param mixed $v The role to check.
     */
    public function hasRole($v) {
        RoleControl::check($this, $v);
    }

    /**
     * Get the number of roles of the Roleable object.
     * 
     * @return int
     */
    public function rolesCount() {
        return count($this->getValidRoles());
    }

    /**
     * Gets the role field name. By default it is "role", override it in order 
     * to provide another role field name.
     * 
     * @return string
     */
    public function roleFieldName() {
        return 'role';
    }

}
