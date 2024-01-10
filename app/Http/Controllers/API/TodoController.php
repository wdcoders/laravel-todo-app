<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Todo::orderby('created_at', 'desc');

        if ($request->query('status')) {
            $query = $query->where('status', $request->query('status'));
        }
        $todos = $query->get();

        return response()->json(['data' => $todos, 'request' => $request->query('status')], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array();
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->passes()) {
            $todo = new Todo();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();

            $data = array(
                "message" => "Todo Created",
                "data" => $todo
            );
            return response()->json($data, 201);
        }

        $data = array(
            "errors" => $validator->errors()
        );
        return response()->json($data, 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todo::where('id', $id)->first();
        $data = array(
            "data" => $todo
        );
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = array();
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->passes()) {
            $todo = Todo::where('id', $id)->first();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->status = $request->status;
            $todo->save();

            $data = array(
                "message" => "Todo Updated",
                "data" => $todo
            );
            return response()->json($data, 200);
        }

        $data = array(
            "errors" => $validator->errors()
        );
        return response()->json($data, 400);
    }

    public function updateStatus(Request $request, string $id)
    {
        $data = array();
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->passes()) {

            $todo = Todo::where('id', $id)->first();
            if ($todo) {
                $todo->status = $request->status;
                $todo->save();

                $data = array(
                    "message" => "Todo Updated",
                    "data" => $todo
                );
                return response()->json($data, 200);
            }

            $data = array(
                "message" => "Not Found"
            );
            return response()->json($data, 400);
        }

        $data = array(
            "errors" => $validator->errors()
        );
        return response()->json($data, 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::where('id', $id)->first();
        $todo->delete();
        $data = array(
            "message" => "Todo Deleted",
            "data" => $todo
        );
        return response()->json($data, 200);
    }
}
