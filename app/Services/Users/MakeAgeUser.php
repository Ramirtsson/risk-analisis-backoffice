<?php

namespace App\Services\Users;

use App\Repositories\EmployeeRepository;
use Carbon\Carbon;

class MakeAgeUser
{
    public function updateEmployeeAges()
    {
        $employeeRepository = app(EmployeeRepository::class);

        $employees = $employeeRepository->all();

        foreach ($employees as $employee) {
            if (is_null($employee->age)) {
                $calculatedAge = Carbon::parse($employee->birthdate)->age;
                if (is_numeric($calculatedAge)) {
                    $employee->update([
                        'age' => $calculatedAge,
                    ]);
                }
            }
        }
        return $employees;
    }
}
