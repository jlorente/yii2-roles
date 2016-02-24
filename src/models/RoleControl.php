<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\models;

use InvalidArgumentException;

/**
 * RoleControl static class to performs operations with Roleable objects.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class RoleControl {

    /**
     *
     * @var array 
     */
    protected static $roles = [];

    /**
     * Checks if the Roleable contains the role.
     * 
     * @param Roleable $roleable
     * @param int $role
     * @return bool
     */
    public static function check(Roleable $roleable, $role) {
        return ($roleable->getRole() & $role) === $role;
    }

    /**
     * Adds a role to the roleable object.
     * 
     * @param Roleable $roleable
     * @return bool
     */
    public static function add(Roleable $roleable, $role) {
        $roleable->setRole($roleable->getRole() | static::extractRoleValue($roleable, $role));
    }

    /**
     * Ensure the roles cache of the roleable.
     * 
     * @param Roleable $roleable The Roleable object which roles have to be ensured.
     * @param bool $force Forces the cache to be refreshed.
     */
    protected static function ensureRoles(Roleable $roleable, $force = false) {
        if (isset(static::$roles[get_class($roleable)]) === false || $force === true) {
            static::$roles[get_class($roleable)] = array_flip($roleable->getValidRoles());
        }
    }

    /**
     * Extracts the internal role value of the roleable based on its roles collection.
     * 
     * @param Roleable $roleable
     * @param int $role
     * @return int
     * @throws InvalidArgumentException
     */
    protected static function extractRoleValue(Roleable $roleable, $role) {
        static::ensureRoles($roleable);
        if (isset(static::$roles[get_class($roleable)][$role]) === false) {
            throw new InvalidArgumentException('Provided role doen\'t appear in the valid roles list of the Roleable');
        }
        return 1 << static::$roles[get_class($roleable)][$role];
    }

}
