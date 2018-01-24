<?php

use yii\db\Migration;

/**
 * Class m180109_110336_create_bank_details
 */
class m180109_110336_create_bank_details extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%bank_details}}', [
            'id' => $this->primaryKey(),
            'account_name' => $this->string(100)->Null(),
            'account_no' => $this->string(100)->Null(),
            'bank_name' => $this->string(100)->Null(),
            'branch' => $this->string(100)->Null(),
            'iban_no' => $this->string(100)->Null(),
            'swift_code' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%bank_details}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180109_110336_create_bank_details cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180109_110336_create_bank_details cannot be reverted.\n";

      return false;
      }
     */
}
