<?php

use yii\db\Migration;

/**
 * Class m180104_114439_contacts
 */
class m180104_114439_contacts extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%contacts}}', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(200)->notNull(),
                    'code' => $this->string(20)->notNull(),
                    'tax_id' => $this->string(200)->Null(),
                    'type' => $this->integer()->notNull()->comment('1=customer,2=supplier,3=transporter'),
                    'category' => $this->integer()->notNull(),
                    'service' => $this->integer()->notNull(),
                    'phone' => $this->string(150)->notNull(),
                    'email' => $this->string(150)->notNull(),
                    'address' => $this->text()->Null(),
                    'city' => $this->string(150)->Null(),
                    'description' => $this->text()->Null(),
                    'status' => $this->integer()->Null(),
                    'CB' => $this->integer()->Null(),
                    'UB' => $this->integer()->Null(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);

                $this->addForeignKey("fk_contacts_category", "contacts", "category", "supplier_category", "id", "RESTRICT", "RESTRICT");
                $this->addForeignKey("fk_contacts_service", "contacts", "service", "services", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m180104_114439_contacts cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m180104_114439_contacts cannot be reverted.\n";

          return false;
          }
         */
}
