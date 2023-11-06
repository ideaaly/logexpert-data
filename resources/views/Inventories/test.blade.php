<!DOCTYPE html>
<html>
<head>
    <title>Liste des Inventaires</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <h2>Liste des Inventairess</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type de propriété</th>
                <th>Status</th>
                <th>Expert</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
            <tr>
                <td>{{ $inventory->tenant->last_name }}</td>
                <td>{{ $inventory->property->country }}</td>
                <td>{{ $inventory->status }}</td>
            </tr>
            @endforeach
            

        </tbody>
    </table>
    {{ $inventories->links('pagination::bootstrap-5') }}

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>