<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class TestController extends Controller
{
    public function test()
    {
        return response()->json(auth()->id());
    }

    public function tradingNews()
    {
        $client = new Client();
        $url = 'https://www.forexfactory.com/calendar';

        try {
            // Fetch the page content
            $response = $client->get($url);
            $html = (string) $response->getBody();

            // Load the HTML into the Crawler
            $crawler = new Crawler($html);

            // Select table rows
            $rows = $crawler->filter('.calendar__table .calendar__row');

            $data = [];

            $rows->each(function (Crawler $row) use (&$data) {
                // Check if impact level is "High Impact Expected"
                $impact = $row->filter('.calendar__impact span[title="High Impact Expected"]');
                if ($impact->count() === 0) {
                    return; // Skip this row
                }

                // Extract data
                $date = $row->filter('.date')->count() ? trim($row->filter('.date')->text()) : '';
                $time = $row->filter('.calendar__time')->count() ? trim($row->filter('.calendar__time')->text()) : '';
                $currency = $row->filter('.calendar__currency')->count() ? trim($row->filter('.calendar__currency')->text()) : '';
                $eventTitle = $row->filter('.calendar__event-title')->count() ? trim($row->filter('.calendar__event-title')->text()) : '';

                // Only include if currency is USD
                if ($currency === 'USD') {
                    $data[] = [
                        'date' => $date,
                        'time' => $time,
                        'currency' => $currency,
                        'event' => $eventTitle
                    ];
                }
            });

            return $data;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
