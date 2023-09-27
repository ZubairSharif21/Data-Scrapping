<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class YtController extends Controller
{
    function index()
    {
      try{

        $username = 'CapitalTVLive';

        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $client = new Client();

        $response = $client->request('GET', "https://instagram-statistics-api.p.rapidapi.com/community?url=https%3A%2F%2Fwww.youtube.com%2F$username%2F", [
            'headers' => [
                'X-RapidAPI-Host' => 'instagram-statistics-api.p.rapidapi.com',
                'X-RapidAPI-Key' => '12719f3efdmshd4fbb4b5d90b36fp19bb47jsna07d98516475',
            ],
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            return response()->json(['error' => 'Failed to retrieve data from Instagram statistics API'], $statusCode);
        }

        $data = json_decode($response->getBody(), true);

        if ($data && isset($data['data'])) {
            $response = $data['data'];

            $result = [];

            if (isset($response['avgViews'])) {
                $result['AVG Views'] = $this->formatNumber($response['avgViews']);
            }

            if (isset($response['usersCount'])) {
                $result['Total Subscribers'] = $this->formatNumber($response['usersCount']);
            }

            if (isset($response['avgVideoLikes'])) {
                $result['AVG Video Likes'] = $this->formatNumber($response['avgVideoLikes']);
            }

            if (empty($result)) {
                return response()->json(['error' => 'No valid data found.'], 404);
            }
            return response()->json($result);
        } else {
            return response()->json(['error' => 'No data found.'], 404);
        }
    }catch(Exception $e){
        return response()->json(['error' => $e->getMessage()], 500);
    }


    }
    private function formatNumber($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 2) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 2) . 'K';
        } else {
            return $number;
        }
    }
    }
        // if (isset($data['data'])) {
        //     $userData = $data['data'];

        //     // Iterate through the array and display all key-value pairs
        //     foreach ($userData as $key => $value) {
        //         if (is_array($value)) {
        //             // If the value is an array, convert it to a JSON string for display
        //             echo "$key: " . json_encode($value) . "<br>";
        //         } else {
        //             // If the value is not an array, display it as-is
        //             echo "$key: $value<br>";
        //         }
        //     }
        // } else {
        //     echo "No data found.";
        // }
        // if ($data && isset($data['data'])) {
        //     $likes = $data['data']['avgLikes'];
        //     $views = $data['data']['avgViews'];
        //     $followers = $data['data']['usersCount'];
        //     $avgVideoLikes = $data['data']['avgVideoLikes'];
        //     $posts = count($data['data']['lastPosts']);
        //     // $posts = count($data['data']['lastPosts']);
        //     // $avgInteractions = $data['data']['avgInteractions'];

        //     // Output the results
        //     echo "Avg Likes: $likes<br><br>";
        //     echo "Total SubScribers: $followers<br><br>";
        //     echo "Total views: $views<br><br>";
        //     echo "Total avgVideoLikes: $avgVideoLikes<br><br>";
        //     // echo "This Week Posts: $posts\n";
        //     // echo "This Week avgInteractions: $avgInteractions<br><br>";
        // } else {
        //     echo "Failed to retrieve data from Instagram statistics API.";
        // }
        // echo $response->getBody();
//
    // }
// }
