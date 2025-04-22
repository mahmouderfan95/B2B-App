<?php

namespace App\Models;

use App\Enums\VendorAgreementEnum;
use App\Events\Transaction\Cancelled;
use App\Models\Scopes\CreatedFromScopes;
use App\Traits\DbOrderScope;
use App\Traits\UploadImageTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VendorAgreement extends Model
{
    use HasFactory;// CreatedFromScopes, DbOrderScope, UploadImageTrait;

    private const agreementPath = "public/vendor-agreements";
    private const agreementPdfPath = "public/vendor-approved-agreements";

    protected $fillable = [
        "agreement_pdf", "vendor_id", "status", "approved_by", "approved_at", "approved_pdf"
    ];

    protected $casts = [
        "approved_at" => "datetime",
    ];

    public function vendor() : BelongsTo {
        return $this->belongsTo(Vendor::class, "vendor_id");
    }

    public function approvedBy() : BelongsTo {
        return $this->belongsTo(User::class, "approved_by");
    }

    public function scopePending(Builder $query) : Builder {
        return $query->where("status", VendorAgreementEnum::PENDING);
    }

    public function scopeApproved(Builder $query) : Builder {
        return $query->where("status", VendorAgreementEnum::APPROVED);
    }

    public function scopeCanceled(Builder $query) : Builder {
        return $query->where("status", VendorAgreementEnum::CANCELED);
    }

    public function scopeStatus(Builder $query, string $status) : Builder {
        return match ($status) {
            VendorAgreementEnum::PENDING => $query->pending(),
            VendorAgreementEnum::APPROVED => $query->approved(),
            VendorAgreementEnum::CANCELED => $query->canceled(),
            default => $query
        };
    }

    public function scopeVendorId(Builder $query, string $vendorId) : Builder {
        return $query->where("vendor_id", $vendorId);
    }

    public function agreementPdf() : Attribute {
        return Attribute::make(
            get: fn($pdf) => $pdf ? Storage::url($pdf) : null
        );
    }

    public function SetAgreementPdfAttribute($pdf) {
        if ($pdf instanceof UploadedFile) {
            return $this->attributes['agreement_pdf'] = self::moveFileToLocalDisk($pdf, self::agreementPath);
        }
        return $this->attributes['agreement_pdf'] = $pdf;
    }

    public function agreementPdfPath() : Attribute {
        return Attribute::make(
            get: function() {
                if ($this->agreement_pdf) {
                    return Storage::path(Str::replace("storage/", "public/", $this->agreement_pdf));
                }
            }
        );
    }

    public function approvedPdf() : Attribute {
        return Attribute::make(
            get: fn($approved) => $approved ? Storage::url($approved) : null
        );
    }

    public function SetApprovedPdfAttribute($pdf) {
        if ($pdf instanceof UploadedFile) {
            return $this->attributes['approved_pdf'] = self::moveFileToLocalDisk($pdf, self::agreementPdfPath);
        } else if (is_string($pdf)) {
            return $this->attributes['approved_pdf'] = self::storeContentToLocalDisk($pdf, "pdf", self::agreementPdfPath);
        }
        return $this->attributes['approved_pdf'] = $pdf;
    }

    public function agreementPdfName() : Attribute {
        return Attribute::make(
            get: fn() => $this->agreement_pdf ? collect(explode("/", $this->agreement_pdf))->last() : null,
        );
    }

    public function approvedPdfName() : Attribute {
        return Attribute::make(
            get: fn() => $this->approved_pdf ? collect(explode("/", $this->approved_pdf))->last() : null,
        );
    }


    private static function moveFileToLocalDisk(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $file->getClientOriginalExtension();
        Storage::put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

    private static function moveFileToPublic(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('root-public')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

    private static function storeContentToPublic(string $fileContent, string $fileExtension, $path): string
    {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $fileExtension;
        Storage::disk('root-public')->put($path ."/". $fileName, $fileContent);
        return "$path/$fileName";
    }

    private static function storeContentToLocalDisk(string $fileContent, string $fileExtension, $path): string
    {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $fileExtension;
        Storage::put($path ."/". $fileName, $fileContent);
        return "$path/$fileName";
    }
}
