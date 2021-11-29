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
        $attribute=json_decode($formMaster->attribute, true);

        $model= $formMaster->model::orderBy('id','desc');
        if(isset($attribute['condition']['index']))
        {
            foreach($attribute['condition']['index'] as $key=> $value)
            {
                $model=$model->where($key, $value);
            }
        }
        $model=$model->get();
        
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);
        
        $foreign=json_decode($formMaster->foreign_keys, true);
        
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $select[$foreign[$key][0]]=array($key,$foreign[$key][2]);
            }
        }
        
        $exclude=json_decode($formMaster->exclude, true);
        if($formMaster->view=='formbuilder' || $formMaster->view=='formajax')
        {
            return view('formbuilder::formbuilder.index',compact('columns','formMaster','select','exclude','model'));
        }
        else{

        }
    }

    public function create($id,Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);

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
        if($formMaster->view=='formbuilder' || $formMaster->view=='formajax')
        {
            return view('formbuilder::'.$formMaster->view.'.create',compact('columns','formMaster','select','exclude','attribute'));
        }
        else{

        }
    }


    public function store(Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $attribute=json_decode($formMaster->attribute, true);
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
        if(isset($attribute['redirect']))
        {
            return redirect($attribute['redirect'])->with(['message'=> 'Added Successfully','data'=>$data]);
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
        if($formMaster->view=='formbuilder' || $formMaster->view=='formajax')
        {
            return view('formbuilder::formbuilder.edit',compact('columns','formMaster','select','exclude','attribute','model'));
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

    public function destroy($id,$cid)
    {
        try {
            $model=FormMaster::findOrFail($id);
            $values=$model->model;
            $data=$values::findOrFail($cid);
            $data->delete();
            return redirect()->back()->with('message', 'Deleted Successfully');        
         } catch ( \Exception $e) {
            return redirect()->back()->with('fail-message', 'Cannot delete or update a parent row: a foreign key constraint fails');      
         }
    }

    public function indexDetail($id,$cid)
    {
        $formMaster=FormMaster::findOrFail($id);
        $attribute=json_decode($formMaster->attribute, true);

        $model= $formMaster->model::orderBy('id','desc');
        if(isset($attribute['condition']['index']))
        {
            foreach($attribute['condition']['index'] as $key=> $value)
            {
                $model=$model->where($key, $value);
            }
        }
        $model=$model->where($_GET['column'],$cid)->get();
        
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);
        
        $foreign=json_decode($formMaster->foreign_keys, true);
        
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $select[$foreign[$key][0]]=array($key,$foreign[$key][2]);
            }
        }
        
        $exclude=json_decode($formMaster->exclude, true);
        return view('formbuilder::formajax.ajax',compact('columns','formMaster','select','exclude','model'));
    }

    public function finalize($id,$tid,Request $request)
    {
        $formPopulate=FormPopulate::select('id')
        ->where('header',$request->field)
        ->first();
        $model=FormPopulate::findOrFail($formPopulate->id);
        $values='App\\'.$model->model;
        $data=$values::findOrFail($tid);
        $data->finalize=true;
        $data->save();
        if(isset($request->redirect) && $request->redirect!='')
        {
            return redirect($request->redirect)->with('data',$data);
        }
        else
        {
            return redirect()->back()->with('message', 'Updated Successfully');
        }
    }
}
