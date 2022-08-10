<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('employee');
    }

    public function upload(Request $request)
    {
        $file = $request->file('employees')->store('import');
        Excel::import(new EmployeesImport,  $file);
        
        return redirect('/')->with('success', 'All good!');
    }
}