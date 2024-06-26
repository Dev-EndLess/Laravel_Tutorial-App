<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Band extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'ticket', 'location', 'website', 'email', 'description', 'tags', 'logo'];

  public function scopeFilter($query, array $filters)
  {
    if ($filters["tag"] ?? false) {
      $query->where("tags", "like", "%" . request('tag') . "%");
    }

    if ($filters["search"] ?? false) {
      $query->where("name", "like", "%" . request('search') . "%")
        ->orWhere("tags", "like", "%" . request("search") . "%")
        ->orWhere("location", "like", "%" . request("search") . "%");
    }
  }

  // Relationships to User
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}