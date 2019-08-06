<?php

namespace PMBot\Http\Controllers\Stakeholders;

use PMBot\Http\Controllers\Controller;

use PMBot\Models\Stakeholders\Stakeholders;
use Illuminate\Http\Request;

class StakeholdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Stakeholders::orderBy('id', 'DESC')->paginate(10);
        return view('pages.stakeholders.index', compact('data'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.stakeholders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo '<PRE/>';echo 'caption =>' .__LINE__;echo '<PRE/>'; print_r($request->all());echo '<PRE/>';exit;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
        ]);


        // $data = Stakeholders::create($request->all());
        // $saveData = Stakeholders::create($request->all());
        $saveData = Stakeholders::firstOrCreate($request->all());



        $data = "";

        // $saveData = Stakeholders::orderBy('id', 'DESC');
        if ($saveData->id) {
            $data = $this->findById($saveData->id);
        }
        // echo '<PRE/>';
        // echo 'caption =>' . __LINE__;
        // echo '<PRE/>';
        // print_r($data->id);
        // echo '<PRE/>';
        // exit;
        $data = Stakeholders::orderBy('id', 'DESC');

        echo '<PRE/>';echo 'caption =>' .__LINE__;echo '<PRE/>'; print_r($data);echo '<PRE/>';exit;
        return response()->json($data);
        // return response()->json($data);

        // return redirect()->route('pages.stakeholders.index')->with('success', 'User created successfully');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showAll(Request $request)
    {
        $stakeholdersData = [
            [
                "id" => "#12212",
                "name" => "Suresh",
                "email" => "Suresh@gmail.com",
                "designation" => "Manager",
                "phone" => "31349",
                "mobile" => "9042495010"
            ]
        ];

        $fields = [
            "id",
            "name",
            "email",
            "designation",
            "phone",
            "mail"
        ];

        $stakeholder["data"] = $stakeholdersData;
        $stakeholder["itemsCount"] = count($stakeholdersData);
        $stakeholder["fields"] = $fields;

        // return response()->json($jobs);
        return response()->json($stakeholdersData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function findById($id)
    {
        $data = Stakeholders::find($id);
        return $data;
        // return view('pages.stakeholders.show', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Array
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function findByField($data)
    {
        $data = Stakeholders::where($data['key'], $data['value'])->first();

        return $data;
        // return view('pages.stakeholders.show', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Stakeholders::find($id);
        return view('pages.stakeholders.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Stakeholders::find($id);
        return view('pages.stakeholders.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
        ]);


        Stakeholders::find($id)->update($request->all());

        return redirect()->route('pages.stakeholders.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \PMBot\Models\Stakeholders\Stakeholders  $stakeholders
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stakeholders::find($id)->delete();
        return redirect()->route('pages.stakeholders.index')
            ->with('success', 'User removed successfully');
    }
}
