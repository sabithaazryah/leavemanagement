<?php

use yii\db\Migration;

/**
 * Class m180105_041535_contact_type
 */
class m180105_041535_contact_type extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%contact_type}}', [
                    'id' => $this->primaryKey(),
                    'type' => $this->string(200)->notNull(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->insert('contact_type', ['id' => '1', 'type' => 'Customer', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('contact_type', ['id' => '2', 'type' => 'Supplier', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('contact_type', ['id' => '3', 'type' => 'Transporter', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->addForeignKey("fk_conatct_contact_type", "contacts", "type", "contact_type", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180105_041535_contact_type cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180105_041535_contact_type cannot be reverted.\n";

          return false;
          }
         */
}
