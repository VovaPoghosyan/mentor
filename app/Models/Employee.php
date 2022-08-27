<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'division',
        'age',
        'timezone',
    ];

    public function getRecomendationsAttribute()
    {
        return self::query()
            ->where('id', '!=', $this->id)
            ->select([
                '*',
                DB::raw(
                    '(CASE 
                        WHEN employees.division = "'. $this->division .'" THEN 30
                        ELSE 0
                    END) +
                    (CASE 
                        WHEN ABS( employees.age - '. $this->age .') <= ' . constants('MAX_AGE_DIFF') .' THEN 30
                        ELSE 0
                    END) +
                    (CASE 
                        WHEN employees.timezone = '. $this->timezone .' THEN 40
                        ELSE 0
                    END) AS percent'
                )
            ])
            ->get()
            ->sortByDesc('percent');
    }
}
