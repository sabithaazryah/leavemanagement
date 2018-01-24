<?php

use yii\db\Migration;

/**
 * Class m180112_035923_create_stock_adjustment
 */
class m180112_035923_create_stock_adjustment extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%stock_adj_mst}}', [
            'id' => $this->primaryKey(),
            'transaction' => $this->integer()->Null()->comment('1-Opening,2=Addition,3=Deduction'),
            'document_no' => $this->string(100)->Null(),
            'document_date' => $this->dateTime()->Null(),
            'location_code' => $this->string(20)->Null(),
            'reference' => $this->text()->Null(),
            'status' => $this->smallInteger()->Null()->defaultValue(0)->comment('0-Open,2=Approved'),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%stock_adj_mst}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createTable('{{%stock_adj_dtl}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->Null(),
            'transaction' => $this->integer()->Null()->comment('1-Opening,2=Addition,3=Deduction'),
            'document_no' => $this->string(100)->Null(),
            'document_date' => $this->dateTime()->Null(),
            'location_code' => $this->string(20)->Null(),
            'material_id' => $this->integer()->Null(),
            'material_code' => $this->string(100)->Null(),
            'material_name' => $this->string(100)->Null(),
            'rate' => $this->decimal(10, 2)->Null(),
            'qty' => $this->integer()->Null(),
            'weight' => $this->decimal(10, 2)->Null(),
            'total_cost' => $this->decimal(10, 2)->Null(),
            'reference' => $this->text()->Null(),
            'status' => $this->smallInteger()->Null()->defaultValue(0)->comment('0-Open,2=Approved'),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%stock_adj_dtl}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('master_id', 'stock_adj_dtl', 'master_id', $unique = false);
        $this->addForeignKey("stock-master_id", "stock_adj_dtl", "master_id", "stock_adj_mst", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180112_035923_create_stock_adjustment cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180112_035923_create_stock_adjustment cannot be reverted.\n";

      return false;
      }
     */
}
