<div class="support-ticket-details" id="supportTicketList">
    <h1 class="mb-6">Support <a href="#" class="btn btn-dark float-right" onclick="$('#addTicketForm').toggleClass('d-none')">Add Ticket</a></h1>
    <div class="add-ticket-form mt-6 mb-6 d-none" id="addTicketForm">
        <h3>Add Ticket</h3>
        <form action="{{sproute('ticket.add')}}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="Enter a title" required>
            </div>
            <div class="form-group">
                <textarea name="note" id="note" class="form-control" rows="5" placeholder="Ticket details note"></textarea>
            </div>
            <div class="form-group">
                <input type="file" name="upload_file[]" accept="video/*,image/*,.xlsx,.xls,.csv" class="form-control-file" multiple>
            </div>
            <button type="submit" class="btn btn-dark">Submit</button>
        </form>
    </div>
    @include('support::ticket_list', ['tickets'=>$sp_tickets])
    <h2 class="text-center my-4">Closed Tickets</h2>
    @include('support::ticket_list', ['tickets'=>$sp_closed_tickets])
</div>
