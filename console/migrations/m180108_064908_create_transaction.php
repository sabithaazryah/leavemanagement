<?php

use yii\db\Migration;

/**
 * Class m180108_064908_create_transaction
 */
class m180108_064908_create_transaction extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'transaction_category' => $this->integer()->Null(),
            'transaction_id' => $this->string(500)->notNull(),
            'transaction_date' => $this->dateTime()->Null(),
            'financial_year' => $this->integer()->Null(),
            'supplier_id' => $this->integer()->Null(),
            'supplier_name' => $this->string(100)->Null(),
            'supplier_code' => $this->string(100)->Null(),
            'credit_amount' => $this->decimal(10, 2)->null(),
            'debit_amount' => $this->decimal(10, 2)->null(),
            'balance_amount' => $this->decimal(10, 2)->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);

        $this->addForeignKey("fk_transaction_category", "transaction", "transaction_category", "transaction_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("fk_financial_year", "transaction", "financial_year", "financial_years", "id", "RESTRICT", "RESTRICT");
         $this->addColumn('daily_entry', 'type', 'int');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180108_064908_create_transaction cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180108_064908_create_transaction cannot be reverted.\n";

      return false;
      }
     */
}
