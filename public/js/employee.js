$(document).ready(function () {

    //add form data

    $(document).on('submit', '#add_employee_form', function (e) {
        e.preventDefault();
        var form_data = new FormData(this);
        $('#add_employee_btn').text('Adding...');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/add_form_data',
            method: 'POST',
            data: form_data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status == 200) {
                    Swal.fire(
                        'Added!',
                        'Employee Added Successfully',
                        'success'
                    )
                    fetchAllEmployees();
                }
                $('#add_employee_btn').text('Add Employee');
                $('#add_employee_form')[0].reset();
                $('#addEmployeeModal').modal('hide');
            }
        });
    })

    // edit employees

    $(document).on('click', '.editIcon', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');

        $.ajax({
            url: 'edit_data',
            method: 'GET',
            data: {
                id: id,
                _token: '{csrf_token()}'
            },
            success: function (res) {
                $("#fname").val(res.first_name);
                $("#lname").val(res.last_name);
                $("#email").val(res.email);
                $("#phone").val(res.phone);
                $("#post").val(res.post);
                $("#avatar").html(
                    `<img src="storage/images/${res.photo_path}" width="100" class="img-fluid img-thumbnail">`);
                $("#emp_id").val(res.employee_id);
                $("#emp_avatar").val(res.photo_path);
            }
        });
    });

    // update employee

    $(document).on('submit', '#edit_employee_form', function (e) {
        e.preventDefault();

        var form_data = new FormData(this);

        $('#edit_employee_btn').text('Updating...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/update_data',
            method: 'POST',
            data: form_data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status == 200) {
                    Swal.fire(
                        'Updated !',
                        'Employee Updated Successfully',
                        'success'
                    )
                    fetchAllEmployees();
                }
                $('#edit_employee_btn').text('Update Employee');
                $('#edit_employee_form')[0].reset();
                $('#editEmployeeModal').modal('hide');
            }
        });
    });

    //delete employee

    $(document).on('click', '.deleteIcon', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'delete_data',
                method: 'POST',
                data: {
                    id: id,
                },
                success: function (res) {
                    Swal.fire(
                        'Deleted!',
                        'Employee deleted successfully',
                        'success'
                    )
                    fetchAllEmployees();
                }
            });
        })

    })
    fetchAllEmployees();
});

// fetch data
function fetchAllEmployees() {
    $.ajax({
        url: 'show_data',
        method: 'GET',
        success: function (res) {
            $('#show_all_employees').html(res);
            $('table').DataTable({
                order: [0, 'desc']
            })
        }
    });
}