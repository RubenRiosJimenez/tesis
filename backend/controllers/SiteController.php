<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\Tipoconcursante;
use backend\models\TipoconcursanteSearch;
use backend\models\Concursante;
use backend\models\ConcursanteSearch;
use backend\models\Convocatoria;
use backend\models\ConvocatoriaSearch;
use backend\models\Estadoconvocatoria;
use backend\models\EstadoconvocatoriaSearch;
use backend\models\User;
use backend\models\Postulacion;
use backend\models\PostulacionSearch;
use backend\models\ContactForm;
use backend\models\Formulario;
use yii\web\NotFoundHttpException;
use backend\models\TablaitemfinanciamientoSearch;
use backend\models\TablapresupuestoSearch;
use backend\models\TablacartaganttSearch;
use backend\models\AdjuntoSearch;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
 
}
