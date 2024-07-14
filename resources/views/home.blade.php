<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Eventify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .navbar {
            flex-shrink: 0;
        }
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1;
            overflow-y: auto;
        }
        .pagination {
            justify-content: center;
        }
        .pagination .page-item .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            margin: 0 2px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .sort-asc::after {
            content: ' \25B2';
        }
        .sort-desc::after {
            content: ' \25BC';
        }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <div class="content">
        <div class="container mt-5">
            <h1>Events</h1>
            <form class="search-bar" method="GET" action="{{ route('home') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search events" value="{{ $search }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" data-sort="name">Event Name</th>
                        <th scope="col" data-sort="start_date">Start Date</th>
                        <th scope="col" data-sort="end_date">End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->start_date }}</td>
                            <td>{{ $event->end_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    {{ $events->appends(['sort' => $sortField, 'order' => $sortOrder, 'search' => $search])->links() }}
                </ul>
            </nav>

            {{-- @auth
                <a href="{{ route('myEvents') }}" class="btn btn-info mt-4">View My Events</a>
            @endauth --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const currentSort = urlParams.get('sort') || 'start_date';
            const currentOrder = urlParams.get('order') || 'asc';

            const headers = document.querySelectorAll('.table thead th');
            headers.forEach(header => {
                header.addEventListener('click', function() {
                    let sort = this.getAttribute('data-sort');
                    let order = 'asc';
                    if (currentSort === sort && currentOrder === 'asc') {
                        order = 'desc';
                    }

                    window.location.href = `?sort=${sort}&order=${order}&search=${urlParams.get('search') || ''}`;
                });

                if (header.getAttribute('data-sort') === currentSort) {
                    header.classList.add(currentOrder === 'asc' ? 'sort-asc' : 'sort-desc');
                }
            });
        });
    </script>
</body>
</html>
