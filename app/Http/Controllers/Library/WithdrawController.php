<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetWithdraw;
use App\Model\Library\PostWithdraw;

use Illuminate\Http\Request;

use Validator;

class WithdrawController extends Controller
{

    public function index(Request $request)
    {
        $data = GetWithdraw::library()->orderBy('id', 'desc')->paginate($perPage);
        
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
            'title' => 'required',
            'label' => 'required|in:1,2,3,4,5,6,7',
            'cash'  => 'required|numeric',
            'coin'  => 'required|numeric',
            'fee'   => 'required|numeric|min:0|max:100',
            'value' => 'required|in:2500,5000,7500,10000,15000,20000,25000',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }           
        
        $requestData = $request->all();

        PostWithdraw::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetWithdraw::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $data = GetWithdraw::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $v = Validator::make($request->only(
            'cash','coin','fee'
        ), [
            'cash'  => 'required|numeric',
            'coin'  => 'required|numeric',
            'fee'   => 'required|numeric|min:0|max:100',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }           
                
        $requestData = $request->all();

        $data = PostWithdraw::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostWithdraw::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
