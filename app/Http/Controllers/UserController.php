<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    public function index()
    {
        $users = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select(
                'users.*',
                'departments.name as department',
                'users_status.name as status'
            )->get();

        return response()->json($users);
    }

    public function create()
    {
        $users_status = DB::table('users_status')
            ->select(
                'id as value',
                'name as label'
            )->get();

        $departments = DB::table('departments')
            ->select(
                'id as value',
                'name as label'
            )->get();

        return response()->json([
            'users_status' => $users_status,
            'departments' => $departments
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'status_id' => 'required',
                'username' => 'required|unique:users,username',
                'name' => 'required|max:255',
                'email' => 'required|email',
                'department_id' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required|same:password'
            ],
            [
                'status_id.required' => 'Nhập Tình trạng',
                'username.required' => 'Nhập Tên tài khoản',
                'username.unique' => 'Tên tài khoản đã tồn tại',

                'name.required' => 'Nhập Họ và tên',
                'name.max' => 'Ký tự tối đa là 255',

                'email.required' => 'Nhập Email',
                'email.email' => 'Email không hợp lệ',

                'department_id.required' => 'Nhập Phòng ban',
                'password.required' => 'Nhập Mật khẩu',
                'password_confirmation.required' => 'Xác nhận lại mật khẩu',
                'password_confirmation.same' => 'Mật khẩu không trùng khớp'
            ]
        );

        User::create([
            'status_id' => $validated['status_id'],
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id'],
            'password' => Hash::make($validated['password'])
        ]);
    }

    public function edit($id)
    {
        $users = User::find($id);

        $users_status = DB::table('users_status')
            ->select(
                'id as value',
                'name as label'
            )->get();

        $departments = DB::table('departments')
            ->select(
                'id as value',
                'name as label'
            )->get();

        return response()->json([
            'users' => $users,
            'users_status' => $users_status,
            'departments' => $departments
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'status_id' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'name' => 'required|max:255',
                'email' => 'required|email',
                'department_id' => 'required'
            ],
            [
                'status_id.required' => 'Nhập Tình trạng',
                'username.required' => 'Nhập Tên tài khoản',
                'username.unique' => 'Tên tài khoản đã tồn tại',
                'name.required' => 'Nhập Họ và tên',
                'name.max' => 'Ký tự tối đa là 255',
                'email.required' => 'Nhập Email',
                'email.email' => 'Email không hợp lệ',
                'department_id.required' => 'Nhập Phòng ban',
            ]
        );

        User::find($id)->update([
            'status_id' => $validated['status_id'],
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id']
        ]);

        if ($request['change_password'] == true) {
            $validated = $request->validate(
                [
                    'password' => 'required',
                    'password_confirmation' => 'required|same:password'
                ],
                [
                    'password.required' => 'Nhập Mật khẩu',
                    'password_confirmation.required' => 'Xác nhận lại mật khẩu',
                    'password_confirmation.same' => 'Mật khẩu không trùng khớp'
                ]
            );

            User::find($id)->update([
                'password' => Hash::make($validated['password']),
                'change_password_at' => now()
            ]);
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
    }
}