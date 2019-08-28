<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetVehicle;
use App\Model\Library\PostVehicle;

use Illuminate\Http\Request;

use Validator;

class VehicleController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $data = GetVehicle::library()->orderBy('id', 'desc')->paginate($perPage);
        
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
            'package'       => 'required|in:motorcycle,motorbox,mobil,pickup',
            'title'         => 'required',
            'level'         => 'required|in:1,2,3',
            'name'          => 'required',
            'description'   => 'required',
            'cash'          => 'required|numeric',
            'coin'          => 'required|numeric',
            'discount'      => 'required|numeric|min:0|max:100',
            'health'        => 'required|numeric|min:0|max:100',
            'fuel'          => 'required|numeric|min:0|max:100',
            'slot'          => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        } 

        $requestData = $request->all();

        PostVehicle::create($requestData);

        return responses(['security' => getter('security'), 'data' => "stored"]);
    }

    public function show(Request $request, $id)
    {
        $data = GetVehicle::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        $data = GetVehicle::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update($id, Request $request)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $v = Validator::make($request->only(
            'description',
            'cash',
            'coin',
            'discount',
            'slot',
            'health',
            'fuel',
            'meter_power',
            'meter_tank',
            'meter_capacity'
        ), [
            'description' => 'required|string',
            'cash' => 'required|numeric',
            'coin' => 'required|numeric',
            'discount' => 'required|numeric|min:0|max:100',
            'slot' => 'required|numeric',
            'health' => 'required|numeric|min:0|max:100',
            'fuel' => 'required|numeric|min:0|max:100',
            'meter_power' => 'required|numeric|min:0|max:10',
            'meter_tank' => 'required|numeric|min:0|max:10',
            'meter_capacity' => 'required|numeric|min:0|max:10',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }                

        $requestData = $request->all();

        $data = PostVehicle::findOrFail($id);

        $data->update($requestData);
        $data->meter()->update([
            'meter_power' => $request->meter_power,
            'meter_tank' => $request->meter_tank,
            'meter_capacity' => $request->meter_capacity,            
        ]);

        return responses(['security' => getter('security'), 'data' => "updated", $request->mode]);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };
        
        PostVehicle::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
