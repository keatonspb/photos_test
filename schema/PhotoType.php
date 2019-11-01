<?php
namespace app\schema;

use GraphQL\Type\Definition\Type;

class PhotoType extends \GraphQL\Type\Definition\ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'description' => [
                        'type' => Type::string(),
                    ],
                    'filepath' => [
                        'type' => Type::string(),
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}
