Yii2 Roles
==========

A Yii2 extension that includes the concept of roles in the framework. Useful to 
handle user access to controllers actions allowed only for some roles and filter 
database resources.

The role storage design is optimized to use a single database field following 
the data structure of a "bit field" or "flag" that can hold a large number of 
roles and all the possible combinations of them occupying the space of a integer.

## Installation

Include the package as dependency under the composer.json file.

To install, either run

```bash
$ php composer.phar require jlorente/yii2-roles "*"
```

or add

```json
...
    "require": {
        // ... other configurations ...
        "jlorente/yii2-roles": "*"
    }
```

to the ```require``` section of your `composer.json` file and run the following 
commands from your project directory.
```bash
$ composer update
$ ./yii migrate --migrationPath=@vendor/jlorente/yii2-roles/src/migrations
```

### Migration
Apply the package migration
```bash
$ ./yii migrate --migrationPath=@vendor/jlorente/yii2-roles/src/migrations
```
or extend this migration in your project and apply it as usually.

You can override the roleableTableName() and the roleFieldName() methods in 
order to provide another table and field names to hold the role value.

###Module setup
You must add this module to the module section and the bootstrap section of the 
application config file in order to make it work.
  
../your_app/config/main.php
```php
return [
    //Other configurations
    'modules' => [
        //Other modules
        'roles' => [
            'class' => 'jlorente\roles\Module'
             //options
             , 'user' => 'jlorente\roles\web\User'
             , 'roles' => ['Admin', 'User', 'Teacher']
             , 'matchAgainstSession' => false
         ]
    ],
    'bootstrap' => [
        //Other bootstrapped modules
        , 'roles'
    ]
]
```
#### Options

##### user
The user parameter force the application to use the web User class included in 
the module that allows the authentication of user sessions with differents roles. 
That means for example that a user that owns two roles can access the application 
with only one of them active. 

This is useful when you are building an application with frontend and backend 
sections and you don't want to share the login between them.

##### roles
The roles array can contain any scalar values, but they must be unique along the 
collection. 

This returned values represent your roles values. The internal values of the 
Roleable are set depending on the order of the collection following the rules of 
a flag field.
So [role0, role1, role2, ..., roleN] will become [1, 2, 4, ..., (1 << N)]

You can add new roles at the end of the array and nothing created earlier will 
be affected, but be aware that changing the order of the collection after having 
used it will cause that previous assigned roles will have now other values, so 
don't change the order of the roles once set and used.

##### matchAgainstSession
If this param is set to true, you will have to specify the roles that the web 
user will own on login. The access rules of the controller actions will match 
against the roles assigned to the web user instead of the roles of the identity 
model.

## Usage

### The Roleable class

The ActiveRecord class that owns the role attribute (usually table user and class
User) MUST implement the RoleableInterface.

With the package comes a RoleableTrait that can be used in the class that implements 
this interface in order to add a basic implementation of the required methods.

For example:

./common/models/User.php
```php

namespace common\models;

use jlorente\roles\models\RoleableTrait;
use jlorente\roles\models\RoleableInterface;
 
class User extends yii\db\ActiveRecord implements RoleableInterface {
    
    use RoleableTrait;

    //class content...
}
```

#### Assigning roles to the Roleable

You can easyly add roles to a Roleable object using the Role class.

Following the last example
```php
$user = new User();
jlorente\roles\models\Role::sAssign($user, 'Admin');
jlorente\roles\models\Role::sAssign($user, 'User');
$user->save();
```

### Controller access control

You can filter the access to the controller actions by using the AccessControl 
class of the module.

./frontend/controllers/SomeController.php
```php

namespace frontend\controllers;

use yii\helpers\ArrayHelper;
use jlorente\roles\filters\AccessControl;
 
class SomeController extends yii\web\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'actions' => ['create', 'update', 'delete'],
                                'allow' => true,
                                'roles' => ['@'],
                                'userRoles' => ['Admin']
                            ],
                            [
                                'actions' => ['index', 'read'],
                                'allow' => true,
                                'roles' => ['@'],
                                'userRoles' => ['Admin', 'User'],
                                'matchAgainstSession' => true
                            ]
                        ],
                    ]
        ]);
    }
}
```
Specifiying the "userRoles" attribute you can define what roles are allowed to 
access the actions.

As you can see in the above example, yo can override the matchAgainstSession 
attribute defined in the Module class for a single rule.

### Matching the controller access against the session

As told before, setting the matchAgainstSession attribute to true implies that 
the session data must store the logged role. 

This is done by setting the role of the web user just before login it in.

```php
class LoginForm extends Model {

    public $user;
    public $username;
    public $password;
    public $rememberMe = true;

    //Class content....

    public function login() {
        if ($this->validate()) {
            Yii::$app->user->setRolesAsTag('Admin');
            $result = \Yii::$app->user->login($this->user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            return $result;
        } else {
            return false;
        }
    }
}
```
Not setting the role manually will cause the session to be logged with all the 
roles owned by the identity model.

## Further considerations

It is a good practice to define the roles as constants to avoid misspelling the 
roles tags. 

./your_app/config/main.php
```php
define('ROLE_ADMIN', 'Admin');
define('ROLE_DIRECTOR', 'Director');
define('ROLE_USER', 'User');
```

And then use this constants to configure the module, assign roles to users, 
defining access rules, etc... 

## License 
Copyright &copy; 2016 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the MIT license. See LICENSE.txt for details.
