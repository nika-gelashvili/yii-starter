<?php


namespace frontend\models\search;


use common\models\PostTranslation;
use yii\base\Model;
use yii\db\Exception;

class PostTranslationForm extends Model
{
    /* @var */
    public $postID;
    /* @var */
    public $postTitle;
    /* @var */
    public $postDescription;
    /* @var */
    public $postShortDescription;
    /* @var */
    public $locale;


    public function rules()
    {
        return [
            [['postID', 'postTitle', 'locale'], 'required'],
            [['postID'], 'integer'],
            [['postTitle'], 'string', 'max' => 45],
            [['post_description'], 'string', 'max' => 300],
            [['post_short_description'], 'string', 'max' => 100],
            [['locale'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'postID' => 'Post ID',
            'postTitle' => 'Post Title',
            'postDescription' => 'Post Description',
            'postShortDescription' => 'Post Short Description',
            'locale' => 'Locale',
        ];
    }

    public function savePost()
    {
        if ($this->validate()) {
            $postTranslation = new PostTranslation();
            $postTranslation->post_description = $this->postDescription;
            $postTranslation->post_title = $this->postTitle;
            $postTranslation->post_short_description = $this->postShortDescription;
            $postTranslation->post_id = $this->postID;
            if (!$postTranslation->save()) {
                throw new Exception("Post Couldn't Be saved");
            }
            return $postTranslation;
        }
        return null;
    }
}