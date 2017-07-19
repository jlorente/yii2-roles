<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\models;

use jlorente\roles\Module;
use InvalidArgumentException;

/**
 * Role class to performs operations with Roleable objects.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Role {

    /**
     *
     * @var array 
     */
    protected static $roles = [];

    /**
     *
     * @var int
     */
    protected $role;

    /**
     * Constructs a role object.
     * 
     * @param mixed $role
     */
    public function __construct($role) {
        $this->role = $role;
    }

    /**
     * @see static::sHasRole(Roleable $roleable, $role)
     * @param Roleable $roleable
     * @return boolean
     */
    public function hasRole(Roleable $roleable) {
        return static::sHasRole($roleable, $this->role);
    }

    /**
     * @see static::sAssing(Roleable $roleable, $role)
     * @param Roleable $roleable
     */
    public function assign(Roleable $roleable) {
        static::sAssign($roleable, $this->role);
    }

    /**
     * Checks if the Roleable contains the role.
     * 
     * @param Roleable $roleable
     * @param mixed $role
     * @return bool
     */
    public static function sHasRole(Roleable $roleable, $role) {
        $r = static::extractRoleValue($role);
        return ($roleable->getRole() & $r) === $r;
    }

    /**
     * Assigns the role to the provided Roleable object.
     * 
     * @param Roleable $roleable
     * @param mixed $role
     */
    public static function sAssign(Roleable $roleable, $role) {
        $r = static::extractRoleValue($role);
        $roleable->setRole($roleable->getRole() | $r);
    }

    /**
     * Gets the roles of the provided roleable.
     * 
     * @param Roleable $roleable
     * @return mixed[]
     */
    public static function getRoles(Roleable $roleable) {
        static::ensureRoles();
        $roles = [];
        $rRole = $roleable->getRole();
        foreach (static::$roles as $role => $value) {
            $r = 1 << $value;
            if (($rRole & $r) === $r) {
                $roles[] = $role;
            }
        }
        return $roles;
    }
    
    /**
     * Gets the internal value for the given roles.
     * 
     * @param mixed $roles An scalar value for only one role or an array of the 
     * provided roles.
     */
    public static function getValue($roles) {
        $aRoles = is_scalar($roles) ? [$roles] : $roles;
        static::ensureRoles();
        $value = 0;
        foreach ($aRoles as $role) {
            $value |= (1 << static::$roles[$role]);
        }
        return $value;
    }
    
    /**
     * Ensure the roles cache of the roleable.
     * 
     * @param Roleable $roleable The Roleable object which roles have to be ensured.
     * @param bool $force Forces the cache to be refreshed.
     */
    protected static function ensureRoles($force = false) {
        if (empty(static::$roles) === true || $force === true) {
            static::$roles = array_flip(Module::getInstance()->roles);
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
    protected static function extractRoleValue($role) {
        static::ensureRoles();
        if (isset(static::$roles[$role]) === false) {
            throw new InvalidArgumentException('Provided role doesn\'t appear in the valid roles list of the Roles Module');
        }
        return 1 << static::$roles[$role];
    }

}
