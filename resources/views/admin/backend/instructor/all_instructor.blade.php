@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<style>
  /* チェックボックスの大きさを変更 */
  .large-checkbox {
    transform: scale(1.5);
  }
</style>

<div class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">All Instructor </li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">

    </div>
  </div>
  <!--end breadcrumb-->

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Instructor Name </th>
              <th>Username </th>
              <th>Email </th>
              <th>Phone </th>
              <th>Status </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($allinstructor as $key=> $item)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->username }}</td>
              <td>{{ $item->email }}</td>
              <td>{{ $item->phone }}</td>

              <td>
                @if ($item->status == 1)
                <span class="btn btn-success">Active </span>

                @else
                <span class="btn btn-danger">InActive </span>

                @endif
              </td>

              <td>
                <div class="form-check-danger form-check form-switch">

                  <!-- data-user-idでinstructorのidデータを取得 -->
                  <!-- 三項演算子を用いて、チェックの有無を判定 -->
                  <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-user-id="{{ $item->id }}" {{ $item->status ? 'checked' : ''}}>
                  <label class="form-check-label" for="flexSwitchCheckCheckedDanger"> </label>
                </div>
              </td>
            </tr>
            @endforeach

          </tbody>

        </table>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function() {
    $('.status-toggle').on('change', function() {

      // data-user-idのid情報を取得
      var userId = $(this).data('user-id');

      // チェックボックスのstatusをtrueにする
      var isChecked = $(this).is(':checked');

      // send an ajax request to update status 
      $.ajax({
        url: "{{ route('update.user.stauts') }}",
        method: "POST",
        data: {
          user_id: userId,
          is_checked: isChecked ? 1 : 0,

          // Ajaxを用いる場,トークンも送る必要がある
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          toastr.success(response.message);
        },
        error: function() {}
      });
    });
  });
</script>

@endsection