<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TikTokController extends Controller
{
    function index(){

        $client = new Client();
        try{
        $username = 'therock'; // Replace with your desired username

        $response = $client->request('GET', "https://instagram-statistics-api.p.rapidapi.com/community?url=https%3A%2F%2Fwww.tiktok.com%2F$username%2F", [
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
                $result['AVG Views'] = $response['avgViews'];
            }

            if (isset($response['usersCount'])) {
                $result['Total Subscribers'] = $response['usersCount'];
            }

            if (isset($response['avgVideoLikes'])) {
                $result['AVG Video Likes'] = $response['avgVideoLikes'];
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
}
