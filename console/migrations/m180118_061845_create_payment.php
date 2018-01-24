<?php

use yii\db\Migration;

/**
 * Class m180118_061845_create_payment
 */
class m180118_061845_create_payment extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment_mst}}', [
            'id' => $this->primaryKey(),
            'transaction_type' => $this->integer()->Null()->comment('1-Receipt,2=Payment'),
            'transaction_category' => $this->integer()->Null(),
            'document_no' => $this->string(100)->Null(),
            'document_date' => $this->date()->Null(),
            'supplier' => $this->integer()->Null(),
            'due_amount' => $this->decimal(10, 2)->Null(),
            'paid_amount' => $this->decimal(10, 2)->Null(),
            'payment_mode' => $this->integer()->Null()->comment('1-Cash,2=Cheque'),
            'cheque_no' => $this->string(100)->Null(),
            'cheque_due_date' => $this->date()->Null(),
            'reference' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->Null()->defaultValue(0),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%payment_mst}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createTable('{{%payment_dtl}}', [
            'id' => $this->primaryKey(),
            'payment_mst_id' => $this->integer()->Null(),
            'transaction_id' => $this->integer()->Null(),
            'transaction_category' => $this->integer()->Null(),
            'document_no' => $this->string(100)->Null(),
            'document_date' => $this->date()->Null(),
            'total_amount' => $this->decimal(10, 2)->Null(),
            'due_amount' => $this->decimal(10, 2)->Null(),
            'paid_amount' => $this->decimal(10, 2)->Null(),
            'reference' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%payment_dtl}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('payment_mst_id', 'payment_dtl', 'payment_mst_id', $unique = false);
        $this->addForeignKey("payment_mst_id", "payment_dtl", "payment_mst_id", "payment_mst", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180118_061845_create_payment cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180118_061845_create_payment cannot be reverted.\n";

      return false;
      }
     */
}
