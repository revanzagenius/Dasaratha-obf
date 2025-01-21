<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Subdomain</title>
</head>
<body>
    <h1>Daftar Subdomain untuk {{ $search }}</h1>

    @if (!empty($records))
        <table border="1">
            <thead>
                <tr>
                    <th>Subdomain</th>
                    <th>First Seen</th>
                    <th>Last Seen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record['domain'] }}</td>
                        <td>{{ date('Y-m-d H:i:s', $record['firstSeen']) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $record['lastSeen']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada subdomain ditemukan.</p>
    @endif
</body>
</html>
