<?php

use yii\db\Migration;

class m161017_013710_notification_control extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `user_notifications_settings` ( 
                    `id` BIGINT(20) NOT NULL AUTO_INCREMENT , 
                    `user_id` BIGINT(20) NOT NULL , 
                    `email` TINYINT(2) NOT NULL DEFAULT '0' , 
                    `flash` TINYINT(2) NOT NULL DEFAULT '0' , 
                    PRIMARY KEY (`id`), 
                    INDEX `user_id` (`user_id`)
                ) ENGINE = InnoDB;")->execute();
    }

    public function down()
    {
        echo "m161017_013710_notification_control cannot be reverted.\n";

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
