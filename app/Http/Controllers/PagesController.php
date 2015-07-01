<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
use App\Page;
use App\Calculate;
use App\TimeRecommendation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
        /**
     * Calculations
     *
     * @return Response
     */
    public function calculate($id)
    {
        $calc = new Calculate;
        $calculations = $calc->Runner();
        return $calculations;   
        
    }

    public function highestaverage($id)
    {
        $recommended = new TimeRecommendation;
        $calculations = $recommended->HighestAverage();
        return $calculations;   
        
    }

    public function totals($id)
    {
        $recommended = new TimeRecommendation;
        $calculations = $recommended->sortedData;
        return $calculations;   
        
    }

        public function hourlytotals($id)
    {
        $recommended = new TimeRecommendation;
        $calculations = $recommended->hourlyTotals;
        return $calculations;   
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($url)
    {   
        $page = Page::where('url', $url)->get();
        return $page;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // $page = new Page;
        // $average_posts_per_day = $page->PostsPerDay();
        // $min_posts_per_day = $page->MinPostsPerDay();
        // $max_posts_per_day = $page->MaxPostsPerDay();
        // return view('calculate')->with('average_posts_per_day', $average_posts_per_day)->with('min_posts_per_day', $min_posts_per_day)->with('max_posts_per_day', $max_posts_per_day);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Page::destroy($id);
    }
}
