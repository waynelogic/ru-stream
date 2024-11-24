<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Waynelogic\FilamentCms\Database\Traits\Sortable;

class Instruction extends Model
{
    use Sortable;
    protected $casts = [
        'active' => 'boolean',
    ];

    protected $appends = ['frame_src'];
    public function getFrameSrcAttribute()
    {
        if (empty($this->video_url)) {
            return null;
        }
        $result = explode('_', substr($this->video_url, strlen("https://vk.com/video-")));

        return "https://vk.com/video_ext.php?oid=-$result[0]&id=$result[1]&hd=2";
    }
}
