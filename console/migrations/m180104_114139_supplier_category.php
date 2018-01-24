<?php

use yii\db\Migration;

/**
 * Class m180104_114139_supplier_category
 */
class m180104_114139_supplier_category extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%supplier_category}}', [
                    'id' => $this->primaryKey(),
                    'category_name' => $this->string(200)->notNull(),
                    'category_code' => $this->string(100)->Null(),
                    'status' => $this->smallInteger()->Null(),
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
                echo "m180104_114139_supplier_category cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_114139_supplier_category cannot be reverted.\n";

          return false;
          }
         */
}
