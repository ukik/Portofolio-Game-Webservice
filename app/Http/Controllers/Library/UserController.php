<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User\GetUser;
use App\Model\User\PostUser;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return response()
        ->json([
            'security' => getter('security'),
            'model' => GetUser::whereScope('player')->status()->filterPaginateOrder()
        ]);
    }

    public function create(Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        return responses(['security' => getter('security'), 'data' => "forbidden"]);        
    }

    public function store(Request $request)
    {
        requests($request, $this->auth());

        return responses(['security' => getter('security'), 'data' =>"stored"]);
    }

    public function show(Request $request, $id = null)
    {
        $data = GetUser::status()->where('id', $id)->first();

        return responses(['security' => getter('security'), 'validation' => getter('validation'),  'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = PostUser::status()->where("id", $id)->first();

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $requestData = $request->all();
        
        $data = PostUser::status()->findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostUser::status()->destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
