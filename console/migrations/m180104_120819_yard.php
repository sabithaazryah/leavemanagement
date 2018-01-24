<?php

use yii\db\Migration;

/**
 * Class m180104_120819_yard
 */
class m180104_120819_yard extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%yard}}', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(200)->notNull(),
                    'code' => $this->string(200)->Null(),
                    'capacity' => $this->string(20)->Null(),
                    'field_1' => $this->string(200)->Null(),
                    'field_2' => $this->string(200)->Null(),
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
                echo "m180104_120819_yard cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_120819_yard cannot be reverted.\n";

          return false;
          }
         */
}
