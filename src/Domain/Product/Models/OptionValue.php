<?php

namespace Domain\Product\Models;

use Domain\Order\Models\OrderItem;
use Domain\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'option_id'
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
    public function newCollection(array $models = []): OptionValueCollection
    {
        return new OptionValueCollection($models);
    }
}
