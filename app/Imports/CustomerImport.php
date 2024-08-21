<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\UserCategory;
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
//    public function collection(Collection $collection)
//    {
//        foreach ($collection as $row){
////            dd($row);
//            User::create($row);
//        }
//    }

    public function model(array $row)
    {
        // TODO: Implement model() method.
        $phone = (string) $row['phone'];
//        dd($phone);
        $record = User::where('phone', $row['phone'])->first();
        if ($record){
            $record->update($row);
            $record->phone = $phone.'hello';
            $record->save();
            $record->phone = str_replace('hello', '', $record->phone);
            $record->save();
        }else{
            unset($row['phone']);
            $record = User::create($row + ['phone' =>$phone.'hello', 'password' => Hash::make('password'), 'role' => 'user']);
            $record->phone = str_replace('hello', '', $record->phone);
            $record->save();
            if (isset($row['category'])) {
                $category = Category::where('name', $row['category'])->first();
            } else {
                $category = null;
            }

            if ($category){
                UserCategory::create(['user_id' => $record->id, 'category_id' => $category->id]);
            }
        }
    }
}
