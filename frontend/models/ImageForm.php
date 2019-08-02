<?php


namespace frontend\models;


use yii\base\Model;

class ImageForm extends Model
{
    /* @var */
    public $postID;
    /* @var */
    public $createdAt;
    /* @var */
    public $image;


    public function rules()
    {
        return [
            [['postID'], 'required'],
            [['postID'], 'integer'],
            [['createdAt'], 'safe'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'postID' => 'Post ID',
            'image' => 'Image',
            'createdAt' => 'Created At',
        ];
    }

}