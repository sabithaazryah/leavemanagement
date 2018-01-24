<?php

use yii\db\Migration;

/**
 * Class m180106_143616_create_forgot
 */
class m180106_143616_create_forgot extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%forgot_password_tokens}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->Null(),
            'token' => $this->string(100)->Null(),
            'date' => $this->date(),
                ], $tableOptions);
        $this->alterColumn('{{%forgot_password_tokens}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m180106_143616_create_forgot cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180106_143616_create_forgot cannot be reverted.\n";

      return false;
      }
     */
}
