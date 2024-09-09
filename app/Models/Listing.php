<?php

namespace App\Models;

use App\Observers\ListingObserver;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Listing extends Model
{
    use Notifiable;
    protected $table = 'listings';

    protected $dates = ['date_time', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        static::observe(ListingObserver::class);

    }

    public function feedback(){
        return $this->hasOne(Feedback::class, 'listing_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->hasMany(ListingFile::class);
    }

    public function budgetDetails()
    {
        return $this->hasMany(ListingBudget::class);
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function offer()
    {
        return $this->hasMany(Offer::class);
    }
    public function selected_offer()
    {
        $user = auth()->guard('job-seeker')->user();
        return $this->hasOne(Offer::class)->where('user_id', $user->id);
    }

    public function dispute()
    {
        return $this->hasOne(Dispute::class);
    }

    public function offers()
    {
        return $this->hasOne(Offer::class);
    }

    public function selectedOffers()
    {
        return $this->hasOne(Offer::class)->where('status', 'accepted');
    }

    public function freelance_feedback()
    {
        $user = auth()->guard('job-seeker')->user();
        return $this->hasOne(Feedback::class, 'listing_id', 'id')->where('feedbacks.type_as', 'freelancer')->where('feedbacks.user_id', $user->id);
    }

    public function freelance_client()
    {
        $user = auth()->guard('job-seeker')->user();
        return $this->hasOne(Feedback::class, 'listing_id', 'id')->where('feedbacks.type_as', 'client')->where('feedbacks.user_id', $user->id);
    }

    public function firstimage($id)
    {   
		$imgUrl = asset('images/no-image-available.png');

       $image =  ListingFile::where('listing_id', $id)->where(function ($query) {
               $query->orWhere('file_format', 'jpeg');
               $query->orWhere('file_format', 'jpg');
               $query->orWhere('file_format', 'png');
           })->orderBy('created_at', 'asc')->first();
       if($image){
           $imgUrl = asset('../storage/app/public/listing-files/'.$image->file_name.'.'.$image->file_format);
       }
        return $imgUrl;
    }

    public function checkBookmark(){
        $user = auth()->guard('job-seeker')->user();
        if($user){
            $check = Bookmark::where('listing_id', $this->id)->where('user_id', $user->id)->first();
            if($check){
                return true;
            }
        }
        return false;
    }
    public function getLocationAttribute(){
        if($this->job_location == 'on_location'){
            return 'On-Site';
        }
        return 'Remote';
    }

    public static function acceptedOffer($listID){
        $list = Offer::where('listing_id', $listID)->where('status', 'accepted')->first();
        return $list;
    }
    public function checkCompleted(){
       $budget =  ListingBudget::where('listing_id', $this->id)->where('status', 'pending')->count();
        if($budget == 0){
            return true;
        }
            return false;
    }
    public function checkReviewByClient(){
        $user = auth()->guard('job-seeker')->user();
       $feedback =  Feedback::where('listing_id', $this->id)->where('user_id', $user->id)->count();
        if($feedback != 0){
            return true;
        }
            return false;
    }
}
