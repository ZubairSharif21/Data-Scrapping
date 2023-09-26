<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler; // Import the Crawler class

class ScraperController extends Controller
{
    public function index()
    {
        $client = new Client();
        $website = $client->request('GET', 'https://www.instagram.com/zubair_sharif_261/');
        $htmlContent = $website->getBody()->getContents();

        try {
            // Use regular expressions to extract the counts
            $postCount = $this->extractCount($htmlContent, 'Posts');
            $followerCount = $this->extractCount($htmlContent, 'Followers');
            $followingCount = $this->extractCount($htmlContent, 'Following');

            // Create an array with the extracted values
            $data = [
                'posts' => $postCount,
                'followers' => $followerCount,
                'following' => $followingCount,
            ];

            // Convert the array to JSON and return it as a response
            return $data;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Helper function to extract counts using regular expressions
    private function extractCount($html, $label)
    {
        $pattern = '/"' . $label . '":\{"count":(\d+)/';
        preg_match($pattern, $html, $matches);
        return isset($matches[1]) ? $matches[1] : 0;
    }
}






