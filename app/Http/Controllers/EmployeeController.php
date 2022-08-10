<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employees = Employee::paginate(constants('PER_PAGE'));
        return view('employee')->with(compact('employees'));
    }

    public function recomend($employee_id)
    {
        $employee =  Employee::find($employee_id);
        $recumandation = Employee::query()
            ->where('id', '!=', $employee_id)
            ->select([
                '*',
                DB::raw(
                    '(CASE 
                        WHEN employees.division = "'. $employee->division .'" THEN 30
                        ELSE 0
                    END) +
                    (CASE 
                        WHEN CAST( employees.age - '. $employee->age .' AS UNSIGNED ) <= ' . constants('MAX_AGE_DIFF') .' THEN 30
                        ELSE 0
                    END) +
                    (CASE 
                        WHEN employees.timezone = '. $employee->timezone .' THEN 40
                        ELSE 0
                    END) AS percent'
                )
            ])
            ->get()
            ->sortByDesc('percent');

        return $recumandation;
    }

    public function upload(Request $request)
    {
        $file = $request->file('employees')->store('import');
        Excel::import(new EmployeesImport,  $file);
        
        return redirect('/')->with('success', 'All good!');
    }
}