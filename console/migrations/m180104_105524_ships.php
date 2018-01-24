<?php

use yii\db\Migration;

/**
 * Class m180104_105524_ships
 */
class m180104_105524_ships extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%ships}}', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(200)->notNull(),
                    'code' => $this->string(15)->notNull(),
                    'registration_number' => $this->string(20)->notNull(),
                    'length' => $this->string(20)->notNull(),
                    'capacity' => $this->string(20)->notNull(),
                    'description' => $this->text()->null(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180104_105524_ships cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_105524_ships cannot be reverted.\n";

          return false;
          }
         */
}
