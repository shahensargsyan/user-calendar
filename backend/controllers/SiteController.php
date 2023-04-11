<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($selectedMonth = null)
    {
        $months = $data = array();

        if (is_null($selectedMonth)) {
            $selectedMonth = Carbon::today()->shortMonthName;
        }

        for ($i = 0; $i <= 11; $i++) {
            $start = Carbon::today()->startOfMonth()->addMonth($i);
            $end = Carbon::today()->endOfMonth()->addMonth($i);
            $data[$start->shortMonthName] = array(
                'month' => $start->shortMonthName,
                'year' => $start->format('Y'),
                'days' => []
            );

            #create month select data
            $months[$start->shortMonthName] =  [
                'name' => $start->format("F/Y"),
                'url' =>  Url::to(['site/index', 'selectedMonth' => $start->shortMonthName])
            ];

            #if not selected month don't continue
            if ($selectedMonth !== $start->shortMonthName) {
                continue;
            }

            #get selected month weekends
            $interval = DateInterval::createFromDateString('1 day');
            $period   = new DatePeriod($start, $interval, $end);
            foreach ($period as $date) {
                if (in_array($date->format('D'),['Sun', 'Sat'])) {
                    $data[$start->shortMonthName]['days'][] = [
                        'date' => $date->format('D d-m'),
                        'day' => $date->format('D'),
                        'header' => $date->format('D Y-m-d'),
                    ];
                }
            }
        }

        return $this->render('index', [
            'users' => $this->getUsers(),
            'data' => $data,
            'months' => $months,
            'selectedMonth' => $selectedMonth,
        ]);
    }

    #get users except admins
    private function getUsers(): array
    {
        $admins = Yii::$app->authManager->getUserIdsByRole('admin');
        return  (new \yii\db\Query())
            ->select(['id', 'email', 'username'])
            ->from('user')
            ->where(['NOT IN','id',$admins])
            ->all();
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
