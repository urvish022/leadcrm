<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenGraph;
use App\Models\{UpworkFeed,User};
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpworkSlackNotification;

class UpworkFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $urls = ["https://www.upwork.com/ab/feed/jobs/rss?q=Laravel&sort=recency&verified_payment_only=1&paging=0%3B10&api_params=1&securityToken=b67cf35559df6b9166e95b7816ede60b3daafadd9bb56f36a54e913fa175f2b2f57a5d76d2ac87e2fe25c42035a94a0133ff6a8442f2df9d6a85967877739a55&userUid=745261048028684288&orgUid=745261048028684290","https://www.upwork.com/ab/feed/jobs/rss?q=angular+%26+laravel&sort=recency&verified_payment_only=1&paging=0%3B50&api_params=1&securityToken=b67cf35559df6b9166e95b7816ede60b3daafadd9bb56f36a54e913fa175f2b2f57a5d76d2ac87e2fe25c42035a94a0133ff6a8442f2df9d6a85967877739a55&userUid=745261048028684288&orgUid=745261048028684290"];
        foreach($urls as $url){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $xml = simplexml_load_string($response);
            $user = User::find(1);

            if(!empty($xml)){
                foreach($xml->channel->item as $val){
                    if(UpworkFeed::where('link',$val->link)->count() == 0){
                        UpworkFeed::create(['link'=>$val->link,'title'=>$val->title,'description'=>$val->description]);
                        $user->notify(new UpworkSlackNotification($val->title,$val->description,$val->link));
                    }
                }
            }
        }
    }
}
