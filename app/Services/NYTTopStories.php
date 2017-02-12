<?php

namespace App\Services;

use GuzzleHttp\Client;

class NYTTopStories
{
    const MOVIES = 'movies';

    /**
     * Format URL based on section.
     *
     * @param  string $section
     * @return void
     */
    private static function formatUrl($section)
    {
      return 'https://api.nytimes.com/svc/topstories/v2/' . $section . '.json';
    }

    /**
     * Fetch top stories.
     *
     * @param  string $url
     * @return void
     */
    private static function fetch($url)
    {
      $client = new Client();

      $response = $client->get($url, [
        'query' => ['api-key' => env('NYT_KEY')]
      ]);

      return json_decode($response->getBody(), true);
    }

    /**
     * Fetch top stories from section Movies.
     *
     * @return void
     */
    public static function fetchFromMovies()
    {
      $url = self::formatUrl(self::MOVIES);
      return self::fetch($url);
    }
}
