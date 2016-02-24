<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\filters;

use yii\filters\AccessControl as BaseAccessControl;

/**
 * AccessControl class to extend yii AccessControl class with custom behaviors.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccessControl extends BaseAccessControl {

    /**
     * @var array the default configuration of access rules. Individual rule configurations
     * specified via [[rules]] will take precedence when the same property of the rule is configured.
     */
    public $ruleConfig = ['class' => 'jlorente\roles\filters\AccessRule'];

}
