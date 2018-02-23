<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leave_category".
 *
 * @property int $id
 * @property string $leave_code
 * @property string $leave_name
 * @property int $no_of_days
 * @property int $include_docs
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class LeaveCategory extends \yii\db\ActiveRecord {

        /**
         * {@inheritdoc}
         */
        public static function tableName() {
                return 'leave_category';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
                return [
                        [['no_of_days', 'leave_code', 'leave_name', 'country'], 'required'],
                        [['no_of_days', 'include_docs', 'status', 'CB', 'UB'], 'integer'],
                        [['DOC', 'DOU'], 'safe'],
                        [['leave_code'], 'string', 'max' => 15],
                        [['leave_name'], 'string', 'max' => 50],
                ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'country' => 'Country',
                    'leave_code' => 'Leave Code',
                    'leave_name' => 'Leave Name',
                    'no_of_days' => 'No Of Days',
                    'include_docs' => 'Include Docs',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
