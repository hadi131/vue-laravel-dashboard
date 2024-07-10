<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Address;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index(Request $req)
    {
        $search = $req->search;
        $sortField = $req->sortField ?? 'id';
        $sortDirection = $req->sortDirection ?? 'asc';
        $employees = Employee::with([
            'address.country' => function ($query) {
                $query->addSelect(['id', 'name']);
            },
            'address.state' => function ($query) {
                $query->addSelect(['id', 'name']);
            },
            'address.city' => function ($query) {
                $query->addSelect(['id', 'name']);
            }
        ]);
        // Subquery

        if ($search != '') {
            $employeeData = $employees->where('name', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->orWhere('id', 'LIKE', "%$search%");
        }
        else if ($sortField === 'city_name') {
            $employeeData = $employees->join('addresses', 'employees.address_id', '=', 'addresses.id')
                ->join('cities', 'addresses.city_id', '=', 'cities.id')
                ->orderBy('cities.name', $sortDirection)
                ->select('employees.*'); // Ensure only employee fields are selected
        }
        else if ($sortField === 'state_name') {
            $employeeData = $employees->join('addresses', 'employees.address_id', '=', 'addresses.id')
                ->join('states', 'addresses.state_id', '=', 'states.id')
                ->orderBy('states.name', $sortDirection)
                ->select('employees.*'); // Ensure only employee fields are selected
        }
        else if ($sortField === 'country_name') {
            $employeeData = $employees->join('addresses', 'employees.address_id', '=', 'addresses.id')
                ->join('countries', 'addresses.country_id', '=', 'countries.id')
                ->orderBy('countries.name', $sortDirection)
                ->select('employees.*'); // Ensure only employee fields are selected
        } else {

            $employeeData = $employees->orderBy($sortField, $sortDirection);
        }
        // $employeeData = $employeeData->paginate(4);
        $employeeData = $employees->paginate(4)->appends([
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'search' => $search,
        ]);
        return EmployeeResource::collection($employeeData);
    }
    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();


        try {
            $address = Address::create([
                'state_id' => $request->state_id,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
            ]);

            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'address_id' => $address->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }

        DB::commit();



        return response("status", 200);
    }


    public function show(Employee $employee)
    {
        $employeeData = $employee->loadMissing(['address.country', 'address.state', 'address.city']);
        return new EmployeeResource($employeeData);
    }


    public function update(EmployeeRequest $request, Employee $employee)
    {

        DB::beginTransaction();
        try {

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
        } catch (Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
        DB::commit();
        return response("status", 200);
    }


    public function destroy(Employee $employee)
    {
        Address::Where('id', $employee->address_id)->delete();
        $employee->delete();
    }
}
