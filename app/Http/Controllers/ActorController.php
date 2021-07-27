<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActorController extends Controller
{
    // COUNTRY LIST VIEW
    public function index()
    {
        // if ($request->ajax()) {
        //     $actor = Actor::orderBy('last_update', 'desc')->get();
        //     // return response()->json(['data' => $actor]);

        //     return DataTables::of($actor)
        //         ->addIndexColumn()
        //         ->addColumn('actions', function ($row) {
        //             return
        //                 '<div class="btn-group">
        //                                             <button type="button" class="btn btn-sm btn-primary"     data-id="' . $row['actor_id'] . '" id="editBtn">EDIT</button>
        //                                             <button type="button" class="btn btn-sm btn-danger">DEL</button>
        //                                         </div>';
        //         })
        //         ->rawColumns(['actions'])
        //         ->toJson();
        // }


        return view('actor.list-actor');
        // return response()->json(['data' => $actor]);
    }

    // GET DATATABLE
    public function getActorList()
    {
        $actor = Actor::orderBy('last_update', 'desc')->get();

        return DataTables::of($actor)
                            ->addIndexColumn()
                            ->addColumn('actions', function ($row) {
                                return
                                    '<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" data-id="' . $row['actor_id'] . '" id="edit-btn">EDIT</button>
                                        <button type="button" class="btn btn-sm btn-danger" data-id="' . $row['actor_id'] . '" id="delete-btn">DEL</button>
                                    </div>';
                            })
                            ->rawColumns(['actions'])
                            ->toJson();
    }

    // ADD ACTOR
    public function addActor(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $actor = new Actor();
            $actor->first_name = $request->first_name;
            $actor->last_name = $request->last_name;
            $query = $actor->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Failed save data']);
            } else {
                // Command: toastr["success"]("Have fun storming the castle!", "SUCCESS")
                // {"code":1,"msg":"Success update data."}
                // toastr . success(data . msg);
                return response()->json([
                    'code' => 1,
                    'msg' => 'Data saved succesfully',
                    'title'=>'Success'
                ]);
            }

        }
    }

    // SHOW EDIT
    public function getActorDetails(Request $request)
    {
        $actor_id = $request->actor_id;
        $actorDetails = Actor::find($actor_id);
        // $actorDetails = Actor::where('actor_id', $actor_id)->first();
        return response()->json(['details' => $actorDetails]);

    }

    // UPDATE
    public function updateActorDetails(Request $request)
    {
        $actor_id = $request->actor_id;

        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()
            ]);
        } else {
            $actor = Actor::find($actor_id);
            $actor->first_name = $request->first_name;
            $actor->last_name = $request->last_name;

            $query = $actor->save();

            if ($query) {
                return response()->json([
                    'code' => 1,
                    'msg' => 'Data updated succesfully',
                    'title' => 'Success'
                ]);
            } else {
                return response()->json(['code' => 0,'msg' => 'Failed update data.'
                ]);
            }

        }
    }

    // DELETE
    public function deleteActor(Request $request)
    {
        $actor_id = $request->actor_id;
        $query = Actor::find($actor_id)->delete();

        if ($query) {
            return response()->json([
                'code' => 1,
                'msg' => 'Data is deleted from database',
                'title' => 'Success'
            ]);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Failed delete data.']);
        }
    }
}
