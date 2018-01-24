<?php

use yii\db\Migration;

/**
 * Class m180106_055450_appointment_details
 */
class m180106_055450_appointment_details extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%appointment_details}}', [
                    'id' => $this->primaryKey(),
                    'appointment_id' => $this->integer()->notNull(),
                    'service_id' => $this->integer()->notNull(),
                    'supplier' => $this->integer()->notNull(),
                    'unit_price' => $this->decimal(10, 2)->Null(),
                    'quantity' => $this->integer()->Null(),
                    'unit' => $this->integer()->null(),
                    'total' => $this->decimal(10, 2)->null(),
                    'tax' => $this->integer()->Null(),
                    'tax_amount' => $this->decimal(10, 2)->null(),
                    'sub_total' => $this->decimal(10, 2)->null(),
                    'description' => $this->text(),
                        ], $tableOptions);

                $this->addForeignKey("fk_appointment_details_service", "appointment_details", "service_id", "services", "id", "RESTRICT", "RESTRICT");
                $this->addForeignKey("fk_appointment_details_appointment", "appointment_details", "appointment_id", "appointment", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180106_055450_appointment_details cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180106_055450_appointment_details cannot be reverted.\n";

          return false;
          }
         */
}
