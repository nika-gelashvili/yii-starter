<?php

namespace backend\controllers;

use common\models\Image;
use common\models\Post;
use Yii;
use common\models\PostTranslation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for PostTranslation model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PostTranslation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new PostTranslation();
        $dataProvider = new ActiveDataProvider([
            'query' => PostTranslation::find()
                ->joinWith('post')
                ->where(['locale' => Yii::$app->language]),
        ]);
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PostTranslation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        $postTranslation = PostTranslation::findOne($id);
        $dataProvider = new ActiveDataProvider([
            'query' => PostTranslation::find()
                ->where(['id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ]
        ]);
//        var_dump($this->findModel($id));
//        exit;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PostTranslation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $upload = new Image();
        $post = new Post();
        $postTranslationData = Yii::$app->request->post('PostTranslation');
//        var_dump($postTranslationData);
//        exit;
        if ($post->load(Yii::$app->request->post()) && $upload->load(Yii::$app->request->post())) {

            $filesName = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')) . rand(1, 999);
            $fileName = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')) . rand(1, 999);
            $upload->image = UploadedFile::getInstances($upload, 'image');
            $post->file = UploadedFile::getInstance($post, 'post_image');
            $post->user_id = Yii::$app->user->identity->getId();
            $post->post_image = $fileName . '.' . $post->file->extension;
            if ($post->validate()) {
                if ($post->save()) {
                    $post->file->saveAs(Yii::getAlias('@storage') . '/web/source/upload/' . $post->post_image, false);
                    foreach ($postTranslationData as $data => $value) {
                        $postTranslation = new PostTranslation();

                        $postTranslation->post_title = $value['post_title'];
                        $postTranslation->post_description = $value['post_description'];
                        $postTranslation->post_short_description = $value['post_short_description'];
                        $postTranslation->locale = $value['locale'];
                        $postTranslation->post_id = $post->id;
                        if ($postTranslation->validate()) {
                            if (!$postTranslation->save()) {
                                return var_dump($postTranslation->save());
                            }
                        }
                    }
                    foreach ($upload->image as $image) {
                        $model = new Image();
                        $model->post_id = $post->id;
                        $model->image = $filesName . '.' . $image->extension;
                        if ($model->save(false)) {
                            $image->saveAs(Yii::getAlias('@storage') . '/web/source/upload/' . $model->image, false);
                        }
                    }
                }
                return $this->goHome();
//                return var_dump($post->save());
            }
        }

        return $this->render('create', [
            'upload' => $upload,
            'post' => $post,
            'postTranslation' => new PostTranslation(),
        ]);
    }

    /**
     * Updates an existing PostTranslation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $postTranslation = PostTranslation::find()->where(['post_id' => $id])->indexBy('locale')->all();
        $post = Post::find()->where(['id' => $id])->one();
        $upload = Image::find()->where(['post_id' => $id])->one();
        if (Model::loadMultiple($postTranslation, Yii::$app->request->post()) && Model::validateMultiple($postTranslation)) {
            foreach ($postTranslation as $key => $value) {
                $postTranslation[$key]->save();
            }
            return $this->goHome();
        }

        return $this->render('update', [
            'postTranslation' => $postTranslation,
            'post' => $post,
            'upload' => $upload,
        ]);
    }

    /**
     * Deletes an existing PostTranslation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PostTranslation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}