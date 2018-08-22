<?php

namespace App\Listeners;

use App\Lib\Utils;
use App\Model\DB\Images;
use Overtrue\LaravelUEditor\Events\Uploaded;

class UEditorUploaded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Uploaded  $event
     * @return void
     */
    public function handle(Uploaded $event)
    {
        // SUCCESS
        $images = new Images();
        $state = $event->result['state'];
        if ($state != 'SUCCESS') {
            Utils::Log('Upload fail!');
            return;
        }

        //  /uploads/image/2018/08/22/6192191aba04b0c212f044fc5e4194b2.png
        $url = $event->result['title'];
        $images->MarkUploadedImage($url, session('mark'), session('user'));
    }
}
