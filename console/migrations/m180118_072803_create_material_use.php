<?php

use yii\db\Migration;

/**
 * Class m180118_072803_create_material_use
 */
class m180118_072803_create_material_use extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%material_use}}', [
                    'id' => $this->primaryKey(),
                    'appointment_id' => $this->integer()->notNull(),
                    'material_id' => $this->integer()->null(),
                    'quantity' => $this->decimal(10, 2)->null(),
                    'sell_date' => $this->date()->null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->addForeignKey("appointment-material_use", "material_use", "appointment_id", "appointment", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180118_072803_create_material_use cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180118_072803_create_material_use cannot be reverted.\n";

          return false;
          }
         */
}
