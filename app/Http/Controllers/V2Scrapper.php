<?php

namespace App\Http\Controllers;

use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class V2Scrapper extends Controller
{
    public function index()
    {
        $client = new Client();
        $website = $client->request('GET', 'https://www.instagram.com/zubair_sharif_261/');
        $htmlContent = $website->getBody()->getContents();
        $crawler = new Crawler($htmlContent);
        try {
            $title = $crawler->filter('._aa_y _aa_z _aa_-')->text();
            $response = response()->make($htmlContent);
            return $title ;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }

    }
}





