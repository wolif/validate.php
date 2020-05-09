<?php

use Wolif\Validate\Components\Type\Int_;
use Wolif\Validate\Components\Type\String_;
use Wolif\Validate\Result;
use Wolif\Validate\Validator;

require_once "../vendor/autoload.php";


$input = [
    'int'       => 9,
    'int1'      => 8,
    'int2'      => 23,
    'timestamp' => time(),
    'number'    => '1',
    'string'    => '{"a":1}',
    'string1'   => '<div>',
    'email'     => 'abcd',//'xyz@example.com',
    'datetime'  => strtotime(time()),
    'datetime1' => '2020-04-01 12:34:56',
    'datetime2' => '2020-01-23 12:34:56',
    'array'     => [1, 2, 3],
    'object'    => ['a' => 1, 'b' => 2, 'c' => 3],
    'o1'        => [
        'a' => [
            1, 2, 3,
        ],
        'b' => [
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ],
        'c' => [
            'a' => 11,
            'b' => 22,
            'c' => 33,
        ]
        ],
];

$validate_rule = [
    // 'int'   => [
    //     'required', //<=> ['required'],
    //     'int', //<=> ['int'],
    //     ['gte', 1],
    //     ['lte', 10],
    //     ['in', [1,2,3,4,5,6,7,8,9,10]],
    //     ['cmpGt', 'int1']
    // ], // <=>
    'int' => 'required|int|gte:1|lte:10|in:1,2,3,4,5,6,7,8,9,10|cmpGt:int1',
    'int1' => 'required|int',
    'int2' => 'required|int|equal:22',
    'int3' => 'sometimes',
    'email' => 'required|string|format:email',
    'string' => 'required|string|json:a,b',
    'string1' => 'required|string|format:<>',
    'o1.b' => 'required',
];


// $validate_hint = [
//     'int' => [
//         'required' => 'param [int] is necessary',
//         'int'      => 'param [int] must a int value',
//         'gte'      => 'param [int] must >= [value]',
//         'lte'      => 'param [int] must <= [value]',
//         'in'       => 'param [int] value must in [value]',
//         'cmpGt'    => 'param [int] must >= param[value]',
//     ],
// ];

Int_::extends('equal', function ($field, $input, ...$params) {
    list($value) = $params;
    if ($input[$field] == $value) {
        return Result::success();
    }
    return Result::failed("param [{$field}] must = {$value}", 'equal');
});

String_::setFormat('<>', '/\<.*\>/');

Validator::v($input, $validate_rule);

print_r(Validator::lastResults());
