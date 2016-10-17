<?php

use yii\db\Migration;

class m161013_212137_newsFeed extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `news_feed` ( 
                                `id` BIGINT(20) NOT NULL AUTO_INCREMENT , 
                                `slug` VARCHAR(255) NOT NULL , 
                                `title` VARCHAR(255) NOT NULL , 
                                `description` TEXT NULL DEFAULT NULL , 
                                `body` TEXT NULL DEFAULT NULL , 
                                `params` TEXT NULL DEFAULT NULL , 
                                `created_by` BIGINT(20) NOT NULL , 
                                `created_at` TIMESTAMP NULL DEFAULT NULL , 
                                `updated_at` TIMESTAMP NULL DEFAULT NULL , 
                                PRIMARY KEY (`id`), 
                                UNIQUE `slug` (`slug`)
                            ) ENGINE = InnoDB;")->execute();
    }

    public function down()
    {
        echo "m161013_212137_newsFeed cannot be reverted.\n";

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
