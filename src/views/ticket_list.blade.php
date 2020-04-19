@foreach($tickets as $ticket)
<div class="card mt-3">
    <div class="card-body border-grey p-5" style="margin-bottom:0px">
        <div class="row">
            <div class="col-sm-10">
            <h3 class="mb-0"><a href="javascript:;" data-ajax-url="{{sproute('ticket.show', $ticket->id)}}" >{{$ticket->title}}</a></h3>
            <small>{{$ticket->created_at->format('m/d/Y')}} </small>
            </div>
            <div class="col-sm-2 ">
                @php $status = $ticket->closed ? 'Closed' : 'Open'; @endphp
                <h4 class="text-right"><span class="{{ $status}}">{{$status}}</span></h4>
            </div>
        </div>
    </div>
</div>
@endforeach