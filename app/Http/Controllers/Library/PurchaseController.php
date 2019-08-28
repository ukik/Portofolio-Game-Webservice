<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetPurchase;
use App\Model\Library\PostPurchase;

use Illuminate\Http\Request;

use Validator;

class PurchaseController extends Controller
{

    public function index(Request $request)
    {
        $data = GetPurchase::library()->orderBy('id', 'desc')->paginate($perPage);

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
            'title'     => 'required',
            'currency'  => 'required|in:cash,coin',
            'label'     => 'required|in:A,B,C,D',
            'price'     => 'required|numeric',
            'value'     => 'required|numeric',
            'discount'  => 'required|numeric|min:0|max:100',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        } 

        $requestData = $request->all();

        PostPurchase::create($requestData);

        return responses(['security' => getter('security'), 'data' => 'stored']);
    }

    public function show(Request $request, $id)
    {
        $data = GetPurchase::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $data = GetPurchase::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $v = Validator::make($request->only(
            'title','price','value','discount'
        ), [
            'title'     => 'required',
            'price'     => 'required|numeric',
            'value'     => 'required|numeric',
            'discount'  => 'required|numeric|min:0|max:100',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        } 

        $requestData = $request->all();

        $data = PostPurchase::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostPurchase::destroy($id);

        return responses(['security' => getter('security'), 'data' => 'destroyed']);
    }
}
