<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoPost extends Model
{
    use HasFactory;
    protected $table = 'info_posts';

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'post_status',
        'comment_status'
    ];
    /**
     * Get the post that owns the InfoPost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
