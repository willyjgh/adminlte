{{-- edit modal --}}
<div class="modal fade" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <!-- form start -->
        <form action="{{ route('update.actor.details') }}" method="post" id="edit-form">
            {{-- @csrf --}}
            <input type="hidden" name="actor_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">First name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name">
                            <span class="text-danger error-text first_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label">Last name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name">
                            <span class="text-danger error-text last_name_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
