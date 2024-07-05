<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Address;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $req)
    {
        $search = $req->search;
        $employees = Employee::with(['address.country', 'address.state', 'address.city']);

        if ($search != '') {
            return $employees->where('name', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%")->get();
        } else {


            return $employees->orderBy('id', 'DESC')->get();
        }
    }


    public function store(StoreEmployeeRequest $request)
    {


        Employee::create([
            $address = Address::create([
                'state_id' => $request->state_id,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
            ]),
            'name' => $request->name,
            'email' => $request->email,
            'address_id' => $address->id
        ]);


        return response("status", 200);
    }


    public function show(Employee $employee)
    {
        $employ = Employee::with(['address.country','address.state', 'address.city']);
        return $employ->find($employee);
    }


    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {


       $address = Address::find($employee->address_id);

        $address->update([
             'state_id' => $request->state_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'address_id' => $address->id,

        ]);
        return response("status", 200);
    }


    public function destroy(Employee $employee)
    {
        Address::Where('id', $employee->address_id)->delete();
        $employee->delete();


    }
}
