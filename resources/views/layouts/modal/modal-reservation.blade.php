<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Edit Reservation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group mandatory">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" readonly>
                    </div>
                    <div class="form-group mandatory">
                        <label for="people" class="form-label">People</label>
                        <input type="number" name="people" id="people" class="form-control">
                    </div>
                    <div class="form-group mandatory">
                        <label for="table" class="form-label">Table No</label>
                        <select name="table" id="table" class="form-control form-select">
                            <option value="" hidden>Select Table</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control form-select text-capitalize">
                            <option value="" disabled>Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="form-group mandatory">
                        <label for="date-choose" class="form-label">Date</label>
                        <input type="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.."
                            id="date-choose">
                    </div>
                    <div class="form-group mandatory">
                        <label for="time-choose" class="form-label">Time</label>
                        <input type="time" class="form-control mb-3 flatpickr-time-picker"
                            placeholder="Select time.." id="time-choose">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-update" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('button').attr('data-dismiss', 'modal').click(function() {
        $("#tambahModal").modal("hide");
        $("#ubahModal").modal("hide");
    });
</script>
