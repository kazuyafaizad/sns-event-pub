<?php

namespace App\Models;

use Ansezz\Gamify\Point;
use App\Traits\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, HasProfilePhoto;

    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'profile';

    /**
     * {@inheritdoc}
     */
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'fullname',
        'mobile_number',
        'profile_photo_path',
        'address1',
        'address2',
        'postcode',
        'city',
        'state',
        'email',
        'mobile_number',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $guarded = [];

    /**
     * Function to update Profile and User models
     *
     * @return object|bool
     */
    public function modify($data)
    {
        $user_data = ['email' => $data['email']];
        unset($data['email']);

        $user = User::where('id', $this->user_id)->first();

        $point = Point::find(1);

        // or via HasBadge trait method
        $user->achievePoint($point);

        return ($this->update($data) && $user->update($user_data)) ? true : false;
    }

    /**
     * DB Relational connection from Profile -> User model
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
