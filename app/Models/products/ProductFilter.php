<?php

namespace App\Models\products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Product
{
    use HasFactory;


    protected $table = 'products';




    public function scopeFilter($query, array $values)
    {
        $query->searchTitle($values['search'] ?? '')
            ->priceGreaterThan($values['greater_than'] ?? 0)
            ->priceLowerThan($values['lower_than'] ?? 0)
            ->categoryFor($values['category'] ?? 0)
            ->sortBy($values['sort'] ?? 'id')
        ;
    }

    public function scopeSearchTitle($query, $value)
    {
        if (!empty($value)) {

            $query->where('title', 'LIKE', '%' . $value . '%');
        }
    }

    public function scopePriceGreaterThan($query, $value)
    {
        if (!empty($value)) {

            $query->where('price', '>=', $value);
        }
    }

    public function scopePriceLowerThan($query, $value)
    {
        if (!empty($value)) {

            $query->where('price', '<=', $value);
        }
    }

    public function scopeCategoryFor($query, $value)
    {
        if (!empty($value)) {

            $query->where('Category', $value);
        }
    }

    public function scopeSortBy($query, $value = 'id')
    {
        switch ($value) {
            case 'title_ace':
                $query->reorder('title');
                break;

            case 'price_asc':
                $query->reorder('price');
                break;

            case 'price_desc':
                $query->reorder('price', 'desc');
                break;

            case 'categroy':
                $query->reorder('category');
                break;

            default:
                $query->reorder('id');
                break;
        }
    }
}
