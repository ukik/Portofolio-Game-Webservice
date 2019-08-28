<?php

namespace App\Http\Controllers\Mutation\Record;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Mutation\Record\GetAchievement;
use App\Model\Mutation\Record\PostAchievement;

class AchievementController extends Controller
{

    public function index(Request $request)
    {   
        return responses([
            'security' => getter('security'),            
            'model' => GetAchievement::with('get_user_profile')->status()->filterPaginateOrder()
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

        PostAchievement::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetAchievement::with('get_user_profile')->status()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };        

        $data = GetAchievement::with('get_user_profile')->status()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };        
        
        $requestData = $request->all();

        $data = PostAchievement::findOrFail($id);
        
        $data->update($requestData);
        
        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };        

        PostAchievement::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
