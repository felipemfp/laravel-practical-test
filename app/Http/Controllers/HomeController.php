<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Facet;
use App\Models\Multimedia;
use Illuminate\Http\Request;
use App\Services\NYTTopStories;

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
        $data = NYTTopStories::fetchFromMovies();

        foreach ($data['results'] as $result) {
          if (array_key_exists('short_url', $result)) {
            $story = Story::firstOrNew(['short_url' => $result['short_url']]);
          }
          else {
            $story = Story::firstOrNew(['url' => $result['url']]);
          }

          $story->fill($result);
          $story->updated_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result['updated_date']);
          $story->created_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result['created_date']);
          $story->published_date = \DateTime::createFromFormat('Y-m-d\TH:i:se', $result['published_date']);

          $story->multimedia()->delete();
          $story->facets()->delete();

          $story->save();

          foreach ($result['multimedia'] as $media) {
              $multimedia = new Multimedia();
              $multimedia->fill($media);
              $multimedia->story_id = $story->id;
              $multimedia->save();
          }

          foreach($result['des_facet'] as $des_facet) {
            $facet = new Facet();
            $facet->value = $des_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::DES;
            $facet->save();
          }

          foreach($result['org_facet'] as $org_facet) {
            $facet = new Facet();
            $facet->value = $org_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::ORG;
            $facet->save();
          }

          foreach($result['per_facet'] as $per_facet) {
            $facet = new Facet();
            $facet->value = $per_facet;
            $facet->story_id = $story->id;
            $facet->type = Facet::PER;
            $facet->save();
          }

          foreach($result['geo_facet'] as $geo_facet) {
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
