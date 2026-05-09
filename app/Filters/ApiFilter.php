<?php

namespace App\Filters;


use Illuminate\Http\Request;


class ApiFilter {
    protected $allowedParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

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
