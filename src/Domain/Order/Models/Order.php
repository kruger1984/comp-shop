<?php

namespace Domain\Order\Models;

use Domain\Auth\Models\User;
use Domain\Order\Enums\OrderStatuses;
use Domain\Order\QueryBuilders\OrderQueryBuilder;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\PriceCast;


/**
 * @method static Order|OrderQueryBuilder query()
 *
 */
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'delivery_type_id',
        'payment_method_id',
        'amount',
        'status',
    ];

    protected $attributes = [
        'status' => 'new'
    ];

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => OrderStatuses::from($value)->createState($this)
        );
    }

    protected $casts = [
        'amount' => PriceCast::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderCustomer(): HasOne
    {
        return $this->hasOne(OrderCustomer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function newEloquentBuilder($query): OrderQueryBuilder
    {
        return new OrderQueryBuilder($query);
    }

}
