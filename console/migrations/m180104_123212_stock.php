<?php

use yii\db\Migration;

/**
 * Class m180104_123212_stock
 */
class m180104_123212_stock extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }


                $this->createTable('{{%stock}}', [
                    'id' => $this->primaryKey(),
                    'transaction_type' => $this->integer()->comment('1- Sales, 2 - Sales Return, 3 -Purchase, 4 -Purchase Return , 5 -Stock Addition, 6 - Stock Deduction, 7 -Opening stock'),
                    'transaction_id' => $this->integer()->notNull(),
                    'material_id' => $this->integer()->Null(),
                    'material_code' => $this->string(20)->Null(),
                    'yard_id' => $this->integer()->Null(),
                    'yard_code' => $this->string(20)->Null(),
                    'material_cost' => $this->decimal(10, 2)->null(),
                    'quantity_in' => $this->integer()->Null(),
                    'quantity_out' => $this->integer()->Null(),
                    'weight_in' => $this->integer()->Null(),
                    'weight_out' => $this->integer()->Null(),
                    'total_cost' => $this->decimal(10, 2)->null(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->addForeignKey("fk_stock_material", "stock", "material_id", "materials", "id", "RESTRICT", "RESTRICT");
                $this->addForeignKey("fk_stock_yard", "stock", "yard_id", "yard", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180104_123212_stock cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_123212_stock cannot be reverted.\n";

          return false;
          }
         */
}
