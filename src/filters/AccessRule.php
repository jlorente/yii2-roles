<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\filters;

use yii\web\User;
use jlorente\roles\Module;
use yii\filters\AccessRule as BaseAccessRule;
use jlorente\roles\models\Role,
    jlorente\roles\models\Roleable;

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
     * Determines whether to match the roles to the session role data or to the 
     * identity model role data.
     * 
     * @var boolean 
     */
    public $matchAgainstSession = null;

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
        $mSession = is_bool($this->matchAgainstSession) ? $this->matchAgainstSession : Module::getInstance()->matchAgainstSession;
        /* @var $roleable Roleable */
        $roleable = $mSession === true ? $user : $user->identity;
        foreach ($this->userRoles as $role) {
            if (Role::sHasRole($roleable, $role) === true) {
                return true;
            }
        }
        return false;
    }

}
