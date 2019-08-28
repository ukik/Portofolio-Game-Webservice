<?php

namespace App\Http\Controllers\Mutation\Reference;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Model\Fetch\Intro as FetchIntro;
use App\Model\Mutation\Reference\GetIntro;
use App\Model\Mutation\Reference\PostIntro;

class IntroController extends Controller
{

    public function index(Request $request)
    {       
        return responses([
            'security' => getter('security'), 
            'model' => GetIntro::with('get_user_profile')->status()->filterPaginateOrder()
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
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                    
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
                    
        $data = Intro::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                    
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
