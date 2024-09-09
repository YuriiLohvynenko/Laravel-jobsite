<?php

namespace App;

use App\Models\Badge;
use App\Models\Bookmark;
use App\Models\Dispute;
use App\Models\Feedback;
use App\Models\Listing;
use App\Models\ListingBudget;
use App\Models\Shift;
use App\Models\ListingTextAlert;
use App\Models\Message;
use App\Models\Offer;
use App\Models\UserBadge;
use App\Models\UserDetail;
use App\Models\UserSpecialities;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'username', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image($size= 80, $d = 'mm')
    {
//        print_r($this->attributes['image']);
////        dd($this->attributes['image']);
//        exit;
        if(is_null($this->attributes['image'])){
//            $url = 'https://www.gravatar.com/avatar/' . md5( strtolower( trim( $this->attributes['email'] ) ) ) . '?d='.$d.'&s='. $size;
            $url = asset('images/user-avatar-placeholder.png');

        }else{
            $url = asset('storage/avatar/'.$this->attributes['image']);
        }

        return $url;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function detail(){
        return $this->hasOne(UserDetail::class);
    }

    public function specialties(){
        return $this->hasMany(UserSpecialities::class);
    }

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    public function recievedFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'people_id');
    }

    public function listings(){
        return $this->hasMany(Listing::class);
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class);
    }
	
	public function offer()
    {
        return $this->hasMany(offer::class);
    }
	
	public function ListingBudget()
    {
        return $this->hasMany(ListingBudget::class);
    }
	
	public function Shift()
    {
        return $this->hasMany(Shift::class);
    }

    public function assignedListings()
    {
        return $this->hasMany(Listing::class)->where('status', 'accepted');
    }

    public function cancelledListings()
    {
        return $this->hasMany(Listing::class)->where('status', 'rejected');
    }

    public function acceptedOffers()
    {
        return $this->hasMany(Offer::class)->where('status', 'accepted');
    }

    public function rejectedOffers()
    {
        return $this->hasMany(Offer::class)->where('status', 'rejected');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function badge(){
        return $this->hasMany(UserBadge::class, 'user_id', 'id')->where('status', 'verified');
    }

    public function bookmarks(){
        return $this->hasMany(Bookmark::class, 'user_id', 'id')->whereNull('listing_id');
    }

    public function onSiteAlert(){
        return $this->hasOne(ListingTextAlert::class, 'user_id', 'id')->where('listing_type', 'on-site');
    }

    public function remoteAlert(){
        return $this->hasOne(ListingTextAlert::class, 'user_id', 'id')->where('listing_type', 'remote');
    }

    public function get_specialties($specialties){
        $spc = [];
        foreach($specialties as $specialty){
            $spc[] = $specialty->specialty->name;
        }
        return implode(', ', $spc);
    }

    public function checkBookmark(){
        $user = auth()->guard('job-seeker')->user();
        if($user){
            $check = Bookmark::where('people_id', $this->id)->where('user_id', $user->id)->first();
            if($check){
                return true;
            }
        }

        return false;
    }

    public function userRating(){
            $check = Feedback::where('people_id', $this->id)->get();

            if($check){
                $totalRecords = count($check);
                $totalRating = $check->sum('rating');
                if($totalRating > 0 && $totalRecords > 0) {
                    $rating = $totalRating/$totalRecords;
                    return number_format((float)$rating, 1, '.', '');
                }
            }

           return 0.00;
    }

    public function userBadge()
    {
//        return $this->badge->where('status', 'verified')->pluck('badge_id')->toArray();
        return $this->badge->pluck('badge_id')->toArray();
    }
}
