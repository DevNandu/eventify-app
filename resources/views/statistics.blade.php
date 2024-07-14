<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - Eventify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <div class="container content">
        <h1>Statistics</h1>

        <div class="mt-4">
            <h3>Average Events Count</h3>
            <p>The average number of events created per user is: <strong>{{ number_format($averageEventsPerUser, 2) }}</strong></p>
        </div>

        <div class="mt-4">
            <h3>Average Events Created by Each User</h3>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">User Name</th>
                        <th scope="col">Event Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersWithEventCounts as $user)
                        <tr>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->event_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
