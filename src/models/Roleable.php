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
