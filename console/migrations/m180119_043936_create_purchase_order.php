<?php

use yii\db\Migration;

/**
 * Class m180119_043936_create_purchase_order
 */
class m180119_043936_create_purchase_order extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%purchase_order_mst}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->Null(),
            'vessel' => $this->integer()->Null(),
            'reference_no' => $this->string(100)->Null(),
            'appointment_no' => $this->string(100)->Null(),
            'invoice_no' => $this->string(100)->Null(),
            'attenssion' => $this->integer()->Null(),
            'address' => $this->text()->Null(),
            'invoice' => $this->string(100)->Null(),
            'email_confirmation' => $this->string(100)->Null(),
            'delivery_note' => $this->string(100)->Null(),
            'eta' => $this->date()->Null(),
            'port' => $this->integer()->Null(),
            'payment_terms' => $this->text()->Null(),
            'agent_details' => $this->text()->Null(),
            'status' => $this->smallInteger()->Null()->defaultValue(0),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%purchase_order_mst}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createTable('{{%purchase_order_dtl}}', [
            'id' => $this->primaryKey(),
            'purchase_order_mst_id' => $this->integer()->Null(),
            'material_id' => $this->integer()->Null(),
            'material_code' => $this->string(100)->Null(),
            'material_name' => $this->string(100)->Null(),
            'unit' => $this->integer()->Null(),
            'unit_price' => $this->decimal(10, 2)->Null(),
            'qty' => $this->integer()->Null(),
            'total' => $this->decimal(10, 2)->Null(),
            'tax' => $this->integer()->Null(),
            'tax_amount' => $this->decimal(10, 2)->Null(),
            'sub_total' => $this->decimal(10, 2)->Null(),
            'description' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%purchase_order_dtl}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('purchase_order_mst_id', 'purchase_order_dtl', 'purchase_order_mst_id', $unique = false);
        $this->addForeignKey("purchase_order_mst_id", "purchase_order_dtl", "purchase_order_mst_id", "purchase_order_mst", "id", "RESTRICT", "RESTRICT");

        $this->createTable('{{%purchase_order_addition}}', [
            'id' => $this->primaryKey(),
            'purchase_order_id' => $this->integer()->Null(),
            'label' => $this->string(100)->Null(),
            'value' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%purchase_order_addition}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180119_043936_create_purchase_order cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180119_043936_create_purchase_order cannot be reverted.\n";

      return false;
      }
     */
}
