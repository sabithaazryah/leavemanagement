<?php

use yii\db\Migration;

/**
 * Class m180104_093626_create_employee_uploads
 */
class m180104_093626_create_employee_uploads extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%employee_uploads}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->Null(),
            'upload_category' => $this->integer()->Null(),
            'document_title' => $this->string(100)->Null(),
            'file' => $this->string(100)->Null(),
            'description' => $this->text()->Null(),
            'expiry_date' => $this->date(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%employee_uploads}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180104_093626_create_employee_uploads cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180104_093626_create_employee_uploads cannot be reverted.\n";

      return false;
      }
     */
}
