<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
use App\Page;
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
        $page = new Page;
        $calculations = $page->Calculate();
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
        // $p = new Page;
        // $p->url = $url;
        // $p->save();
        // $page = Page::where('url', '==', $url)->get();
        $data   = array('value' => 'some data', 'input' => Request::input());

  // return a JSON response
        return  Response::json($data);
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
    public function show()
    {
        $page = new Page;
        $average_posts_per_day = $page->AveragePostsPerDay();
        $min_posts_per_day = $page->MinPostsPerDay();
        $max_posts_per_day = $page->MaxPostsPerDay();
        // return view('calculate')->with('average_posts_per_day', $average_posts_per_day);
        return view('calculate')->with('average_posts_per_day', $average_posts_per_day)->with('min_posts_per_day', $min_posts_per_day)->with('max_posts_per_day', $max_posts_per_day);
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
