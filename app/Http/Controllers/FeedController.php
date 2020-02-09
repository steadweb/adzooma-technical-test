<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Redirect;
use App\Feed;
use App\Rss\Feed as RssFeed;

class FeedController extends Controller
{
    /**
     * Create a new FeedController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of feeds.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = [];
        $feeds = Feed::orderBy('id', 'asc')->get();

        foreach($feeds as $feed) {
            $rssFeed = new RssFeed($feed->url);
            $items = array_merge($items, $rssFeed->getItems());
        }

        usort($items, function($a, $b) {
            return strtotime($a->getPublishDate()) < strtotime($b->getPublishDate());
        });

        return view("feeds/feed", ["feed" => $items]);
    }

    /**
     * Show the form for creating a new Feed.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feeds = Feed::orderBy('id', 'asc')->get();

        return view("feeds/manage", ["feeds" => $feeds]);
    }

    /**
     * Store a newly created Feed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // URL is required, and should be "active"
            $request->validate([
                'url' => 'required|active_url|unique:App\Feed,url'
            ]);

            // If the URL is active, see if it parses as actual XML
            // simplexml_load_file will throw an exception
            // ----------------------------------------------------
            // @todo This should be a custom validation rule so that
            // it populates the form if it fails
            simplexml_load_file($request->input("url"));

            $data = $request->all();
            $data['user_id'] = $request->user('web')->id;

            Feed::create($data);

            return Redirect::to('feeds/create')->with('success','Feed added successfully');
        } catch(\ErrorException $e) {
            Log::warning('Invalid URL passed or unable to parse as XML: ' . $request->input("url"));
        }

        return Redirect::to('feeds/create')->with('error','Invalid RSS URL. Please make sure you supply a valid RSS URL');
    }

    /**
     * Remove the specified Feed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feed::where('id', $id)->delete();

        return Redirect::to('feeds/create')->with('success','Feed deleted successfully');
    }
}
