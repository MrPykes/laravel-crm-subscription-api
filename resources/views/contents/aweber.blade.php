  @extends('layouts.dashboard')

  @section('content')

  <!-- Main content -->
  <div class="container">
      <table class="table">
          <thead class="table-dark">
              <tr>
                  <th>No</th>
                  <th>Subscriber Idt</th>
                  <th>Name</th>
                  <th>Email</th>
              </tr>
          </thead>
          <tbody>
              @foreach($contacts as $key => $contact)
              <tr>
                  <th> {{ $key }}</th>
                  <th> {{ $contact['id'] }}</th>
                  <th> {{ $contact['name'] }}</th>
                  <th> {{ $contact['email'] }}</th>
                  </th>
              </tr>

              @endforeach
          </tbody>
      </table>
  </div>
  @endsection