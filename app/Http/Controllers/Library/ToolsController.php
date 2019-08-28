<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetTools;
use App\Model\Library\PostTools;

use Illuminate\Http\Request;

use Validator;

class ToolsController extends Controller
{

    public function index(Request $request)
    {
        $data = GetTools::library()->orderBy('id', 'desc')->paginate($perPage);
        
        return responses(['security' => getter('security'), 'data' => $data]);
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
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $v = Validator::make($request->all, [
            'package'       => 'required|in:cleaner,washer,service,fashion',
            'title'         => 'required',
            'level'         => 'required|in:1,2,3',
            'name'          => 'required',
            'description'   => 'required',
            'cash'          => 'required|numeric',
            'coin'          => 'required|numeric',
            'discount'      => 'required|numeric|min:0|max:100',
            'slot'          => 'required|numeric',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        } 

        $requestData = $request->all();

        PostTools::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetTools::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $data = GetTools::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $v = Validator::make($request->only(
            'description','cash','coin','discount','slot'
        ), [
            'description'   => 'required',
            'cash'          => 'required|numeric',
            'coin'          => 'required|numeric',
            'discount'      => 'required|numeric|min:0|max:100',
            'slot'          => 'required|numeric',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        } 

        $requestData = $request->all();

        $data = PostTools::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostTools::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
