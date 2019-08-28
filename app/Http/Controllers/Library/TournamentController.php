<?php

namespace App\Http\Controllers\Library;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Library\GetTournament;
use App\Model\Library\PostTournament;

use Illuminate\Http\Request;

use Validator;

class TournamentController extends Controller
{

    public function index(Request $request)
    {   
        $data = GetTournament::library()->orderBy('id', 'desc')->paginate($perPage);

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
            'day_begin'     => 'required',
            'day_end'       => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }   

        $requestData = $request->all();

        PostTournament::create($requestData);

        return responses(['security' => getter('security'), 'data' => 'stored']);
    }

    public function show(Request $request, $id)
    {
        $data = GetTournament::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $data = GetTournament::findOrFail($id);

        return responses(['security' => getter('security'), 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        $v = Validator::make($request->only(
            'day_begin',
            'day_end'
        ), [
            'day_begin'     => 'required',
            'day_end'       => 'required',
        ]);

        if ($v->fails()) {
            return responses(['security' => getter('security'), 'data' => "false"]);
        }

        $requestData = $request->all();

        $data = PostTournament::findOrFail($id);

        $data->update($requestData);

        return responses(['security' => getter('security'), 'data' => 'updated']);
    }

    public function destroy(Request $request, $id)
    {
        if (clean($request) == 'false'){
            return responses(['security' => null, 'data' => "false"]);   
        };

        PostTournament::destroy($id);

        return responses(['security' => getter('security'), 'data' => "destroyed"]);
    }
}
