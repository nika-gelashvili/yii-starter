<?php


namespace frontend\models;


use common\models\Post;
use yii\base\Model;
use yii\db\Exception;

class PostForm extends Model
{
    /* @var */
    public $userID;
    /* @var */
    public $postImage;

    public function rules()
    {
        return [
            [['userID', 'post_image'], 'required'],
            [['userID'], 'integer'],
            [['postImage'], 'file', 'extensions' => 'png,jpg,gif,jpeg', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'postImage' => 'Thumbnail',
            'file' => 'Thumbnail'
        ];
    }

    public function savePost()
    {
        if ($this->validate()) {
            $post = new Post();
            $fileName = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')) . rand(1, 999);
            $post->user_id = $this->userID;
            $post->post_image = $fileName . '.' . $this->postImage->extension;
            if (!$post->save()) {
                throw new Exception("Post Couldn't Be saved");
            }
            $this->postImage->saveAs('uploads/' . $post->post_image);
            return $post;
        }
    }

}