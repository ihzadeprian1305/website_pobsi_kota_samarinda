<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDatum;
use App\Models\UserImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/users/'.$row->id.'" data-id="'.$row->id.'" id="btn_show_users" class="edit btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/users/'.$row->id.'/edit" data-id="'.$row->id.'" id="btn_update_users" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/users/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        try {
            if($request->file('image')){
                $validator = Validator::make($request->all(), [
                    'image' => ['image', 'mimes:jpeg,png,jpg', 'max: 2048'],
                    'name' => ['required'],
                    'username' => ['required', Rule::unique('users', 'username')],
                    'sex' => ['required', 'not_in:null'],
                    'email' => ['required', 'email:dns', Rule::unique('users', 'email')],
                    'phone_number' => ['required'],
                    'password' => ['required'],
                    'password_confirmation' => ['required', 'required_with:password'],
                    'user_level_id' => ['required', 'not_in:null'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => ['required'],
                    'username' => ['required', Rule::unique('users', 'username')],
                    'sex' => ['required', 'not_in:null'],
                    'email' => ['required', 'email:dns', Rule::unique('users', 'email')],
                    'phone_number' => ['required'],
                    'password' => ['required'],
                    'password_confirmation' => ['required', 'required_with:password'],
                    'user_level_id' => ['required', 'not_in:null'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->password != $request->password_confirmation){
                return redirect()->back()->with('status', 'Password dan Konfirmasi Password Tidak Sama');
            }

            DB::transaction(function() use($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone_number' => $request->phone_number,
                    'user_level_id' => $request->user_level_id,
                ]);

                $user_id = $user->id;

                if($request->file('image')){
                    UserDatum::create([
                        'name' => $request->name,
                        'sex' => $request->sex,
                        'user_id' => $user_id
                    ]);

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('user-images', $uniqueName);

                    UserImage::create([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                        'user_id' => $user_id
                    ]);
                } else {
                    UserDatum::create([
                        'name' => $request->name,
                        'sex' => $request->sex,
                        'user_id' => $user_id
                    ]);

                    UserImage::create([
                        'image' => null,
                        'image_name' => null,
                        'user_id' => $user_id
                    ]);
                }


            });

            return redirect('/admin/users')->with('status', 'Data Pengguna Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            return view('admin.users.show', ['user' => $user]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            return view('admin.users.edit', ['user' => $user]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            if($request->file('image')){
                if($request->password || $request->password_confirmation){
                    $validator = Validator::make($request->all(), [
                        'image' => ['image', 'mimes:jpeg,png,jpg', 'max: 2048'],
                        'name' => ['required'],
                        'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
                        'sex' => ['required', 'not_in:null'],
                        'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($user->id)],
                        'phone_number' => ['required'],
                        'password' => ['required'],
                        'password_confirmation' => ['required', 'required_with:password'],
                        'user_level_id' => ['required', 'not_in:null'],
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'image' => ['image', 'mimes:jpeg,png,jpg', 'max: 2048'],
                        'name' => ['required'],
                        'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
                        'sex' => ['required', 'not_in:null'],
                        'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($user->id)],
                        'phone_number' => ['required'],
                        'user_level_id' => ['required', 'not_in:null'],
                    ]);
                }
            } else {
                if($request->password || $request->password_confirmation){
                    $validator = Validator::make($request->all(), [
                        'name' => ['required'],
                        'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
                        'sex' => ['required', 'not_in:null'],
                        'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($user->id)],
                        'phone_number' => ['required'],
                        'password' => ['required'],
                        'password_confirmation' => ['required', 'required_with:password'],
                        'user_level_id' => ['required', 'not_in:null'],
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'name' => ['required'],
                        'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
                        'sex' => ['required', 'not_in:null'],
                        'email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore($user->id)],
                        'phone_number' => ['required'],
                        'user_level_id' => ['required', 'not_in:null'],
                    ]);
                }
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->password != $request->password_confirmation){
                return redirect()->back()->with('status', 'Password dan Konfirmasi Password Tidak Sama');
            }

            DB::transaction(function() use($request, $user) {
                $user->update([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone_number' => $request->phone_number,
                    'user_level_id' => $request->user_level_id,
                ]);

                if($request->file('image')){
                    $user_image = $user->user_images->image;
                    if(File::exists('storage/'. $user_image)){
                        File::delete('storage/'. $user_image);
                    }

                    $user->user_data->update([
                        'name' => $request->name,
                        'sex' => $request->sex,
                    ]);

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('user-images', $uniqueName);

                    $user->user_images->update([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);
                } else {
                    $user->user_data->update([
                        'name' => $request->name,
                        'sex' => $request->sex,
                    ]);
                }
            });

            return redirect('/admin/users')->with('status', 'Data Pengguna Berhasil Diubah');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::transaction(function() use($user) {
                $profile_image_name = $user->user_data->profile_image;
                if(File::exists('storage/'. $profile_image_name)){
                    File::delete('storage/'. $profile_image_name);
                }

                $user->user_data->delete();
                $user->user_images->delete();
                $user->delete();
            });

            return redirect('/admin/users')->with('status', 'Data Pengguna Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroyImage($id){
        $userImage = UserImage::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $userImage->image)){
            File::delete('storage/'. $userImage->image);
        }

        $userImage->update([
            'image' => null,
            'image_name' => null,
        ]);

        return redirect()->back()->with('success', 'Data Foto Pengguna Berhasil Dihapus');
    }
}
