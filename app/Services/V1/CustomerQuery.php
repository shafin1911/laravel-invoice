<?php

namespace App\Services\V1;


use Illuminate\Http\Request;


class CustomerQuery {
    protected $allowedParams = [
        'postalCode' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
    ];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach($this->allowedParams as $paramKey => $operators) {
            $query = $request->query($paramKey);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$paramKey] ?? $paramKey;

            foreach($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
