<!-- resources/views/list.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>List Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Author Details</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('authors') }}">Authors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <div class="col-md-5">
            <dt>First Name:</dt>
        </div>
            
        <div class="col-md-5">
            <dd>{{$data['first_name']}}</dd>
        </div>

    <div class="col-md-5">
            <b>Last Name:</b>
    </div>
    <div class="col-md-5">
            <p>{{$data['last_name']}}</p>
    </div>

    <div class="col-md-5">
            <b>DOB:</b>
    </div>
    <div class="col-md-5">
            <p>{{date('d/M/Y', strtotime($data['birthday']))}}</p>
    </div>
    <div class="col-md-5">
            <b>Gender:</b>
    </div>
    <div class="col-md-5">
            <p>{{$data['gender']}}</p>
    </div>
    <div class="col-md-5">
            <b>Place:</b>
    </div>
    <div class="col-md-5">
            <p>{{$data['place_of_birth']}}</p>
    </div>
    <div class="col-md-5">
            <b>Biography:</b>
    </div>
    <div class="col-md-5">
            <p>{{$data['biography']}}</p>
        </dl>
    </div>
    </div>
    </div>

    <div class="container mt-5">
        <h2>Author Books</h2>
       <div class="col-md-12"> <a class="btn btn-sm btn-info pull-right" href="{{ route('add_book') }}">Add Book</a> </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Release Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through your data and display each row -->
                @foreach($data['books'] as $row)
                    <tr>
                        <td>{{ $row['title'] }}</td>
                        <td>{{ $row['description'] }}</td>
                        <td>{{ date('d/M/Y', strtotime($row['release_date'])) }}</td>
                        <td><a href="{{ route('delete_book',  ['id' => $row['id'], 'auther_id' => $data['id']]) }}" >Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
