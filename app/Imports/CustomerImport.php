<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
//            dd($row);
            User::create($row);
        }
    }

    public function model(array $row)
    {
        // TODO: Implement model() method.


//            dd($row);
            User::create($row + ['password' => Hash::make('password'), 'role' => 'user']);
    }
}
