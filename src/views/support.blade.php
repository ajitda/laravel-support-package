@php 
// echo config('support.layout');
// exit;

@endphp
@extends(config('support.layout'))
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="support-ticket-container py-8">
                @include('support::all_tickets')
            </div>
        </div>
    </div>
</div>
@endsection
