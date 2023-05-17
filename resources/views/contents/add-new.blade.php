  @extends('layouts.dashboard')

  @section('content')

  <!-- Main content -->
  <div class="container">
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <section class="col-lg-12 connectedSortable">
                      <form method="POST" action="{{ route('store') }}">
                          @csrf
                          <div class="mb-3">
                              <label for="subscriber-list" class="form-label">Subscribe List Id</label>
                              <input type="text" name="subscriber_list" class="form-control" id="subscriber-list" placeholder="Subscribe List Id">
                          </div>
                          <div class="mb-3">
                              <label for="unsubscriber-list" class="form-label">Unsubscribe List Ids</label>
                              <input type="text" name="unsubscriber_list" class="form-control" id="unsubscriber-list" placeholder="Unsubscribe List Ids (comma separated)">
                          </div>
                          <div class="mb-3">
                              <label for="aweber-unsubscribe-list" class="form-label">Aweber Unsubscribe List Ids</label>
                              <input type="text" name="aweber_unsubscribe_list" class="form-control" id="aweber-unsubscribe-list" placeholder="Aweber Unsubscribe List Ids (comma separated)">
                          </div>
                          <div class="mb-3">
                              <label for="getresponse-list" class="form-label">Getresponse List Ids</label>
                              <input type="text" name="getresponse_list" class="form-control" id="getresponse-list" placeholder="Getresponse List Ids (comma separated)">
                          </div>
                          <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                  </section>
              </div>
          </div>
      </section>
  </div>

  @endsection