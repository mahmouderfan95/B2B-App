<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class SettingRepository extends BaseRepository
{


    public function updateSetting($data_request)
    {
        foreach ($data_request as $key => $value) {
            $setting = $this->model->where('key', $key)->first();
            if ($setting)
                $setting->update(['value' => $value]);
            else
                $this->model->create(['key' => $key,'value' => $value]);

        }
        return true;
    }

    public function show()
    {
        $setting = [];
        $setting['config_setting_name'] = $this->model->where('key','config_setting_name')->first();
        $setting['config_setting_logo'] = $this->model->where('key','config_setting_logo')->first();
        $setting['config_setting_phone'] = $this->model->where('key','config_setting_phone')->first();
        $setting['config_setting_email'] = $this->model->where('key','config_setting_email')->first();
        $setting['config_setting_facebook'] = $this->model->where('key','config_setting_facebook')->first();
        $setting['config_setting_twitter'] = $this->model->where('key','config_setting_twitter')->first();
        $setting['config_setting_instagram'] = $this->model->where('key','config_setting_instagram')->first();
        $setting['config_setting_linkedin'] = $this->model->where('key','config_setting_linkedin')->first();
        return $setting;
    }


    /**
     * Setting Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Setting";
    }
}
