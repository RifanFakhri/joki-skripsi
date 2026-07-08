@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Discharging Card System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #0056b3, #007bff);">
    <div class="container-fluid">
      <span class="navbar-brand fw-bold">🚢 Discharging Card System</span>
    </div>
  </nav>

  <div class="container mt-4">
    <h4 class="fw-bold mb-3 text-primary">Daftar Container (API)</h4>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped shadow-sm">
      <thead class="table-primary">
        <tr>
          <th>No</th>
          <th>No Container</th>
          <th>Vessel</th>
          <th>Voyage</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item['no_container'] }}</td>
          <td>{{ $item['vessel_name'] }}</td>
          <td>{{ $item['voyage'] }}</td>
          <td>
            <span class="badge {{ $item['status'] == 'Sudah Gate Out' ? 'bg-success' : 'bg-warning text-dark' }}">
              {{ $item['status'] }}
            </span>
          </td>
          <td>
            <a href="{{ route('discharge.edit', $item['id']) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('discharge.confirm', $item['id']) }}" method="POST" style="display:inline-block;">
              @csrf
              <button class="btn btn-sm btn-success">Konfirmasi</button>
            </form>
            <a href="{{ route('discharge.print', $item['id']) }}" class="btn btn-sm btn-secondary">Print</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>

</body>
</html>
