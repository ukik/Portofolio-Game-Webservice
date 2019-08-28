<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetHelp;
use App\Model\Library\PostHelp;

use Illuminate\Http\Request;

use Validator;

class HelpController extends Controller
{

    public function index(Request $request)
    {   
        $data = GetHelp::library()->orderBy('id', 'desc')->paginate($perPage);

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
            'description'   => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }   

        $requestData = $request->all();

        PostHelp::create($requestData);

        return responses(['security' => getter('security'), 'data' => 'stored']);
    }

    public function show(Request $request, $id)
    {
        $data = GetHelp::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = GetHelp::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        // if (clean($request) == 'false'){
        //     return responses(['security' => null, 'data' => "false"]);   
        // };

        $v = Validator::make([
            'description'   => $request->description
        ], [
            'description'   => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }

        $requestData = $request->all();

        $data = PostHelp::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostHelp::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
