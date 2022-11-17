<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Subtotal implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // １つの購入履歴における複数の商品ごとの価格がsubtotal
        // そのため、この後にidでグループ化すると１回の購入での料金がわかる
        $sql = 'select purchases.id as id
        , items.id as item_id
        , item_purchase.id as pivot_id
        , items.price * item_purchase.quantity as subtotal
        , customers.name as customer_name
        , customers.id as customer_id
        , items.name as item_name
        , items.price as item_price
        , item_purchase.quantity
        , purchases.status
        , purchases.created_at
        , purchases.updated_at
        from purchases
        left join item_purchase on purchases.id = item_purchase.purchase_id
        left join items on item_purchase.item_id = items.id
        left join customers on purchases.customer_id = customers.id
        ';
        $builder->fromSub($sql, 'order_subtotals');
    }

}
