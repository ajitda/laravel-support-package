<div class="support-ticket-details" id="supportTicketList">
<a href="javascript:;" class="btn btn-dark btn-sm" data-ajax-url="{{route(config('support.support_path_prefix'))}}" >Back To Tickets</a>
    <div class="mt-6">
        <div class="row" >
            <div class="col-9">
                <h3>{{$sp_ticket->title}}</h3>
                <small>Created on {{$sp_ticket->created_at->format('m/d/Y')}}</small>
            </div>
            <div class="col-3">
                <h5 class="text-right">{{$sp_ticket->closed == 0 ? 'Open' : 'Closed'}}
                </h5>
                <form class="text-right" action="{{sproute('ticket.add_note', $sp_ticket->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="{{$sp_ticket->closed}}">
                    <input type="hidden" name="action" value="close_ticket" />
                    <button type="submit" class="btn btn-dark btn-sm">{{$sp_ticket->closed == 0 ? 'Close Ticket' : 'Re-Open Ticket' }}</button>
                </form>
            </div>
        </div>
    </div>
    @if ($sp_ticket->closed == 0)
    <form method="POST" action='{{sproute('ticket.add_note', $sp_ticket->id)}}' class="mt-3" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ticket_note">Ticket note</label>
                <textarea rows='5' class="form-control textarea-tinymce" id="ticket_note" name="note" ></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="upload_file[]" accept="video/*,image/*,.xlsx,.xls,.csv" class="form-control-file" multiple>
            </div>
            <button type="submit" class="btn btn-info mt-2 mb-4 submit_note_class" name="add_ticket_note">Submit Note</button>
        </form>
    @endif
    @if($sp_ticket->ticketNotes->count() > 0)
        @foreach($sp_ticket->ticketNotes->SortByDesc('created_at') as $note) 
        <div class="card mt-3">
            <div class="card-body border-grey">
                <h4 style="margin-bottom:0">
                @php $support_admin_col = config('support.support_admin'); @endphp
                @if (auth()->user()->$support_admin_col == 1)
                     {{auth()->user()->id == $note->user_id ? 'Support' :$note->user->name}}
                @else
                    {{auth()->user()->id == $note->user_id ? 'Me' : 'Support'}}
                @endif
                </h4>
                <small>{{$note->created_at->format('m/d/Y')}}</small><br/>
                {{$note->note}}
                <div class="row">
                    @if (!empty($note->noteFiles))
                    @foreach($note->noteFiles as $file)
                    <div class="col-12">
                        {!! $file->getLink() !!}
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>