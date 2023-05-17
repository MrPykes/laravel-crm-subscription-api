  @extends('layouts.dashboard')

  @section('content')

  <!-- Main content -->
  <div class="container">
      <table class="table">
          <thead class="table-dark">
              <tr>
                  <th>No</th>
                  <th>Subscriber List</th>
                  <th>Unsubscriber List</th>
                  <th>Aweber Unsubscribe List</th>
                  <th>Getresponse List</th>
                  <th width="100px">Action</th>
              </tr>
          </thead>
          <tbody>
              @foreach($subscribers as $subscriber)
              <tr>
                  <th> {{ $subscriber->id }}</th>
                  <th> {{ $subscriber->subscriber_list }}</th>
                  <th> {{ $subscriber->unsubscriber_list }}</th>
                  <th> {{ $subscriber->aweber_unsubscribe_list }}</th>
                  <th> {{ $subscriber->getresponse_list }}</th>
                  <th> <a class="btn btn-info" href="/edit/{{ $subscriber->id }}">Edit</a>
                      <a class="btn btn-danger" href="/delete/{{ $subscriber->id }}">Delete</a>
                  </th>
              </tr>

              @endforeach
          </tbody>
      </table>
  </div>
  @endsection