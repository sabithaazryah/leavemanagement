<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "holidays".
 *
 * @property int $id
 * @property string $holiday_name
 * @property string $date
 * @property int $country
 * @property string $description
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
                        [['date', 'country', 'holiday_name', 'description', 'branch'], 'required'],
                        [['date', 'DOC', 'DOU'], 'safe'],
                        [['country', 'status', 'CB', 'UB', 'branch'], 'integer'],
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
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
