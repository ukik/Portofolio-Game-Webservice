<?php

namespace App\Http\Controllers\Mutation\Result;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Mutation\Result\GetWallet;
use App\Model\Mutation\Result\PostWallet;

class WalletController extends Controller
{

    public function index(Request $request)
    {     
        return responses([
            'security' => getter('security'), 
            'model' => GetWallet::with('get_user_profile')->status()->filterPaginateOrder()
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

        PostWallet::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetWallet::with('get_user_profile')->status()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $data = GetWallet::with('get_user_profile')->status()->where("id", $id)->first();
        
        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {

        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        $requestData = $request->all();

        $data = PostWallet::findOrFail($id);

        $data->update($requestData);
        
        return responses(['security' => getter('security'), 'data' => "updated"]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
                
        PostWallet::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }

    # non resource
    public function resetTournament(Request $request) {

        // if (clean($request) == 'false'){
        //     return responses(['security' => null, 'data' => "false"]);   
        // };

        PostWallet::where('score_tournament','like','%')->update([
            'score_tournament' => 0
        ]);

        return responses(['security' => getter('security'), 'data' => "updated"]);        
    }
}
