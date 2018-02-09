<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_uploads".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $upload_category
 * @property string $document_title
 * @property string $file
 * @property string $description
 * @property string $expiry_date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class EmployeeUploads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_uploads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'upload_category', 'status', 'CB', 'UB'], 'integer'],
            [['description'], 'string'],
            [['expiry_date', 'DOC', 'DOU'], 'safe'],
            [['document_title', 'file'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'upload_category' => 'Upload Category',
            'document_title' => 'Document Title',
            'file' => 'File',
            'description' => 'Description',
            'expiry_date' => 'Expiry Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
