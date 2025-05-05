<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'descriptions', 'price', 'status', 'type_id', 'car_id'];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function packageImages()
    {
        return $this->hasMany(PackageImage::class, 'package_id');
    }
}
