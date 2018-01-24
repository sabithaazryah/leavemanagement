<?php

use yii\db\Migration;

/**
 * Class m180105_110823_appointment
 */
class m180105_110823_appointment extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%appointment}}', [
                    'id' => $this->primaryKey(),
                    'vessel' => $this->integer()->notNull(),
                    'appointment_number' => $this->string(100)->notNull(),
                    'date' => $this->date()->notNull(),
                    'port_of_call' => $this->string(100)->Null(),
                    'terminal' => $this->string(100)->Null(),
                    'berth_number' => $this->string(100)->Null(),
                    'material' => $this->integer()->notNull(),
                    'quantity' => $this->integer()->Null(),
                    'eta' => $this->dateTime()->null(),
                    'description' => $this->text()->null(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->addColumn('{{%appointment}}', 'image', $this->string(100) . 'NULL');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180105_110823_appointment cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180105_110823_appointment cannot be reverted.\n";

          return false;
          }
         */
}
