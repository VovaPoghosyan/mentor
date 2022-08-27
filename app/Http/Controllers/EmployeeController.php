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
    private $matched_ids = [];

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

        if (!$employee) {
            return redirect('/');
        }

        $recomendations = $employee->recomendations;

        return view('recomendation')->with(compact('recomendations', 'employee'));
    }

    public function matches()
    {
        $matches = [];

        Employee::all()->map(function ($employee) use (&$matches) {
            if (!in_array($employee->id, $this->matched_ids)) {
                $match = $this->checkMatch($employee);
                array_push($matches, $match);
            }
        });

        $percents = collect($matches)->pluck('percent')->toArray();
        $average_score = array_sum($percents) / count($percents);

        return view('matches')->with(compact('matches', 'average_score'));
    }

    public function checkMatch($employee, $i = 0)
    {
        $matched_employee = $employee->recomendations->skip($i)->first();

        if (in_array($matched_employee->id, $this->matched_ids)) {
            return $this->checkMatch($employee, $i + 1);
        }

        $first_score_diff  = $this->checkScoreDiff($employee, $i, $matched_employee->percent);
        $second_score_diff = $this->checkScoreDiff($matched_employee, 0, $matched_employee->percent);

        if ($first_score_diff + $second_score_diff > 0) {
            return $this->checkMatch($employee, $i + 1);
        }

        array_push($this->matched_ids, $matched_employee->id, $employee->id);

        return [
            'employes' => [$employee->name, $matched_employee->name],
            'percent'  => $matched_employee->percent,
        ];

    }

    private function checkScoreDiff($employee, $i, $percent)
    {
        $matched_employee = $employee->recomendations->skip($i)->first();

        if (in_array($matched_employee->id, $this->matched_ids)) {
            return $this->checkScoreDiff($employee, $i + 1, $percent);
        }

        return $matched_employee->percent - $percent;

    }

    public function upload(Request $request)
    {
        $request->validate([
            'employees' => 'required|mimes:csv,xlsx,xls',
        ]);

        $file = $request->file('employees')->store('import');
        Excel::import(new EmployeesImport,  $file);
        
        return redirect()->back()->with('success', true);
    }
}