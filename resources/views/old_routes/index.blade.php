<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Routes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>All Registered Routes</h1>
    <div class="">
        <a href="{{ route('admin.routes.insert') }}" class="btn btn-primary">Insert Routes into Permissions</a>

    </div>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>URI</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($routes as $route)
                <tr>
                    <td>{{ $route['method'] }}</td>
                    <td>{{ $route['uri'] }}</td>
                    <td>{{ $route['name'] ?? '-' }}</td>
                    <td>{{ $route['action'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
