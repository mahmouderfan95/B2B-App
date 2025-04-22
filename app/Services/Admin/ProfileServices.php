<?php
namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Http\Requests\Admin\Profile\Update;
use Exception;

class ProfileServices{
    use FileUpload;
    public function editProfile()
    {
        $admin = auth()->user();
        return view('admin.profile.edit',compact('admin'));
    }

    public function updateProfile(Request $request,$admin_id)
    {
        // return $request;
        $data_request = $request->except(['avatar']);
        if (isset($request->avatar))
            $data_request['avatar'] = $this->save_file($request->avatar, 'users');
        try {
            $admin = $this->updateUserData($data_request,$admin_id);
            if ($admin)
                return redirect()->back()->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    private function getUserById($id)
    {
        $admin = User::find($id);
        return $admin;
    }

    private function updateUserData($data,$admin_id)
    {
        $admin = $this->getUserById($admin_id);
        $admin->update($data);
        return $admin;
    }
}
