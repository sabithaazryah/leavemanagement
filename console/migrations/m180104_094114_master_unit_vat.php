<?php

use yii\db\Migration;

/**
 * Class m180104_094114_master_unit_vat
 */
class m180104_094114_master_unit_vat extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%units}}', [
                    'id' => $this->primaryKey(),
                    'unit_name' => $this->string(100)->Null(),
                    'unit_symbol' => $this->string(100)->Null(),
                    'status' => $this->smallInteger()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);

                $this->createTable('{{%tax}}', [
                    'id' => $this->primaryKey(),
                    'tax' => $this->string(100)->Null(),
                    'value' => $this->string(100)->Null(),
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
                echo "m180104_094114_master_unit_vat cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_094114_master_unit_vat cannot be reverted.\n";

          return false;
          }
         */
}
