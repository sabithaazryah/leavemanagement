<?php

use yii\db\Migration;

/**
 * Class m180104_071104_create_admin_post
 */
class m180104_071104_create_admin_post extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%admin_post}}', [
                    'id' => $this->primaryKey(),
                    'post_name' => $this->string(100)->Null(),
                    'admin' => $this->smallInteger()->Null()->defaultValue(0),
                    'masters' => $this->smallInteger()->Null()->defaultValue(0),
                    'daily_entry' => $this->smallInteger()->Null()->defaultValue(0),
                    'appointement' => $this->smallInteger()->Null()->defaultValue(0),
                    'stock' => $this->smallInteger()->Null()->defaultValue(0),
                    'reports' => $this->smallInteger()->Null()->defaultValue(0),
                    'status' => $this->smallInteger()->Null()->defaultValue(0),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->alterColumn('{{%admin_post}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

                $this->createTable('{{%employee}}', [
                    'id' => $this->primaryKey(),
                    'post_id' => $this->integer()->notNull(),
                    'user_name' => $this->string(30)->notNull(),
                    'password' => $this->string(300)->notNull(),
                    'name' => $this->string(100),
                    'email' => $this->string(100),
                    'phone' => $this->string(15),
                    'photo' => $this->string(100)->Null(),
                    'address' => $this->text(),
                    'status' => $this->smallInteger()->notNull()->defaultValue(0),
                    'CB' => $this->integer()->notNull(),
                    'UB' => $this->integer()->notNull(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->alterColumn('{{%employee}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

                $this->createIndex('post_id', 'employee', 'post_id', $unique = false);
                $this->addForeignKey("", "employee", "post_id", "admin_post", "id", "RESTRICT", "RESTRICT");
                $this->insert('admin_post', ['id' => '1', 'post_name' => 'super_admin', 'admin' => 1, 'masters' => 1, 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('employee', ['id' => '1', 'post_id' => 1, 'user_name' => 'testing', 'password' => '$2y$13$RS.hkV5A0BeKtCGGzql6yO7lZ2MblwFkNxxixzsf3NbuZwFphLhyi', 'name' => 'testing', 'email' => 'test@test.com', 'phone' => '', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180104_071104_create_admin_post cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_071104_create_admin_post cannot be reverted.\n";

          return false;
          }
         */
}
