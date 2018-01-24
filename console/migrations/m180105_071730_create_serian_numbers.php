<?php

use yii\db\Migration;

/**
 * Class m180105_071730_create_serian_numbers
 */
class m180105_071730_create_serian_numbers extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%serial_numbers}}', [
            'id' => $this->primaryKey(),
            'transaction' => $this->integer()->Null(),
            'prefix' => $this->string(10)->Null(),
            'sequence_no' => $this->integer()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%serial_numbers}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180105_071730_create_serian_numbers cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180105_071730_create_serian_numbers cannot be reverted.\n";

      return false;
      }
     */
}
