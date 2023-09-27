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
                'X-RapidAPI-Host' => config('services.rapidapi.host'),
                'X-RapidAPI-Key' => config('services.rapidapi.key'),
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
