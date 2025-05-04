<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\book;
use App\Models\Genre;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    private function filterBooks(Request $request){
        $selectedGenres = $request->input('genres', []);
        $selectedYears = $request->input('release_year', []);
        $selectedPrice = $request->input('price', '');
        $sortOption = $request->input('sort', 'Newest');

        $query = book::with('genres', 'images')->where('IS_SELLING', 'SELLING');

        if (!empty($selectedGenres)) {
            $query->whereHas('genres', function ($q) use ($selectedGenres) {
                $q->whereIn('genres.GENRES_NAME', $selectedGenres);
            });
        }

        if (!empty($selectedYears)) {
            $query->whereIn('RELEASE_YEAR', $selectedYears);
        }

        if (!empty($selectedPrice)) {
            [$min, $max] = explode('-', $selectedPrice);
            $query->whereBetween('PRICE', [(float)$min, (float)$max]);
        }

        switch ($sortOption) {
            case 'Price (low to high)':
                $query->orderBy('PRICE', 'asc');
                break;
            case 'Price (high to low)':
                $query->orderBy('PRICE', 'desc');
                break;
            case 'Most popular':
                $query->orderBy('PRICE', 'desc');
                break;
            default:
                $query->orderBy('RELEASE_YEAR', 'desc');
        }
        return $query;
    }
    public function index(Request $request)
    {
        $genres = Genre::all();
        $releaseYears = book::select('RELEASE_YEAR')->distinct()->orderBy('RELEASE_YEAR', 'desc')->get();

        $books = ShopController::filterBooks($request)->paginate(12);


        $selectedPrice = $request->input('price', '');
        return view('shop.index', compact('books', 'genres', 'releaseYears', 'selectedPrice'));
    }
    public function filter(Request $request)
    {
        $books = ShopController::filterBooks($request)->get();
        return response()->json([
            'html' => view('shop.books', compact('books'))->render(),
        ]);
    }
    public function search(Request $request)
    {
        $keySearch = $request->input('search');

        $books = book::where('IS_SELLING', 'SELLING')->where('NAME', 'like', '%' . $keySearch . '%')->paginate(12);
        $selectedPrice = "";
        $genres = Genre::all();
        $releaseYears = book::select('RELEASE_YEAR')->distinct()->orderBy('RELEASE_YEAR', 'desc')->get();

        return view('shop.index', compact('books', 'genres', 'releaseYears', 'selectedPrice'))->with('keySearch', $keySearch);
    }

}
