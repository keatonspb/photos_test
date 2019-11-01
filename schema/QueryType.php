<?php

namespace app\schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'photos' => [
                        'type' => Type::listOf(Types::photo()),
                        // добавим фильтров для интереса
                        'args' => [
                            'description' => Type::string(),
                        ],
                        'resolve' => function($root, $args) {
                            $query = \Yii::$app->user->getIdentity()->getPhotos();
                            $query->andFilterWhere(
                                ['LIKE', 'description', "%".$args['description']."%", false]
                            );
                            return $query->all();
                        }
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}
