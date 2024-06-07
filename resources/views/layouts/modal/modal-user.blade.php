<div class="modal fade" id="modal-order" tabindex="-1" role="dialog" aria-labelledby="modalOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrderLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body tw-text-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 tw-font-bold">
                                        Qty
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 !tw-text-xs">
                                    </div>
                                    <div class="col-md-6 tw-font-bold">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center tw-justify-between" id="cart-items">
                            <!-- Cart items will be injected here -->
                        </div>
                        <div class="row d-flex align-items-center tw-justify-between !tw-mt-5">
                            <div class="col-md-4 text-muted">Note</div>
                            <div class="col-md-8 text-end" id="note"></div>
                        </div>

                        <div class="!tw-mt-5" id="cancel" style="display: none;">
                            <div class="row d-flex align-items-center tw-justify-between">
                                <div class="col-md-4 text-muted">Cancel Reason</div>
                                <div class="col-md-8 text-end" id="reason"></div>
                            </div>
                        </div>

                        <div
                            class="row d-flex align-items-center tw-justify-between mb-2 !tw-mt-10 tw-border-t tw-border-b py-2">
                            <div class="col-md-4">Total</div>
                            <div class="col-md-8 text-end !tw-font-bold" id="total-price"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('button[data-dismiss="modal"]').click(function() {
        $("#modal-order").modal("hide");
    });
</script>
