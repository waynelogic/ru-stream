<?php namespace App\Concerns;

use App\Models\Certificate;
use App\Models\PromoCode;
use App\Models\Social\VkUser;
use App\Models\Story;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Waynelogic\FilamentCms\Database\Traits\Sluggable;

trait Client
{
    use Sluggable;

//    protected $appends = [
//        'profile_photo_url',
//        'referral_link',
//    ];

    public $slugs = [
        'login' => 'email_login',
    ];
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'email_login',
//        'login',
//    ];

    public function getReferralLinkAttribute(): string
    {
        return url()->route('home') . '?ref=' . $this->login;
    }

    public function getEmailLoginAttribute(): string
    {
        return trim(strstr($this->email,'@',true));
    }

    public function referred() : HasMany
    {
        return $this->hasMany(User::class, 'partner_id');
    }

    public function promo_codes() : BelongsToMany
    {
        return $this
            ->belongsToMany(PromoCode::class, 'promo_code_user', 'user_id', 'promo_code_id')
            ->withTimestamps();
    }
    public function certificates() : BelongsToMany
    {
        return $this->belongsToMany(Certificate::class, 'certificate_user', 'user_id', 'certificate_id')
            ->withPivot('is_used', 'options');
    }


    public function partner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }
    public function subscriptions() : HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function videos() : HasMany
    {
        return $this->hasMany(Video::class);
    }
    public function stories() : HasMany
    {
        return $this->hasMany(Story::class);
    }
    public function vk_user(): HasMany
    {
        return $this->hasMany(VkUser::class);
    }
}
