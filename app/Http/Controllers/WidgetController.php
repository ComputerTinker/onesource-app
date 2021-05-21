<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Widget;
use DataTables;

class WidgetController extends Controller
{
    public function index()
    {
      $data = Widget::latest()->get();
      return Datatables::of($data)
          ->addIndexColumn()
          ->addColumn('action', function($row){
              $actionBtn = '<a href="javascript:edtWgt(' . $row['id'] . ')" class="edit btn btn-primary btn-sm">Edit</a> <a href="javascript:delWgt(' . $row['id'] . ')" class="delete btn btn-danger btn-sm">Delete</a>';
              return $actionBtn;
          })
          ->rawColumns(['action'])
          ->make(true);
    }


    public function show($id)
    {
      $widget = Widget::findOrFail($id);
      return response()->json($widget);
    }


    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        Widget::create($request->all());
        return response()->json(['success'=>'New widget added!']);
    }


    public function update(Request $request, Widget $widget)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $widget->update($request->all());
        return response()->json(['success'=>'Widget updated!']);
    }


    public function destroy(Widget $widget)
    {
        $widget->delete();
        return response()->json(['success'=>'Widget deleted!']);
    }
}
