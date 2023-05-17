  @extends('layouts.dashboard')

  @section('content')

  <!-- Main content -->
  <div class="container">
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                  <section class="col-lg-12">
                      <form method="POST" action="{{ route('update') }}">
                          @csrf
                          <div class="mb-3">
                              <label for="subscriber-list" class="form-label">Subscribe List Id</label>
                              <input type="text" name="subscriber_list" class="form-control" id="subscriber-list" value="{{ $subscriber_list }}">
                          </div>
                          <div class="mb-3">
                              <label for="unsubscriber-list" class="form-label">Unsubscribe List Ids</label>
                              <input type="text" name="unsubscriber_list" class="form-control" id="unsubscriber-list" value="{{ $unsubscriber_list }}">
                          </div>
                          <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                          <input name="id" type="hidden" value="{{ $id }}" />
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                  </section>
              </div>
          </div>
      </section>
  </div>

  @endsection