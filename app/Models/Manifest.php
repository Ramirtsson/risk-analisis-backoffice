<?php

namespace App\Models;

use App\Observers\ManifestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static findOrFail($id)
 */
#[ObservedBy([ManifestObserver::class])]
class Manifest extends Model
{
    use HasFactory;

    protected $fillable = [
        "import_request",
        "arrival_date",
        "modulation_date",
        "number_guide",
        "house_guide",
        "lumps",
        "gross_weight",
        "packages",
        "registration_number",
        "invoice",
        "invoice_date",
        "rectified",
        "total_invoice",
        "transmission_date",
        "payment_date",
        "manifest_file",
        "checked",
        "customer_id",
        "custom_agent_id",
        "custom_house_id",
        "courier_company_id",
        "supplier_id",
        "traffic_id",
        "value_id",
        "exchange_rate_id",
        "currency_id",
        "warehouse_office_id",
        "warehouse_origin_id",
        "operating_status_id",
        "user_id",
        "status_id",
    ];

    protected $with = ['status', 'operatingStatus'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    public function operatingStatus(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'operating_status_id');
    }
    public function customAgent(): HasOne
    {
        return $this->hasOne(CustomsAgent::class, 'id', 'custom_agent_id');
    }
    public function customer(): HasOne
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function customHouse(): HasOne
    {
        return $this->hasOne(CustomHouse::class, 'id', 'custom_house_id');
    }

    public function mFile(): HasOne
    {
        return $this->hasOne(MFile::class);
    }

    public function rectifiedManifests(): HasOne
    {
        return $this->hasOne(RectifiedManifest::class, 'manifest_id', 'id');
    }
}
