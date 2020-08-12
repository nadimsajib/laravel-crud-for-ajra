<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(4);
        $countries= DB::table("countries")->get();
		return view('customers.index',compact('customers','countries'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }
    public function getCityList(Request $request)
    {
        $cities = DB::table("cities")
            ->where("country_id",$request->country_id)
            ->pluck("name","id");
        return response()->json($cities);
    }
    public function formValidation(Request $request)
    {
        $rules = [
            'name' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'date_of_birth' => 'nullable|date_format:Y-m-d|before:today',
            'resume'   => 'required|mimes:doc,pdf,docx,zip'
        ];
        if ($request->cust_id) {
            $rules['resume'] = '';
        }
        $r=$request->validate($rules);
        return response()->json(['message'=>'success']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'country_id' => 'required',
            'lang_skills' => 'required',
            'city_id' => 'required',
            'date_of_birth' => 'nullable|date_format:Y-m-d|before:today',
            'resume'   => 'required|mimes:doc,pdf,docx,zip'
        ];
        if ($request->cust_id) {
            $rules['resume'] = '';
        }
        $r=$request->validate($rules);

		$custId = $request->cust_id;
        if($request->file()) {
            $fileName = time().'_'.$request->file('resume')->getClientOriginalName();
            $filePath = $request->file('resume')->storeAs('uploads', $fileName, 'public');
            $request->file('resume')->move(public_path('/uploads'), $fileName);

            //$request->name = time().'_'.$request->file->getClientOriginalName();
            $request->resume = '/' . $filePath;
        }
        if ($request->resume == '') {
            $request->resume = $request->hidden_resume;
        }
		Customer::updateOrCreate(
		    ['id' => $custId],
            [
                'name' => $request->name,
                'country_id' => $request->country_id,
                'city_id'=>$request->city_id,
                'lang_skills'=>rtrim($request->lang_skills, ','),
                'resume'=>$request->resume,
                'date_of_birth'=>$request->date_of_birth
            ]);
		if(empty($request->cust_id))
			$msg = 'Customer entry created successfully.';
		else
			$msg = 'Customer data is updated successfully';
		return redirect()->route('customers.index')->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
		$customer = Customer::where($where)->with('cities')->first();
		return Response::json($customer);
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
        $cust = Customer::where('id',$id)->delete();
		return Response::json($cust);
    }
}
