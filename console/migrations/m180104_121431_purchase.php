<?php

use yii\db\Migration;

/**
 * Class m180104_121431_purchase
 */
class m180104_121431_purchase extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%daily_entry}}', [
            'id' => $this->primaryKey(),
            'received_date' => $this->dateTime()->notNull(),
            'material' => $this->integer()->notNull(),
            'supplier' => $this->integer()->notNull(),
            'transport' => $this->integer()->notNull(),
            'payment_status' => $this->integer()->notNull(),
            'yard_id' => $this->integer()->notNull(),
            'image' => $this->string(20)->null(),
            'status' => $this->integer()->Null(),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);

        $this->addForeignKey("fk_purchase_material", "daily_entry", "material", "materials", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("fk_purchase_supplier", "daily_entry", "supplier", "contacts", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("fk_purchase_transport", "daily_entry", "transport", "contacts", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("fk_purchase_yard", "daily_entry", "yard_id", "yard", "id", "RESTRICT", "RESTRICT");
       


        /************daily entry details************* */
        $this->createTable('{{%daily_entry_details}}', [
            'id' => $this->primaryKey(),
            'daily_entry_id' => $this->integer()->notNull(),
            'ticket_no' => $this->string(20)->notNull(),
            'truck_number' => $this->string()->notNull(),
            'gross_weight' => $this->string()->notNull(),
            'tare_weight' => $this->string()->notNull(),
            'net_weight' => $this->string()->notNull(),
            'rate' => $this->decimal(10, 2)->notNull(),
            'total' => $this->decimal(10, 2)->notNull(),
            'description' => $this->text()->null(),
            'transport_amount' => $this->decimal(10, 2)->notNull(),
            'status' => $this->integer()->Null(),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);

        $this->addForeignKey("fk_daily_entry_id", "daily_entry_details", "daily_entry_id", "daily_entry", "id", "RESTRICT", "RESTRICT");
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180104_121431_purchase cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180104_121431_purchase cannot be reverted.\n";

      return false;
      }
     */
}
