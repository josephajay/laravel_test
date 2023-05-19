<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = [
            'email' => trim($request->input('email')),
            'password' => trim($request->input('password')),
        ];

        $client = new Client();

        $response = $client->post('https://candidate-testing.api.royal-apps.io/api/v2/token', [
            'json' => $credentials,
        ]);

        $data = json_decode($response->getBody(), true);
        //dd($data);
        $accessToken = $data['token_key'];
        $refreshToken = $data['refresh_token_key'];

        //storing it in the session:
        $request->session()->put('access_token', $accessToken);
        $request->session()->put('refresh_token', $refreshToken);
        $request->session()->put('user', $data['user']);

        return redirect('/dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function getAuthors()
    {
        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->get('https://candidate-testing.api.royal-apps.io/api/v2/authors?orderBy=id&direction=ASC&limit=12&page=1', [
            'headers' => $headers,
        ]);
        
        $data = json_decode($response->getBody(), true);

        $result = [];
        foreach($data['items'] as $val){
            $response = $client->get('https://candidate-testing.api.royal-apps.io/api/v2/authors/'.$val['id'], [
                'headers' => $headers,
            ]);
            $temp_data = json_decode($response->getBody(), true);
            $val['books'] = $temp_data['books'];
            $result[] = $val;
        }

        return view('authors', ['data'=>$result]);
    }

    public function authorDetails($id)
    {
        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->get('https://candidate-testing.api.royal-apps.io/api/v2/authors/'.$id, [
            'headers' => $headers,
        ]);
        
        $data = json_decode($response->getBody(), true);
        return view('author_details', ['data'=>$data]);
    }

    public function deleteAuthor($id)
    {
        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->delete('https://candidate-testing.api.royal-apps.io/api/v2/authors/'.$id, [
            'headers' => $headers,
        ]);
        
        $data = json_decode($response->getBody(), true);
        if($data == null){
            return redirect('/authors'); 
        }
    }

    public function deleteBook($id, $author_id)
    {
        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->delete('https://candidate-testing.api.royal-apps.io/api/v2/books/'.$id, [
            'headers' => $headers,
        ]);
        
        $data = json_decode($response->getBody(), true);
        if($data == null){
            return redirect('/author/view/'.$author_id); 
        }
    }

    public function logout()
    {
        session()->forget(['token_key', 'refresh_token_key', 'user']);
        return redirect('/');
    }

    public function addBook()
    {
        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->get('https://candidate-testing.api.royal-apps.io/api/v2/authors?orderBy=id&direction=ASC&limit=12&page=1', [
            'headers' => $headers,
        ]);
        
        $data = json_decode($response->getBody(), true);
        return view('add_book', ['data'=> $data['items']]);
    }

    public function addNewBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_id'     => 'required',
            'title'         => 'required',
            'release_date'  => 'required|date',
            'description'   => 'required',
            'isbn'          => 'required',
            'format'        => 'required',
            'number_of_pages' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('add_book')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = [
            'author' => [
                'id' => $request->input('author_id'),
            ],
            'title' => $request->input('title'),
            'release_date' => $request->input('release_date'),
            'description' => $request->input('description'),
            'isbn' => $request->input('isbn'),
            'format' => $request->input('format'),
            'number_of_pages' => (int)$request->input('number_of_pages'),
        ];

        $client = new Client();
        $token = session('access_token');
        
        $headers = [
            'Authorization' => $token,
            'Accept' => 'application/json',
        ];

        $response = $client->post('https://candidate-testing.api.royal-apps.io/api/v2/books', [
            'json' => $credentials,
            'headers' => $headers,
        ]);

        $data = json_decode($response->getBody(), true);
        return redirect('/authors');
    }

}
