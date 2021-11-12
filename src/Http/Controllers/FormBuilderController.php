<?php

namespace Rdmarwein\Formbuilder\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rdmarwein\Formbuilder\FormMaster;

class FormBuilderController extends Controller
{
    public function __construct(Request $request)
    {
        $role=FormMaster::findOrFail($request->id);
        $this->middleware('auth');
        $this->middleware('formAuth:'.$role->role);
    }

    public function index($id,Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $model= $formMaster->model::all();
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);

        $masterKey=json_decode($formMaster->master_keys, true);
        
        $foreign=json_decode($formMaster->foreign_keys, true);
        
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $select[$foreign[$key][0]]=array($key,$foreign[$key][2]);
            }
        }
        
        $exclude=json_decode($formMaster->exclude, true);
        if($formMaster->route=='formbuilder')
        {
            return view('formbuilder::formbuilder.index',compact('columns','formMaster','select','masterKey','exclude','model'));
        }
        else{

        }
    }

    public function create($id,Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);

        $masterKey=json_decode($formMaster->master_keys, true);
        $master=array();
        if(sizeof((array)$masterKey)>0)
        {
            foreach (array_keys($masterKey) as $item) {
                $data=$item::all();
                $master[$masterKey[$item][2]]=array($data,$masterKey[$item][0],$masterKey[$item][1],$masterKey[$item][3]);
            }
        }

        $foreign=json_decode($formMaster->foreign_keys, true);
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $data=$key::all();
                $select[$foreign[$key][0]]=array($data,$foreign[$key][1],$foreign[$key][2]);
            }
        }
        $exclude=json_decode($formMaster->exclude, true);
        $attribute=json_decode($formMaster->attribute, true);
        if($formMaster->route=='formbuilder')
        {
            return view('formbuilder::formbuilder.create',compact('columns','formMaster','select','master','exclude','attribute'));
        }
        else{

        }
    }


    public function store(Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $values=$formMaster->model;
        $data=new $values;
        $except=array('_token','_method','redirect');
        foreach ($request->all() as $key => $value) {
            if(!in_array($key, $except))
            {
                $data-> $key = $value;
            }
        }
        $data->save();
        if(isset($request->redirect) && $request->redirect!='')
        {
            return redirect($request->redirect)->with(['message'=> 'Added Successfully','data'=>$data]);
        }
        else
        {
            return redirect()->back()->with(['message'=> 'Added Successfully','data'=>$data]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id,$cid)
    {
        $formMaster=FormMaster::findOrFail($id);
        $model= $formMaster->model::findOrFail($cid);
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);

        $masterKey=json_decode($formMaster->master_keys, true);
        $master=array();
        if(sizeof((array)$masterKey)>0)
        {
            foreach (array_keys($masterKey) as $item) {
                $data=$item::all();
                $master[$masterKey[$item][2]]=array($data,$masterKey[$item][0],$masterKey[$item][1],$masterKey[$item][3]);
            }
        }

        $foreign=json_decode($formMaster->foreign_keys, true);
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $data=$key::all();
                $select[$foreign[$key][0]]=array($data,$foreign[$key][1],$foreign[$key][2]);
            }
        }
        $exclude=json_decode($formMaster->exclude, true);
        $attribute=json_decode($formMaster->attribute, true);
        if($formMaster->route=='formbuilder')
        {
            return view('formbuilder::formbuilder.edit',compact('columns','formMaster','select','master','exclude','attribute','model'));
        }
        else{

        }
    }

    public function update(Request $request, $id,$cid)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $values=$formMaster->model;
        $data=$values::findOrFail($cid);
        $except=array('_token','_method','redirect');
        foreach ($request->all() as $key => $value) {
            if(!in_array($key, $except))
            {
                $data-> $key = $value;
            }
        }
        $data->save();
        return redirect()->back()->with(['message'=> 'Added Successfully','data'=>$data]);
    }

    public function destroy($id)
    {
        //
    }
}
