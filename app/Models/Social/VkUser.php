<?php

namespace App\Models\Social;

use App\Enums\StreamType;
use Illuminate\Database\Eloquent\Model;

class VkUser extends Model
{
    protected $guarded = ['id'];


    public function attach(StreamType $type) : bool
    {
        $column = $type->attachmentColumn();
        if (!$column) {
            return false;
        }
        $this->update([
            $column => true,
        ]);
        return true;
    }
    public function detach(StreamType $type) : bool
    {
        $column = $type->attachmentColumn();
        if (!$column) {
            return false;
        }
        $this->update([
            $column => false,
        ]);
        return true;
    }
}
