<?php

use yii\db\Migration;

/**
 * Class m180108_064223_create_financial_year
 */
class m180108_064223_create_financial_year extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%financial_years}}', [
            'id' => $this->primaryKey(),
            'financial_year' => $this->string(15)->Null(),
            'name' => $this->string(15)->Null(),
            'financial_period' => $this->integer()->Null(),
            'start_period' => $this->string(30)->Null(),
            'end_period' => $this->string(30)->Null(),
            'reference' => $this->string(50)->Null(),
            'error_msg' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%financial_years}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180108_064223_create_financial_year cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180108_064223_create_financial_year cannot be reverted.\n";

      return false;
      }
     */
}
