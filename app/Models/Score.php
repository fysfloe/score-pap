<?php

namespace App\Models;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'file_path',
        'title',
        'author',
        'lineup',
        'type',
        'era',
        'genre',
        'severity',
    ];

    public function toElasticsearchDocumentArray(): array
    {
        return $this->attributes;
    }
}
