<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;

class BookController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [new Middleware('auth:sanctum')];
    }
    protected $books;
    protected $s3Client;
    public function __construct(){
        $this ->books = new Book();
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'http' => [
                'verify' => false,  
            ],
        ]);
    }
    public function index()
    {
        try {
            return response()->json([
                'success' => true,
                'books' => $this->books->all(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }

    }
    public function store(Request $request)
    {
        $request->merge([
            'upload_to_s3' => filter_var($request->input('upload_to_s3', false), FILTER_VALIDATE_BOOLEAN)
        ]);
    
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:10240', // 10 Mo max
            'upload_to_s3' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $pdf = $request->file('pdf');
        $filePath = $pdf->getPathname(); 
        $fileName = $pdf->getClientOriginalName();
        if ($request->upload_to_s3) {
            $result = $this->s3Client->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => 'books/' . $fileName, 
                'SourceFile' => $filePath,          
            ]);
            $pdfPath = $result['ObjectURL'];

        } else {
           
            $pdfPath = $pdf->store('books', 'public');
        }
       
       $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'pdf_path' => $pdfPath,
            'is_uploaded_to_s3'=>  $request->upload_to_s3,
            
        ]);

        return response()->json(['book' => $book,'pdf'=>$pdfPath], 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json(['book' => $book]);
    }
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);
    
        Log::info('Data receive :', [
            'title' => $request->input('title'),
            'author' => $request->input('author')
        ]);
        $book->update([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
        ]);
    
        Log::info('Data response :', [
            'title' => $book->title,
            'author' => $book->author
        ]);

        return response()->json(['book' => $book]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        Storage::delete($book->pdf_path);
        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }
}
