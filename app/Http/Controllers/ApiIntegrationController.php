<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redis;
use Session;

class ApiIntegrationController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect(route('api.authors'));
        } else {
            return view('login');
        }
    }
    public function index(Request $request)
    {

        $this->validate($request, [
            'required' => 'email',
            'required' => 'password',
        ]);

        $email = $request->email;
        $password = $request->password;

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($credentials),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response);


        if (isset($data->token_key)) {
            $user = User::updateOrCreate(
                ['email' => $data->user->email],
                [
                    'name' => $data->user->first_name . " - " . $data->user->last_name,
                    'email' => $data->user->email,
                    'password' => 'N/A',
                    'first_name' => $data->user->first_name,
                    'last_name' => $data->user->last_name,
                    'gender' => $data->user->gender,
                    'active' => $data->user->active,
                    'token_key' => $data->token_key,
                    'refresh_token_key' => $data->refresh_token_key,
                    'expires_at' => $data->expires_at,
                    'login_token' => $data->user->email,
                    'password_reset_token' => $data->user->email,
                ]
            );

            Auth::login($user);
            return redirect(route('api.authors'));
        } else {
            return redirect(route('login'))->with('error', 'invalid credentials.');
        }
    }

    public function authors()
    {
        $data = $this->get_authors();
        return view('authors', compact('data'));
    }
    public function get_authors()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/authors',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $authors = json_decode($response);
        return  $authors->items ? $authors->items : [];
    }

    public function author_delete($author_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/authors/' . $author_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return redirect(route('api.authors'))->with('success', 'Author deleted');
    }

    public function single($author_id)
    {
        $books_data = [];
        if (count($this->books())) {
            $books = $this->books();
            foreach ($books as $index => $book) {
                $single_book_data = $this->single_book($book->id);
                if ($single_book_data->author) {

                    if ($single_book_data->author->id == $author_id) {
                        array_push($books_data, $book);
                    }
                }
            }
        } else {
            $books_data = [];
        }
        return view('single-author', compact('books_data', 'author_id'));
    }

    public function books()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/books?orderBy=id&direction=ASC&limit=12&page=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $books = json_decode($response);
        $data = $books->items ? $books->items : [];
        return $data;
    }
    public function single_book($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/books/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function book_delete($book_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/books/' . $book_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return redirect(route('api.authors'))->with('success', 'book ash been delete');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
    public function profile()
    {
        return view('profile');
    }
    public function add_book()
    {
        $authors = $this->get_authors();
        return view('add-book', compact('authors'));
    }
    public function store_book(Request $request)
    {
        $this->validate($request, [
            'required' => 'author',
            'required' => 'title',
            'required' => 'release_date',
            'required' => 'description',
        ]);

        $input_data = [
            'author' => ['id' => $request->author],
            'title' => $request->title,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'isbn' => "string",
            'format' => "string",
            'number_of_pages' => 0
        ];


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://symfony-skeleton.q-tests.com/api/v2/books',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($input_data),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: ' . Auth::user()->token_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return redirect(route('api.authors'))->with('success', 'book has been created');
    }
}
