<?php

use yii\db\Migration;

/**
 * Class m180104_114627_ports
 */
class m180104_114627_ports extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%ports}}', [
                    'id' => $this->primaryKey(),
                    'port_name' => $this->string(200)->notNull(),
                    'code' => $this->string(200)->Null(),
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
                echo "m180104_114627_ports cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_114627_ports cannot be reverted.\n";

          return false;
          }
         */
}
