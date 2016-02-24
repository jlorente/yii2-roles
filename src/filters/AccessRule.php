<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\filters;

use yii\filters\AccessRule as BaseAccessRule;
use jlorente\roles\models\RoleControl;
use yii\web\User;

/**
 * AccessRule class to extend yii AccessRule class with custom behaviors.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccessRule extends BaseAccessRule {

    /**
     * @var array list of application roles that this rule applies to.
     * @see Roleable
     *
     * If this property is not set or empty, it means this rule applies to all roles.
     */
    public $userRoles;

    /**
     * @see http://www.yiiframework.com/doc-2.0/yii-filters-accessrule.html#allows()-detail
     * 
     * Extends allows method with user role check
     */
    public function allows($action, $user, $request) {
        if (parent::allows($action, $user, $request) !== null && $this->matchUserRoles($user)) {
            return $this->allow ? true : false;
        }
        return null;
    }

    /**
     * Matches the web User object against the specified platform roles. In 
     * order to this method to function, the identity class must implement the 
     * Roleable interface.
     * 
     * @param User $user
     * @return bool
     */
    public function matchUserRoles(User $user) {
        if (empty($this->userRoles)) {
            return true;
        }
        foreach ($this->userRoles as $role) {
            if (RoleControl::check($user->identity, $role)) {
                return true;
            }
        }
        return false;
    }

}
