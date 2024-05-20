<div>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col">
                <h2 class="mb-4">Realtime Message</h2>
                <form class="form" wire:submit.prevent="triggerEvent">
                    <input type="text" class="form-control" wire:model="message">
                    <input type="submit" class="btn btn-primary mt-3">
                </form>
            </div>
        </div>
    </div>
</div>
