<?php

namespace app\controllers;

use app\models\base\Count;
use app\models\base\Question;
use app\models\base\Result;
use app\models\base\Template;
use app\models\form\QuizForm;
use app\models\search\QuestionSearch;
use app\models\search\TemplateSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\export\ExportMenu;
/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Template models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionViewQuestions($id){
        $template = $this->findModel($id);

        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->searchByTemplate($this->request->queryParams, $id);
        return $this->render('view-questions', ['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel, 'template'=>$template]);
    }
    public function actionCreateQuestion($template_id)
    {
        $question = new Question();
        $question->template_id = $template_id;

        if ($question->load(Yii::$app->request->post()) && $question->save()) {
            return $this->redirect(['view-questions', 'id' => $template_id]);
        }

        return $this->render('create-question', [
            'model' => $question,
        ]);
    }

    public function actionTakeQuiz($template_id){
        $questions = Question::find()->where(['template_id' => $template_id])->all();
        $template = $this->findModel($template_id);
        $quizForm = new QuizForm();
        $existingResult = Result::find()->where(['user_id' => Yii::$app->user->id, 'template_id' => $template_id])->one();
        if (Yii::$app->request->isPost) {
            if(!$existingResult){
                $quizForm->load(Yii::$app->request->post());
                $quizForm->user_id = Yii::$app->user->id;
                $quizForm->template_id = $template_id;
                $score = $quizForm->checkAnswer();
                $quizForm->save($score);
            }

            return $this->goHome();
        }
        return $this->render('take-quiz', [
            'questions' => $questions,
            'template'=>$template
        ]);
    }
    public function actionIncrementCopyCount($id)
    {
        $id = (int) $id;
        $model = Count::find()->where(['user_id'=>Yii::$app->user->id])->andWhere(['template_id'=>$id])->one();
        if ($model) {
            $model->copy_count += 1;
            $model->save();
        } else {
            $model = new Count();
            $model->user_id = Yii::$app->user->id;
            $model->template_id = $id;
            $model->copy_count = 1;
            if (!$model->save()) {
                // In ra lỗi nếu lưu không thành công
                var_dump($model);
                var_dump($model->getErrors());
                die();
            }
            $model->save();
        }

        return $this->goHome();
    }


    public function actionExport(){
        $searchModdel = new TemplateSearch();
        $dataProvider = $searchModdel->search(Yii::$app->request->queryParams);
        $exporter = new ExportMenu([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'content'
            ],
            'filename'=>'Template-'.date('Y-m-d'),
            'exportConfig' => [
                ExportMenu::FORMAT_EXCEL => ['label' => 'Excel'],
                ExportMenu::FORMAT_CSV => ['label' => 'CSV'],
            ],
        ]);
        $exporterOutput = $exporter->render();
        return $this->render('export', ['exporterOutput' => $exporterOutput]);
    }
}
