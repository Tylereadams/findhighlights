<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Highlights;
use GuzzleHttp\RequestOptions;

class CommandUploadTweetsToGfycat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fh:upload-tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload tweets to gyfcat and save the gyfcat code';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }

    public static function uploadTweets()
    {
        $highlights = Highlights::whereNull('gfycat_code')
            ->whereNotNull('downloaded')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        if(!$highlights) {
            return "No highlights.\n";
        }

        $finishedCount = Highlights::whereNotNull('gfycat_code')->count();
        $totalCount = Highlights::count();

        echo $finishedCount." / ". $totalCount." completed. ".round(($finishedCount / $totalCount) * 100)."% \n";
        $client = new \GuzzleHttp\Client();

        foreach($highlights as $highlight) {

            $response = $client->request('POST', 'https://api.gfycat.com/v1/gfycats', [
                RequestOptions::JSON => [
                    'fetchUrl' => $highlight->url(),
                    'title' => '',
                    'description' => '',
                ]
            ]);
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if($response->gfyname) {
                $highlight->gfycat_code = $response->gfyname;
                $highlight->save();
                echo "saved: ".$highlight->gfycat_code."\n";
            }
        }

    }
}