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
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), $this->roleableRules());
    }

    /**
     * The validation rules for the role field.
     * 
     * @return array
     */
    public function roleableRules() {
        return [
            [$this->roleFieldName(), 'integer']
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
     * Gets the role field name. By default it is "role", override it in order 
     * to provide another role field name.
     * 
     * @return string
     */
    public function roleFieldName() {
        return 'role';
    }

}
