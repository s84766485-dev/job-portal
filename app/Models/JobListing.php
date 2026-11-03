<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    protected $table = 'job_listings';

    public const TYPES  = ['Full-time', 'Part-time', 'Contract', 'Internship', 'Remote'];
    public const LEVELS = ['Entry', 'Mid', 'Senior', 'Lead'];

    protected $fillable = [
        'company_id', 'category_id', 'title', 'slug', 'description', 'requirements',
        'location', 'type', 'level', 'salary_min', 'salary_max', 'deadline',
        'status', 'is_featured',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_featured' => 'boolean',
    ];

    public function company(): BelongsTo   { return $this->belongsTo(Company::class); }
    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }
    public function applications(): HasMany { return $this->hasMany(Application::class); }

    /** Published and not past its deadline. */
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')
                 ->where(fn ($w) => $w->whereNull('deadline')->orWhere('deadline', '>=', today()));
    }

    public function scopeFilter(Builder $q, array $f): Builder
    {
        return $q
            ->when($f['q'] ?? null, fn ($q, $v) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%{$v}%")
                ->orWhere('description', 'like', "%{$v}%")
                ->orWhereHas('company', fn ($c) => $c->where('name', 'like', "%{$v}%"))))
            ->when($f['location'] ?? null, fn ($q, $v) => $q->where('location', 'like', "%{$v}%"))
            ->when($f['category'] ?? null, fn ($q, $v) => $q->where('category_id', $v))
            ->when($f['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($f['level'] ?? null, fn ($q, $v) => $q->where('level', $v));
    }

    public function isOpen(): bool
    {
        return $this->status === 'published' && (! $this->deadline || $this->deadline->gte(today()));
    }

    public function getSalaryRangeAttribute(): ?string
    {
        if (! $this->salary_min && ! $this->salary_max) {
            return null;
        }
        $fmt = fn ($n) => number_format($n);
        if ($this->salary_min && $this->salary_max) {
            return $fmt($this->salary_min).' – '.$fmt($this->salary_max);
        }
        return $this->salary_min ? 'From '.$fmt($this->salary_min) : 'Up to '.$fmt($this->salary_max);
    }
}
