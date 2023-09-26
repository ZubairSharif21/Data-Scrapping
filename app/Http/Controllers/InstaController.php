<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class InstaController extends Controller
{
    public function index()
    {
        $client = new Client();

        $username = 'karanaujla_official'; // Replace with your desired username

        $response = $client->request('GET', "https://instagram-statistics-api.p.rapidapi.com/community?url=https%3A%2F%2Fwww.instagram.com%2F$username%2F", [
            'headers' => [
                'X-RapidAPI-Host' => 'instagram-statistics-api.p.rapidapi.com',
                'X-RapidAPI-Key' => '12719f3efdmshd4fbb4b5d90b36fp19bb47jsna07d98516475',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        if ($data && isset($data['data'])) {
            $likes = $data['data']['avgLikes'];
            $followers = $data['data']['usersCount'];
            $posts = count($data['data']['lastPosts']);
            $posts = count($data['data']['lastPosts']);
            $avgInteractions = $data['data']['avgInteractions'];

            // Output the results
            echo "Avg Likes: $likes\n";
            echo "Total Followers: $followers\n";
            echo "This Week Posts: $posts\n";
            echo "This Week avgInteractions: $avgInteractions\n";
        } else {
            echo "Failed to retrieve data from Instagram statistics API.";
        }
    }
}
