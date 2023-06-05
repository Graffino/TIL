<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Post extends Model
{

    use HasFactory;
    use Notifiable;

    protected $fillable = [
      'title', 'body', 'slug', 'likes', 'max_likes'. 'tweeted_at', 'developer_id', 'channel_id', 'seo', 'description',
       'canonical_url', 'social_image_url'
    ];

    public static $bodyMaxWords = 200;
    public static $titleMaxChars = 50;

    public function routeNotificationForSlack()
    {
        return env('SLACK_POST_ENDPOINT');
    }

    public function developer()
    {
        return $this->belongsTo('App\Developer');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public static function slugifyTitle($title)
    {
        return Str::slug($title, '-');
    }
}
