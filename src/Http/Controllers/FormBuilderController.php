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
        // return "hello";
        $role=FormMaster::findOrFail($request->id);
        return $role;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,Request $request)
    {
        $formMaster=FormMaster::findOrFail($request->id);
        $model= $formMaster->model::all();
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($formMaster->table_name);

        $masterKey=json_decode($formMaster->master_keys, true);
        $master=array();
        if(sizeof((array)$masterKey)>0)
        {
            foreach (array_keys($masterKey) as $item) {
                $values=$item;
                $data=$values::all();
                $master[$masterKey[$item][2]]=array($data,$masterKey[$item][0],$masterKey[$item][1],$masterKey[$item][3]);
            }
        }

        $foreign=json_decode($formMaster->foreign_keys, true);
        $select=array();
        if(sizeof((array)$foreign)>0)
        {
            foreach (array_keys($foreign) as $key) {
                $values=$key;
                $data=$values::all();
                $select[$foreign[$key][0]]=array($data,$foreign[$key][1],$foreign[$key][2]);
            }
        }
        $exclude=json_decode($formMaster->exclude);
        $inputType=array();
        $attribute=json_decode($formMaster->attribute, true);
        return $attribute['type'];
        if(sizeof($attribute['type'])>0)
        {
            foreach (array_keys($attribute['type']) as $key) {
                $inputType[$key]=$type[$key];
            }
        }

        if($formMaster->route=='formbuilder')
        {
            return view('formbuilder::formbuilder.create',compact('columns','formMaster','select','master','exclude','inputType'));
        }
        else{

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
