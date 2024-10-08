<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Language;
use App\Models\Note;
use App\Models\Package;
use App\Models\Payment;
use App\Models\UserCategory;
use App\Models\UserLanguage;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;




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
        $phone1 = (string) $row['phone1'];
//        dd($phone);
        $record = User::where('phone', $phone)->first();
        if ($record){

            $record->update(['name' => $row['name'], 'email' => $row['email'], 'phone' => $phone, 'phone1' => $phone1, 'business_name' => $row['business_name'], 'country' => $row['country'], 'state' => $row['state'], 'city' => $row['city'], 'pin' => $row['pin'], 'address' => $row['address'], 'gst_number' => $row['gst_number'], 'start_date' => Carbon::parse($row['start_date'])->toDateString(), 'frame' => $row['frame'], 'plan' => $row['plan']]);

            $record->phone = $phone.'hello';
            $record->save();
            $record->phone = str_replace('hello', '', $record->phone);
            $record->phone1 = str_replace('hello', '', $record->phone1);
            $record->status = 1;
            $record->save();
            if($row['note']){
                Note::create(['name' => $record->name, 'user_id' => $record->id, 'description' => $row['note']]);
            }
            if (isset($row['category'])) {
                $names = explode(',', $row['category']);
                $categories = Category::whereIn('name', $names)->get();
            } else {
                $categories = null;
            }
            if ($categories){
                foreach ($categories as $category){
                    UserCategory::create(['user_id' => $record->id, 'category_id' => $category->id]);
                }
            }
            $lanNames = explode(',', $row['language']);
            $languages = Language::whereIn('name', $lanNames)->get();
            foreach ($languages as $language){
                UserLanguage::create(['user_id' => $record->id, 'language_id' => $language->id]);
            }
            if($row['plan']){
                $package = Package::where('price', $row['plan'])->where('name', 'LIKE', $row['package_name'])->first();
                if ($package){
//                    dd( $packageStartDate);
                    $packageStartDate = Carbon::parse($row['package_start_date'])->toDateString();
                    $expiryDate = Carbon::parse($packageStartDate)->addDays($package->duration)->toDateString();
                    $userPackage = UserPackage::create(['user_id' => $record->id, 'package_id' => $package->id, 'start_date' => $packageStartDate, 'expiry_date' => $expiryDate, 'status' => $expiryDate < today() ? '0' : '1', 'selling_price' => $row['selling_price']]);
                    if ($expiryDate < today()){
                        $record->update(['status' => '0']);
                    }else{
                        $record->update(['status' => '1']);
                    }
                    try {
                        Payment::create([
                            'user_package_id' => $userPackage->id,
                            'amount' => $row['selling_price'],
                            'payment_method' => 'online',
                        ]);
                    } catch (\Exception $e) {
                        // Handle the error (e.g., log the error or skip)
                        // You can log the error if needed:
                        // \Log::error($e->getMessage());
                    }
                }
            }
        }else{
            unset($row['phone']);
//            dd(Carbon::parse($row['start_date'])->toDateString());
            $record = User::create(['name' => $row['name'], 'email' => $row['email'], 'business_name' => $row['business_name'], 'country' => $row['country'], 'state' => $row['state'], 'city' => $row['city'], 'pin' => $row['pin'], 'address' => $row['address'], 'gst_number' => $row['gst_number'], 'start_date' => Carbon::parse($row['start_date'])->toDateString(), 'frame' => $row['frame'], 'plan' => $row['plan']] + ['phone' =>$phone.'hello', 'phone1' => $phone1.'hello', 'password' => Hash::make('password'), 'role' => 'user']);
            $record->phone = str_replace('hello', '', $record->phone);
            $record->phone1 = str_replace('hello', '', $record->phone1);
            $record->save();

            if (isset($row['category'])) {
                $names = explode(',', $row['category']);
                $categories = Category::whereIn('name', $names)->get();
            } else {
                $categories = null;
            }
            if ($categories){
                foreach ($categories as $category){
                    UserCategory::create(['user_id' => $record->id, 'category_id' => $category->id]);
                }
            }
            if($row['note']){
                Note::create(['name' => $record->name, 'user_id' => $record->id, 'description' => $row['note']]);
            }
            $lanNames = explode(',', $row['language']);
            $languages = Language::whereIn('name', $lanNames)->get();
            foreach ($languages as $language){
                UserLanguage::create(['user_id' => $record->id, 'language_id' => $language->id]);
            }

            if($row['plan']){
                $package = Package::where('price', $row['plan'])->where('name', 'LIKE', $row['package_name'])->first();
//                dd($package);
                if ($package){
                    $packageStartDate = Carbon::parse($row['package_start_date'])->toDateString();
                    $expiryDate = Carbon::parse($packageStartDate)->addDays($package->duration)->toDateString();
//                    dd($expiryDate);

                    $userPackage = UserPackage::create(['user_id' => $record->id, 'package_id' => $package->id, 'start_date' => $packageStartDate , 'expiry_date' => $expiryDate, 'status' => $expiryDate < today() ? '0' : '1', 'selling_price' => $row['selling_price']]);

                    try {
                        Payment::create([
                            'user_package_id' => $userPackage->id,
                            'amount' => $row['selling_price'],
                            'payment_method' => 'online',
                        ]);
                    } catch (\Exception $e) {
                        // Handle the error (e.g., log the error or skip)
                        // You can log the error if needed:
                        // \Log::error($e->getMessage());
                    }
//                    Payment::create(['user_package_id' => $userPackage->id, 'amount' => $row['selling_price'], 'payment_method' => 'online']);
                }
            }
        }
    }
}
