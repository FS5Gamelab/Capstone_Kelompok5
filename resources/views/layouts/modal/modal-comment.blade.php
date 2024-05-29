<div class="modal fade" id="modal-comment" tabindex="-1" role="dialog" aria-labelledby="modalOrderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrderLabel">Product Comment</h5>

            </div>
            <div class="modal-body tw-text-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="tw-w-full">
                            <div class="row">
                                <div class="col-12">
                                    <div id="basic">
                                    </div>
                                </div>
                                <div class="row tw-flex tw-items-center mt-3">
                                    <div class="col-12">
                                        <textarea name="comment" id="comment" placeholder="comment"
                                            class="tw-border tw-rounded-lg tw-px-3 py-2 mt-1 text-start tw-text-sm tw-w-full dark:tw-bg-gray-700 tw-text-black dark:tw-text-white focus:tw-border-blue-500 focus:tw-ring-4 focus:tw-ring-blue-500"></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button id="btn-submit" class="btn btn-primary btn-sm !tw-mr-3">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary !tw-text-black dark:!tw-text-white"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/pages/rater-js.js'])
