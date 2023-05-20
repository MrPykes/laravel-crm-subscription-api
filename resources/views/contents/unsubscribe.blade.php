@extends('layouts.dashboard')

@section('content')

<!-- Main content -->
<div class="container">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <form method="POST" action="{{ route('unsubscribe') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="subscriber-list" class="form-label">Subscribe List Id</label>
                            <input type="text" name="subscriber_id" class="form-control" id="subscriber-list" placeholder="Subscribe List Id">
                        </div>
                        <button type="submit" class="btn btn-primary">Unsubscribe</button>
                    </form>
                </section>
            </div>
        </div>
    </section>
</div>

@endsection