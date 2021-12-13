<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Interlan - Pago Efectivo</title>
  </head>
  <body>
    
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-3 text-center">
          <img src="{{ url('logo.png') }}" alt="" class="img-fluid">
          <form action="{{ route('generateCip') }}" method="post">
            @csrf
            <div class="form-group">
              <input type="text" class="form-control" id="factura" name="factura" placeholder="ID Factura ERP">
            </div>
            <div class="form-group text-center">
              <input type="submit" value="Generar CIP" class="btn btn-primary">
            </div>
          </form>   
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>Cip</th>
                <th>Estatus</th>
                <th>Amount</th>
                <th>Id Factura</th>
                <th>Id Cliente</th>
                <th>Email</th>
                <th>Name</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($pagos as $pago)
                  <tr>
                    <td scope="row">{{ $pago->id }}</td>
                    <td>{{ $pago->estatus }}</td>
                    <td>{{ $pago->amount }}</td>
                    <td>{{ $pago->transactionCode }}</td>
                    <td>{{ $pago->userDocumentNumber }}</td>
                    <td>{{ $pago->userEmail }}</td>
                    <td>{{ $pago->userName }}</td>
                    <td>{{ $pago->userPhone }}</td>
                  </tr>
                @endforeach
            </tbody>
          </table>     
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>