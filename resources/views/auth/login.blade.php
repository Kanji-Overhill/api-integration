<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Interlan ERP | Pago Efectivo</title>
  </head>
  <body>
     <div class="container">
         <div class="row justify-content-center align-items-center" style="height: 100vh;">
             <div class="col-md-3">
                <img src="{{ url('logo.png') }}" alt="" class="img-fluid">
                             <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            

                            <x-input id="email" class="block mt-1 w-full w-100" placeholder="Email" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            

                            <x-input id="password" class="w-100 block mt-1 w-full"
                                            type="password"
                                            placeholder="Contraseña"
                                            name="password"
                                            required autocomplete="current-password" />
                        </div>
                        <div class="flex items-center justify-content-center d-flex mt-4">
                            <x-button class="ml-3 btn btn-primary">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>               
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