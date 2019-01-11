<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property string $request_id
 * @property string $destination
 * @property string $departure
 * @property string $datetime
 * @property int $from_to
 * @property string $created
 * @property string $user_id__fk
 *
 * @property User $userIdFk
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime', 'created'], 'safe'],
            [['from_to', 'user_id__fk'], 'integer'],
            [['destination', 'departure'], 'string', 'max' => 50],
            [['user_id__fk'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id__fk' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'destination' => 'Destination',
            'departure' => 'Departure',
            'datetime' => 'Datetime',
            'from_to' => 'From To',
            'created' => 'Created',
            'user_id__fk' => 'User Id Fk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserIdFk()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id__fk']);
    }
}
