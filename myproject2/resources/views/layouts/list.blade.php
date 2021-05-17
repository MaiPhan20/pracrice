@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-11">
                <h2>Student</h2>
        </div>
        <div class="col-lg-1">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addModal">Add</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="studentTable">
 <thead>
 <tr>
 <th>id</th>
 <th>First Name</th>
 <th>Last Name</th>
 <th>Telephone</th>
  <th>Email</th>
 <th>Feedback</th>

 <th width="280px">Action</th>
 </tr>
 </thead> 
 <tbody>
        @foreach ($students as $student)
            <tr id="{{ $student->id }}">
                <td>{{ $student->id }}</td>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->telephone }}</td>
		  <td>{{ $student->email }}</td>
                <td>{{ $student->feedback }}</td>

                <td>
      <a data-id="{{ $student->id }}" class="btn btn-primary btnEdit">Edit</a>
      <a data-id="{{ $student->id }}" class="btn btn-danger btnDelete">Delete</button>
                </td>
            </tr>
        @endforeach
 </tbody>
    </table>
 
 
<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Student</h4>
      </div>
   <div class="modal-body">
 <form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
 @csrf
 <div class="form-group">
 <label for="txtFirstName">First Name:</label>
 <input type="text" class="form-control" id="txtFirstName" placeholder="Enter First Name" name="txtFirstName">
 </div>
 <div class="form-group">
 <label for="txtLastName">Last Name:</label>
 <input type="text" class="form-control" id="txtLastName" placeholder="Enter Last Name" name="txtLastName">
 </div>
 <div class="form-group">
 <label for="txtAddress">telephone:</label>
 <textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
 </div>
 <button type="submit" class="btn btn-primary">Submit</button>
 </form>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <!-- Student Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Student</h4>
      </div>
   <div class="modal-body">
 <form id="updateStudent" name="updateStudent" action="{{ route('student.update') }}" method="post">
 <input type="hidden" name="hdnStudentId" id="hdnStudentId"/>
 @csrf
 <div class="form-group">
 <label for="txtFirstName">First Name:</label>
 <input type="text" class="form-control" id="txtFirstName" placeholder="Enter First Name" name="txtFirstName">
 </div>
 <div class="form-group">
 <label for="txtLastName">Last Name:</label>
 <input type="text" class="form-control" id="txtLastName" placeholder="Enter Last Name" name="txtLastName">
 </div>
 <div class="form-group">
 <label for="txtAddress">telephone</label>
 <textarea class="form-control" id="txttelephone" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
 </div>
 <label for="txtAddress"></label>
 <textarea class="form-control" id="txt" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
 </div>
 <label for="txtAddress">Email</label>
 <textarea class="form-control" id="txtemail" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
 </div>
 <label for="txtAddress">Feedback</label>
 <textarea class="form-control" id="txtFeedback" name="txtAddress" rows="10" placeholder="Enter Address"></textarea>
 </div>
 <button type="submit" class="btn btn-primary">Submit</button>
 </form>
   </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
 
<script>
  $(document).ready(function () {
 //Add the Student  
 $("#addStudent").validate({
 rules: {
 txtFirstName: "required",
 txtLastName: "required",
 txtAddress: "required"
 },
 messages: {
 },
 
 submitHandler: function(form) {
   var form_action = $("#addStudent").attr("action");
   $.ajax({
   data: $('#addStudent').serialize(),
   url: form_action,
   type: "POST",
   dataType: 'json',
   success: function (data) {
   var student = '<tr id="'+data.id+'">';
   student += '<td>' + data.id + '</td>';
   student += '<td>' + data.first_name + '</td>';
   student += '<td>' + data.last_name + '</td>';
   student += '<td>' + data.telephone + '</td>';
      student += '<td>' + data.email + '</td>';
   student += '<td>' + data.feedback + '</td>';

   student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
   student += '</tr>';            
   $('#studentTable tbody').prepend(student);
   $('#addStudent')[0].reset();
   $('#addModal').modal('hide');
   },
   error: function (data) {
   }
   });
 }
 });
  
 
    //When click edit student
    $('body').on('click', '.btnEdit', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/edit', function (data) {
          $('#updateModal').modal('show');
          $('#updateStudent #hdnStudentId').val(data.id); 
          $('#updateStudent #txtFirstName').val(data.first_name);
          $('#updateStudent #txtLastName').val(data.last_name);
          $('#updateStudent #txttelephone').val(data.telephone);
		            $('#update #txtemail').val(data.email);
          $('#updateStudent #txtFeedback').val(data.feedback);

      })
   });
    // Update the student
 $("#updateStudent").validate({
 rules: {
 txtFirstName: "required",
 txtLastName: "required",
 txtAddress: "required"
 
 },
 messages: {
 },
 
 submitHandler: function(form) {
   var form_action = $("#updateStudent").attr("action");
   $.ajax({
   data: $('#updateStudent').serialize(),
   url: form_action,
   type: "POST",
   dataType: 'json',
   success: function (data) {
   var student = '<td>' + data.id + '</td>';
   student += '<td>' + data.first_name + '</td>';
   student += '<td>' + data.last_name + '</td>';
      student += '<td>' + data.phone + '</td>';
   student += '<td>' + data.email + '</td>';
   student += '<td>' + data.feedback + '</td>';

   student += '<td><a data-id="' + data.id + '" class="btn btn-primary btnEdit">Edit</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-danger btnDelete">Delete</a></td>';
   $('#studentTable tbody #'+ data.id).html(student);
   $('#updateStudent')[0].reset();
   $('#updateModal').modal('hide');
   },
   error: function (data) {
   }
   });
 }
 }); 
 
   //delete student
 $('body').on('click', '.btnDelete', function () {
      var student_id = $(this).attr('data-id');
      $.get('student/' + student_id +'/delete', function (data) {
          $('#studentTable tbody #'+ student_id).remove();
      })
   }); 
 
});   
</script>
@endsection