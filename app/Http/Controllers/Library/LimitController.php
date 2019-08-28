<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetLimit;
use App\Model\Library\PostLimit;

use Illuminate\Http\Request;

use Validator;

class LimitController extends Controller
{

    public function index(Request $request)
    {   
        $data = GetLimit::library()->orderBy('id', 'desc')->paginate($perPage);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function create(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        return responses(['security' => getter('security'), 'data' => 'forbidden']);
    }

    public function store(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $v = Validator::make($request->all, [
            'title' => 'required',
            'label' => 'required|in:min,max',
            'range' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }   

        $requestData = $request->all();

        PostLimit::create($requestData);

        return responses(['security' => getter('security'), 'data' => 'stored']);
    }

    public function show(Request $request, $id)
    {
        $data = GetLimit::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = GetLimit::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $v = Validator::make($request->only(
            'range'
        ), [
            'range' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }

        $requestData = $request->all();

        $data = PostLimit::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostLimit::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
