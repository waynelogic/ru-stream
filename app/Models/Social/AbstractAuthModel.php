<?php namespace App\Models\Social;

use App\Enums\StreamType;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class AbstractAuthModel extends Model {
    protected $guarded = ['id'];

    protected $appends = ['view_name', 'view_avatar'];

    public function beforeDeleteStream(): bool
    {
        return true;
    }

    abstract public function getViewNameAttribute() : string;
    abstract public function getViewAvatarAttribute() : string;
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
    public function scopeWithStreams($builder, StreamType $type)
    {
        return $builder->with('streams.video');
    }

    public function streams() : MorphMany
    {
        return $this->morphMany(Stream::class, 'streamable');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
