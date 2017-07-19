<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles;

use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

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

/**
 * Module class for the Roles module.
 * 
 * You must add this module to the module section and the bootrap section of 
 * the application config file in order to make it work.
 * 
 * ../your_app/config/main.php
 * ```php
 * return [
 *     //Other configurations
 *     'modules' => [
 *         //Other modules
 *         'roles' => [
 *             'class' => 'jlorente\roles\Module'
 *              //options
 *          ]
 *     ],
 *     'bootstrap' => [
 *         //Other bootstrapped modules
 *         , 'roles'
 *     ]
 * ]
 * 
 * Options of the module
 * [
 *      'user' => 'jlorente\roles\web\User'
 *      , 'roles' => ['Admin', 'User', 'Teacher']
 *      , 'matchAgainstSession' => false
 *  ]
 * 
 * The roles array can contain any scalar values, but they must be unique along 
 * the collection. 
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
 * @see \jlorente\roles\web\User for more detailed options of the web user component.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Module extends BaseModule implements BootstrapInterface {

    /**
     * Options to create the View component.
     * 
     * @var array 
     */
    public $user = 'jlorente\roles\web\User';

    /**
     * Determines the default matchAgainstSession behavior of the AccessRule 
     * objects checking whether to match the roles to the session role data or 
     * to the identity model role data.
     * 
     * @var boolean 
     */
    public $matchAgainstSession = false;
    
    /**
     * Platform available roles.
     * 
     * @var array
     */
    public $roles = [
        'User'
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->setAliases([
            '@rolesModule' => '@vendor/jose_lorente/yii2-roles/src'
        ]);
        $this->user = ArrayHelper::merge([
                    'class' => 'jlorente\roles\web\User'
                        ], is_string($this->user) ? ['class' => $this->user] : $this->user);
    }

    /**
     * @inheritdoc
     * 
     * @param \yii\web\Application $app
     */
    public function bootstrap($app) {
        $app->setComponents([
            'user' => ArrayHelper::merge(isset($app->components['user']) ? $app->components['user'] : [], $this->user)
        ]);
    }

}
