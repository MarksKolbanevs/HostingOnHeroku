<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class UsersFilter extends ApiFilter{
    protected $safeParams = [
        'name' => ['eq'],
        'surname' => ['eq'],
        'phone' => ['eq'],
        'email' => ['eq'],
        'reserveEmail' => ['eq']
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

    public function transform(Request $request){
        $eloQuery = [];

        foreach($this->safeParams as $param => $operators){
            $query = $request->query($param);
            
            if(!isset($query)){
                continue;
            }

            foreach($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[] = [$param, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}