<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function addFormData(Request $request)
    {
        try {

            $file = $request->file('avatar');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $file_name);

            $employee_data = new Employee;
            $employee_data->first_name = $request->fname;
            $employee_data->last_name = $request->lname;
            $employee_data->email = $request->email;
            $employee_data->phone = $request->phone;
            $employee_data->post = $request->post;
            $employee_data->photo_path = $file_name;
            $employee_data->save();

            return response()->json([
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function fetchAllEmployees(Request $request)
    {
        try {
            $employees_data = Employee::where('deleted_at', null)->get();
            $output = '';
            if ($employees_data->count() > 0) {
                $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Post</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
                foreach ($employees_data as $emploayee_data) {
                    $output .= '<tr>
                <td>' . $emploayee_data->employee_id . '</td>
                <td><img src="storage/images/' . $emploayee_data->photo_path . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $emploayee_data->first_name . ' ' . $emploayee_data->last_name . '</td>
                <td>' . $emploayee_data->email . '</td>
                <td>' . $emploayee_data->post . '</td>
                <td>' . $emploayee_data->phone . '</td>
                <td>
                  <a href="javascript:void(0);" id="' . $emploayee_data->employee_id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="javascript:void(0);"id="' . $emploayee_data->employee_id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
                }
                $output .= '</tbody></table>';
                echo $output;
            } else {
                echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function editData(Request $request)
    {
        try {

            $employee_id = $request->id;

            $employee_data = Employee::find($employee_id);

            return response()->json($employee_data);
        } catch (\Throwable $th) {

            dd($th->getMessage());
        }
    }

    public function updateData(Request $request)
    {

        try {
            $file_name = "";
            // dd($request->emp_avatar);
            $employee_data = Employee::find($request->emp_id);
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $file_name);
                if ($employee_data->photo_path) {
                    Storage::delete('public/images/' . $employee_data->photo_path);
                }
            } else {
                $file_name = $request->emp_avatar;
            }
            $emp_data = [
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'post' => $request->post,
                'photo_path' => $file_name,
            ];

            $employee_data->update($emp_data);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function deleteData(Request $request)
    {
        try {

            $id = $request->id;
            $employee_data = Employee::find($id);
            if (Storage::delete('public/images/' . $employee_data->photo_path)) {
                Employee::where('employee_id', $id)->delete();
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
