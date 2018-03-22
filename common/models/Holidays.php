<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property int $id
 * @property string $holiday_name
 * @property string $date
 * @property string $country
 * @property string $branch
 * @property string $description
 * @property int $recurring_leave
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Holidays extends \yii\db\ActiveRecord {

        /**
         * {@inheritdoc}
         */
        public static function tableName() {
                return 'holidays';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
                return [
                        [['date', 'DOC', 'DOU', 'country', 'branch'], 'safe'],
                        [['recurring_leave', 'status', 'CB', 'UB'], 'integer'],
                        [['holiday_name'], 'string', 'max' => 100],
                        [['description'], 'string', 'max' => 500],
                ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'holiday_name' => 'Holiday Name',
                    'date' => 'Date',
                    'country' => 'Country',
                    'branch' => 'Branch',
                    'description' => 'Description',
                    'recurring_leave' => 'Recurring Leave',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
