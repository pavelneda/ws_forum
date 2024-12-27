<?php

namespace App\Jobs;

use App\Events\StoreMessageEvent;
use App\Models\Image;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessMessageJob implements ShouldQueue
{
    use Queueable;

    private $message;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $data)
    {
        //
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ids = User::getCleanedUserIds($this->data);
        $imgIds = getIds($this->data, '/img_id=[\d]+/', '/img_id=/');

        broadcast(new StoreMessageEvent($this->message))->toOthers();

        $ids->each(function ($id) {
            NotificationService::store($this->message, 'You have a new answer', $id);
        });

        Image::updateMessageId($imgIds, $this->message);

        Image::cleanFromStorage();

        Image::deleteFromTable();

        $this->message->answeredUsers()->attach($ids);
    }
}
