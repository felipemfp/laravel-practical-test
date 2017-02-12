<?php

namespace App\Http\Controllers;

use App\Story;
use App\Facet;
use App\Multimedia;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['stories' => Story::orderBy('published_date', 'desc')->paginate(7)]);
    }

    /**
     * Fetch and save top stories.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $client = new Client();
        $response = $client->get('https://api.nytimes.com/svc/topstories/v2/movies.json', [
          'query' => ['api-key' => env('NYT_KEY')]
        ]);
        $json = json_decode($response->getBody());

        foreach ($json->results as $result) {
          $story = Story::firstOrNew(['short_url' => $result->short_url]);

          $story->fill((array) $result);
          $story->updated_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result->updated_date);
          $story->created_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result->created_date);
          $story->published_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result->published_date);

          $story->multimedia()->delete();
          $story->facets()->delete();

          $story->save();

          foreach ($result->multimedia as $media) {
              $multimedia = new Multimedia();
              $multimedia->fill((array) $media);
              $multimedia->story_id = $story->id;
              $multimedia->save();
          }

          foreach($result->des_facet as $des_facet) {
            $facet = new Facet();
            $facet->value = $des_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::DES;
            $facet->save();
          }

          foreach($result->org_facet as $org_facet) {
            $facet = new Facet();
            $facet->value = $org_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::ORG;
            $facet->save();
          }

          foreach($result->per_facet as $per_facet) {
            $facet = new Facet();
            $facet->value = $per_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::PER;
            $facet->save();
          }

          foreach($result->geo_facet as $geo_facet) {
            $facet = new Facet();
            $facet->value = $geo_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::GEO;
            $facet->save();
          }
        }

        return response()->json([
          'success' => true
        ]);
    }
}
