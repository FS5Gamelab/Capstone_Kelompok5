<?php

namespace App\Livewire;

use App\Events\SendRealtimeMessage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class RealtimeMessage extends Component
{
    use LivewireAlert;
    public string $message;

    public function triggerEvent(): void
    {
        event(new SendRealtimeMessage($this->message));
        $this->message = '';
    }
    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleRealtimeMessage($message): void
    {
        // dd($message['message']);
        $this->alert('success', $message['message']);
    }
    public function render()
    {
        return view('livewire.realtime-message');
    }
}
