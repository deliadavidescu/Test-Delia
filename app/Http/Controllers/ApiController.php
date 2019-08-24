<?php

namespace App\Http\Controllers;

use App\Books;
use App\Author;
use App\Http\Resources\BooksResource;
use Illuminate\Http\Request;

class ApiController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $books = Books::with('author')->get()->sortByDesc('created_at');
        return BooksResource::collection($books);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $input = $request->all();
        $request->validate([
            'authorName' => 'required|min:3',
            'bookTitle' => 'required|min:3',
            'age' => 'required',
            'address' => 'required|min:5',
            'date' => 'required',
        ]);

        $author = Author::create([
            'name' => $input["authorName"],
            'age' => (int) $input["age"],
            'address' => $input["address"],
        ]);
        Books::create([
            'name' => $input["bookTitle"],
            'author_id' => $author->id,
            "release_date" => date('Y-m-d', strtotime($input["date"])),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Books $books
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Books $books) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Books $books
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Books $books) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Books $books
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $books) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $book = Books::findOrFail($id);
        $book ->delete();

        return response()->json(null, 204);



    }
}
