<?php

use Validator;

trait FilterPaginateOrder
{

    protected $paginator = [

        'column',
        'direction',
        'per_page',
        'search_operator',
        'search_column',
        'search_query_1',
        'search_query_2',

    ];

    protected $operators = [

        'equal_to'                  => '=',
        'not_equal'                 => '<>',
        'less_than'                 => '<',
        'greater_than'              => '>',
        'less_than_or_equal_to'     => '<=',
        'greater_than_or_equal_to'  => '>=',
        'in'                        => 'IN',
        'not_in'                    => 'NOT_IN',
        'like'                      => 'LIKE',
        'between'                   => 'BETWEEN',

    ];

    public function scopeFilterPaginateOrder($query)
    {

        $request = [];
        for ($i = 0; $i < count(getter('request')); $i++) {
            $request += [decode_key(getter('request'), $i) => base_paginate_value(getter('request'), $i)];
        }

        $v = Validator::make($request, [
            $this->paginator[0] => 'required|in:' . implode(',', $this->filter),
            $this->paginator[1] => 'required|in:asc,desc',
            $this->paginator[2] => 'required|integer|min:1',
            $this->paginator[3] => 'required|in:' . implode(',', array_keys($this->operators)),
            $this->paginator[4] => 'required|in:' . implode(',', $this->filter),
            $this->paginator[5] => 'max:255',
            $this->paginator[6] => 'max:255',
        ]);

        if ($v->fails()) {
            dd($v->messages());
            return 'error';
        }

        return $query->orderBy($request['column'], $request['direction'])
            ->where(function ($query) use ($request) {
                //echo $request;
                // check if search query is empty
                if (!empty($request['search_query_1'])) {
                    // determine the type of search_column
                    // check if its related model, eg: customer.id
                    if ($this->isRelatedColumn($request)) {
                        list($relation, $relatedColumn) = explode('.', $request['search_column']);
                        return $query->whereHas($relation, function ($query) use ($relatedColumn, $request) {
                            return $this->buildQuery(
                                $relatedColumn,
                                $request['search_operator'],
                                $request,
                                $query
                            );
                        });
                    } else {
                        // regular column
                        return $this->buildQuery(
                            $request['search_column'],
                            $request['search_operator'],
                            $request,
                            $query
                        );
                    }
                }
            })
            ->paginate($request['per_page']);

    }

    public function scopeGameMisc($query){

        $request = [];
        for ($i = 0; $i < count(getter('request')); $i++) {
            $request += [decode_key(getter('request'), $i) => base_paginate_value(getter('request'), $i)];
        }

        // return $query->whereMode($request['misc']);
    }

    protected function isRelatedColumn($request)
    {
        return strpos($request['search_column'], '.') !== false;
    }

    protected function buildQuery($column, $operator, $request, $query)
    {

        switch ($operator) {
            case 'equal_to':
            case 'not_equal':
            case 'less_than':
            case 'greater_than':
            case 'less_than_or_equal_to':
            case 'greater_than_or_equal_to':
                $query->where($column, $this->operators[$operator], $request['search_query_1']);
                break;

            case 'in':
                $query->whereIn($column, explode(',', $request['search_query_1']));
                break;

            case 'not_in':
                $query->whereNotIn($column, explode(',', $request['search_query_1']));
                break;

            case 'like':
                $query->where($column, 'like', '%' . $request['search_query_1'] . '%');
                break;

            case 'between':
                $query->whereBetween($column, [
                    $request['search_query_1'],
                    $request['search_query_2'],
                ]);
                break;

            default:
                throw new Exception('Invalid Search Operator', 1);
                break;

        }

        return $query;

    }

}
