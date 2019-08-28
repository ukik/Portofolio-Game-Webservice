<?php

namespace App\Http\Controllers\Mutation\Record;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Mutation\Record\GetPurchase;
use App\Model\Mutation\Record\PostPurchase;

class PurchaseController extends Controller
{

    public function index(Request $request)
    {  
        return responses([
            'security' => getter('security'),            
            'model' => GetPurchase::with('get_user_profile')->status()->misc()->filterPaginateOrder()
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

        PostPurchase::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetPurchase::with('get_user_profile')->status()->misc()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $data = GetPurchase::with('get_user_profile')->status()->misc()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $requestData = $request->all();

        $data = PostPurchase::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        PostPurchase::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
