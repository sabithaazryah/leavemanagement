<?php

use yii\db\Migration;

/**
 * Class m180119_034958_create_cheque_notification
 */
class m180119_034958_create_cheque_notification extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cheque_notification}}', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->integer()->Null(),
            'cheque_no' => $this->string(100)->Null(),
            'cheque_due_date' => $this->date(),
            'cheque_amount' => $this->decimal(10, 2)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%cheque_notification}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180119_034958_create_cheque_notification cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180119_034958_create_cheque_notification cannot be reverted.\n";

      return false;
      }
     */
}
