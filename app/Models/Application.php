<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    public const STATUSES = ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'];

    protected $fillable = ['job_listing_id', 'user_id', 'resume_path', 'cover_letter', 'status'];

    public function job(): BelongsTo       { return $this->belongsTo(JobListing::class, 'job_listing_id'); }
    public function candidate(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'reviewed'    => 'bg-sky-100 text-sky-800',
            'shortlisted' => 'bg-teal-100 text-teal-800',
            'hired'       => 'bg-emerald-100 text-emerald-800',
            'rejected'    => 'bg-rose-100 text-rose-800',
            default       => 'bg-slate-100 text-slate-700',
        };
    }
}
