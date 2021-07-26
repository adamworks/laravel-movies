<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Movie\MovieService;
use App\Foundation\Validation\FormValidationException;

class MovieController extends Controller
{

    protected $movieService;

    public function __construct(
        MovieService $movie
    ){
        $this->movieService = $movie;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$page=1)
    {
        $data = $request->search;
        $info = [];
        
        if(isset($request)){
            $info['current_page'] = $page;
            $info['search'] = $data;
            $info['prev'] = $info['current_page']-1;
            $info['next'] = $info['current_page']+1;

            try {
                $movies = $this->movieService->searchMovie($data,$page);
                //dd($movies->Search);
                return view('movie.index',compact('movies','info'));
                //return successResponse("successfull", $movies);
            } catch (FormValidationException $exception){
                return $exception->getResponse("failed to retrive");
            }
        } else {
            return view('movie.index');
        }

        //return view('movie.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
