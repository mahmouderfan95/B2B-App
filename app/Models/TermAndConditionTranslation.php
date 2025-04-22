<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermAndConditionTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "terms_and_conditions_translations";

    public $timestamps = false;

    public function termAndCondition()
    {
        return $this->belongsTo(TermAndCondition::class, "term_and_condition_id");
    }
}
