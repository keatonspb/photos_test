<?php
namespace app\controllers\api;

use app\schema\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use yii\helpers\Json;
use yii\rest\ActiveController;

class GraphqlController extends ActiveController
{
    public $modelClass = '';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
        ];
    }

    public function actions()
    {
        return [];
    }

    public function actionIndex()
    {

        $query = \Yii::$app->request->get('query', \Yii::$app->request->post('query'));
        $variables = \Yii::$app->request->get('variables', \Yii::$app->request->post('variables'));
        $operation = \Yii::$app->request->get('operation', \Yii::$app->request->post('operation', null));

        //Raw data
        if (empty($query)) {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variables = isset($input['variables']) ? $input['variables'] : [];
            $operation = isset($input['operation']) ? $input['operation'] : null;
        }

        if (!empty($variables) && !is_array($variables)) {
                $variables = Json::decode($variables);
        }

        $schema = new Schema([
            'query' => Types::query(),
        ]);


        $result = GraphQL::executeQuery(
            $schema,
            $query,
            null,
            null,
            empty($variables) ? null : $variables,
            empty($operation) ? null : $operation
        )->toArray(YII_ENV_DEV);

        return $result;
    }
}
