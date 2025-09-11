<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SettingSupport;
use App\Services\SettingService;

class Setting extends Model
{
    use SettingSupport;

    protected $fillable = ['group', 'key', 'value'];

    public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->initSettingSupport();
    }

    public function getCastValue()
    {
        $json = json_decode($this->value, true);
        return json_last_error() === JSON_ERROR_NONE ? $json : $this->value;
    }
}
