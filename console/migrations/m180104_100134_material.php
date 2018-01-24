<?php

use yii\db\Migration;

/**
 * Class m180104_100134_material
 */
class m180104_100134_material extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%materials}}', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(100)->notNull(),
                    'code' => $this->string(20)->notNull(),
                    'size' => $this->string(20)->notNull(),
                    'tax' => $this->integer()->notNull(),
                    'unit' => $this->integer()->notNull(),
                    'purchase_price' => $this->decimal(10, 2)->notNull(),
                    'selling_price' => $this->decimal(10, 2)->notNull(),
                    'image' => $this->string(100)->Null(),
                    'description' => $this->text()->null(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);

                $this->addForeignKey("fk_material_tax", "materials", "tax", "tax", "id", "RESTRICT", "RESTRICT");
                $this->addForeignKey("fk_material_unit", "materials", "unit", "units", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180104_100134_material cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_100134_material cannot be reverted.\n";

          return false;
          }
         */
}
