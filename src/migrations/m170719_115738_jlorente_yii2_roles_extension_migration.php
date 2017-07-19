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
 * To apply this migration run:
 * ```bash
 * $ ./yii migrate --migrationPath=@app/vendor/jlorente/yii2-roles/src/migrations
 * ```
 * or extend this migration in your project and apply it as usually.
 * 
 * You can override the roleFieldName in order to provide another role field name.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class m170719_115738_jlorente_yii2_roles_extension_migration extends Migration {

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
    public function roleableTableName() {
        return '{{%user}}';
    }
}
