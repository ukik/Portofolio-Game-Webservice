<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetIntro;
use App\Model\Library\PostIntro;

use Illuminate\Http\Request;

use Validator;

class IntroController extends Controller
{

    public function index(Request $request)
    {
        $perPage = 25;
        
        $data = GetIntro::library()->orderBy('id', 'desc')->paginate($perPage);
        
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
            'title'         => 'required',
            'description'   => 'required',
            'variant'       => 'required|in:service,driver',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }   

        $requestData = $request->all();

        PostIntro::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetIntro::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $data = GetIntro::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $v = Validator::make($request->only(
            'description'
        ), [
            'description'   => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }   

        $requestData = $request->all();

        $data = PostIntro::findOrFail($id);

        $data->update($requestData);
        
        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostIntro::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
