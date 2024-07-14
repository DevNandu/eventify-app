<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events - Eventify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .top-button {
            margin-top: 20px;
        }
        .actions {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center top-button">
            <h1>My Events</h1>
            <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
        </div>

        <form class="search-bar mt-3" method="GET" action="{{ route('myEvents') }}">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search events" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-hover mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Event Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col" class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userEvents as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td class="actions">
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $userEvents->links() }}
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
