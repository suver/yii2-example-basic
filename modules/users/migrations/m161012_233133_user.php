<?php

use yii\db\Migration;

class m161012_233133_user extends Migration
{
    public function up()
    {

        $this->db->createCommand("ALTER TABLE `user` CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT NULL, 
                                                    CHANGE `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL;")->execute();

        $this->db->createCommand("ALTER TABLE `user` ADD `description` TEXT NULL DEFAULT NULL AFTER `email`, 
                                                    ADD `about` TEXT NULL DEFAULT NULL AFTER `description`, 
                                                    ADD `first_name` VARCHAR(255) NULL DEFAULT NULL AFTER `about`, 
                                                    ADD `last_name` VARCHAR(255) NULL DEFAULT NULL AFTER `first_name`, 
                                                    ADD `family_name` VARCHAR(255) NULL DEFAULT NULL AFTER `last_name`, 
                                                    ADD `phone` VARCHAR(255) NULL DEFAULT NULL AFTER `family_name`;")->execute();
    }

    public function down()
    {
        echo "m161012_233133_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
