<?php

namespace App\Jobs;

use App\Models\Image;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;
    /**
     * Create a new job instance.
     */
    public function __construct($date)
    {
        $this->date = $date;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        dd($this->date);
        if(session('instance_id') && session('access_token')){
            $images = Image::where('date', $this->date)->get();
            foreach ($images as $image){
                if($image->user->status == '1' && $image->sent == '0'){
                    $phoneNumber = substr($image->user->phone, -10);
                    //$imageUrl = asset('storage/'. $image->media);
                    $imageUrl = 'https://realvictorygroups.com/wp-content/uploads/2024/04/5102941_2691166-e1712569043142-1024x906.jpg';
                    $message = str_replace(' ', '+', $image->title);
                    $fileName = str_replace(' ', '+', $image->title);

                    $client = new Client(['verify' => false]);
                    $response = $client->request('GET', 'https://rvgwp.in/api/send?number=91'.$phoneNumber.'&type=media&message='.$message.'&media_url='.$imageUrl.'&filename='.$fileName.'&instance_id='.session('instance_id').'&access_token='.session('access_token'));
                    $message = $response->getBody()->getContents();
                    if(json_decode($message)->status == 'error'){
//                        return redirect()->back()->with('error', $message);
                    }else{
                        $image->sent = '1';
                        $image->save();
//                        return redirect()->back()->with('success', 'Image Send Successfully');
                    }
                }
            }
//            return redirect()->back()->with('success', 'Images send successfully');
        }

    }
}
