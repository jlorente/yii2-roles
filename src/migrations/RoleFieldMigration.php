<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\roles\migrations;

use yii\db\Schema;
use yii\db\Migration;

/**
 * Migration that creates the role field in the provided table name. 
 * 
 * Create a migration in your project, extend the class from this class, 
 * implement the abstract method and the run migrations.
 * 
 * Override the roleFieldName in order to provide another role field name.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
abstract class RoleFieldMigration extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->addColumn($this->roleableTableName(), $this->roleFieldName(), Schema::TYPE_INTEGER);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropColumn($this->roleableTableName(), $this->roleFieldName());
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

    /**
     * Returns the table name where the role field has to be set.
     */
    abstract public function roleableTableName();
}
