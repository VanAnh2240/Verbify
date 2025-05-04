<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\book;
use App\Models\Genre;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ShopControllerNotSafe extends Controller
{
    private function filterBooks(Request $request){
        $selectedGenres = $request->input('genres', []);
        $selectedYears = $request->input('release_year', []);
        $selectedPrice = $request->input('price', '');
        $sortOption = $request->input('sort', 'Newest');

        //$query = book::with('genres', 'images')->where('IS_SELLING', 'SELLING');
        $sql= "
        SELECT DISTINCT b.*, bi.IMAGE_LINK
        FROM book b
        LEFT JOIN book_belong bb ON b.book_id = bb.book_id
        LEFT JOIN (
            SELECT BOOK_ID,  MIN(IMAGE_LINK) AS IMAGE_LINK
            FROM book_image
            GROUP BY BOOK_ID
        ) bi ON b.BOOK_ID = bi.BOOK_ID
        WHERE b.IS_SELLING = 'SELLING'";
        
        /* if (!empty($selectedGenres)) {
            $query->whereHas('genres', function ($q) use ($selectedGenres) {
                $q->whereIn('genres.GENRES_NAME', $selectedGenres);
            });
        } */
        if (!empty($selectedGenres)) {
            $genresList = implode(',', array_map(fn($g) => "'".addslashes(trim($g))."'", explode(',', $selectedGenres[0])));
            $sql .= " AND bb.genres_name IN ($genresList)";
        }

        /* if (!empty($selectedYears)) {
            $query->whereIn('RELEASE_YEAR', $selectedYears);
        } */
        if (!empty($selectedYears)) {
            $yearsList = implode(',', $selectedYears); // Không có bảo vệ, dễ bị SQL Injection
            $sql .= " AND b.RELEASE_YEAR IN ($yearsList)";
        }

        /* if (!empty($selectedPrice)) {
            [$min, $max] = explode('-', $selectedPrice);
            $query->whereBetween('PRICE', [(float)$min, (float)$max]);
        } */
        if (!empty($selectedPrice)) {
            [$min, $max] = explode('-', $selectedPrice);
            $min = (float) $min;
            $max = (float) $max;
        
            $sql .= " AND b.PRICE BETWEEN $min AND $max";
        }

        /* switch ($sortOption) {
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
        } */
        switch ($sortOption) {
            case 'Price (low to high)':
                $sql .= " ORDER BY b.PRICE ASC";
                break;
            case 'Price (high to low)':
                $sql .= " ORDER BY b.PRICE DESC";
                break;
            case 'Most popular':
                $sql .= " ORDER BY b.PRICE DESC";
                break;
            default:
                $sql .= " ORDER BY b.RELEASE_YEAR DESC";
        }
        
        /*return $query;*/
        //dd($sql);
        return $sql; 

    }
    public function index(Request $request)
    {
        //$genres = Genre::all();
        $genres = DB::select("SELECT * FROM genres");

        //$releaseYears = book::select('RELEASE_YEAR')->distinct()->orderBy('RELEASE_YEAR', 'desc')->get();
        $releaseYears = DB::select("SELECT DISTINCT RELEASE_YEAR FROM book ORDER BY RELEASE_YEAR DESC");

        //$books = ShopController::filterBooks($request)->paginate(12);
        $query = $this->filterBooks($request);
        
        $totalBooks = count(DB::select($query));
        
        $perPage = 12;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";

        $books = DB::select($query);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $books, // Các sách trong trang hiện tại
            $totalBooks, // Tổng số sách
            $perPage, // Số sách trên mỗi trang
            $page, // Trang hiện tại
            ['path' => $request->url(), 'query' => $request->query()] // Đường dẫn cho các liên kết phân trang
        );

        //$selectedPrice = $request->input('price', '');
        $selectedPrice = $request->input('price', '');

        //dd($query);
        return view('shop.indexNotSafe', compact('books', 'genres', 'releaseYears', 'selectedPrice','paginator'));
    }
    public function filter(Request $request)
    {
        $query = $this->filterBooks($request);
        $books = DB::select($query);
        
        //$books = ShopController::filterBooks($request)->get();
        return response()->json([
            'html' => view('shop.books', compact('books'))->render(),
        ]);
    }
    
    public function search(Request $request)
    {
        $keySearch = $request->input('search');
    
        $perPage = 12;
        $currentPage = $request->input('page', 1); // Mặc định trang là 1 nếu không có tham số page
        $offset = ($currentPage - 1) * $perPage;
    
        // Truy vấn lấy danh sách sách
        $query = "SELECT * FROM book b LEFT JOIN (
            SELECT BOOK_ID,  MIN(IMAGE_LINK) AS IMAGE_LINK
            FROM book_image
            GROUP BY BOOK_ID
        ) bi ON b.BOOK_ID = bi.BOOK_ID
        WHERE b.IS_SELLING = 'SELLING' AND b.NAME LIKE '%" . $keySearch . "%' LIMIT " . $perPage . " OFFSET " . $offset;
        $books = DB::select($query);
    
        // Truy vấn lấy thể loại và năm phát hành
        $genres = DB::select('SELECT * FROM genres');
        $releaseYears = DB::select('SELECT DISTINCT RELEASE_YEAR FROM book ORDER BY RELEASE_YEAR DESC');
        $selectedPrice = "";
    
        // Truy vấn số lượng tổng sách
        $countQuery = "SELECT COUNT(*) as total FROM book WHERE NAME LIKE '%" . $keySearch . "%'";
        $totalBooks = DB::select($countQuery);
        $totalBooks = $totalBooks[0]->total;
        $totalPages = ceil($totalBooks / $perPage); 
    
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $books, 
            $totalBooks, 
            $perPage, 
            $currentPage, 
            ['path' => $request->url(), 'query' => $request->query()] 
        );
        
        //dd($query);
        return view('shop.indexNotSafe', compact('books', 'genres', 'releaseYears', 'selectedPrice', 'paginator'))
               ->with('keySearch', $keySearch);
    }
        
}
