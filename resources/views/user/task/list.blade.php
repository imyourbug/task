 @extends('admin.main')
 @push('styles')
     <link rel="stylesheet" href="/template/admin/css/task.css">
 @endpush
 @push('scripts')
     <script src="/js/user/task/index.js?v=1" type="text/javascript"></script>
 @endpush
 @section('content')
     <div class="row" style="margin-left: 0px">
         <form action="{{ route('users.upload') }}" method="POST">
             <div class="" id="quantity" style="align-items: center;font-weight:bold"></div>
             <div class="card-footer">
                 <label>Lựa chọn loại nhiệm vụ</label>&emsp13;
                 <select name="code_freeship" id="code_freeship">
                     <option value="">
                         Không áp mã
                     </option>
                     <option value="ma-giam-25k">
                         Mã giảm 25k
                     </option>
                     <option value="ma-giam-70k">
                         Mã giảm 70k
                     </option>
                 </select>
                 <button type="submit" class="btn btn-rounded btn-success">Tải lên nhiệm vụ mới</button>
             </div>
             @csrf
         </form>
     </div>

     <div class="table-responsive">
         <table class="table table-bordered table-hover" id="tbl-task" style="font-size:12px">
             <thead>
                 <tr style="text-align:center">
                     <th class="col-id_task">Mã nhiệm vụ</th>
                     <th class="col-hidden-sm">Tài khoản</th>
                     <th class="col-hidden-sm">Mật khẩu</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">Cod (VNĐ)</th>
                     <th class="col-hidden-sm col-hidden-md">Người nhận</th>
                     <th class="col-hidden-sm col-hidden-md">SDT nhận</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">SDT OTP</th>
                     <th class="col-hidden-sm col-hidden-md">Địa chỉ giao</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg ">Phường/xã giao</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">Quận/huyện giao</th>
                     <th class="col-hidden-sm col-hidden-md">Tỉnh giao</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">Link sản phẩm</th>
                     <th class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">Mã freeship</th>
                     <th class="col-hidden-sm col-hidden-md">Tiền công (VNĐ)</th>
                     <th class="col-hidden-sm">Trạng thái</th>
                     <th class="col-hidden-sm">OTP</th>
                     <th>Action</th>
                 </tr>
             <tbody class=".table-striped" id="space">
                 @foreach ($tasks as $task)
                     <tr data-value="{{ json_encode($task) }}">
                         <td style="text-align:center">{{ $task->id_task }}</td>
                         <td class="col-hidden-sm">{{ $task->name }}</td>
                         <td class="col-hidden-sm">{{ $task->password }}</td>
                         <td class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">
                             {{ number_format($task->cod, 0, ',', '.') }}</td>
                         <td class="cancopy col-hidden-sm col-hidden-md" id="receiver{{ $task->id_task }}"
                             data-value="{{ $task->receiver }}">
                             {{ $task->receiver }}</td>
                         <td class="cancopy col-hidden-sm col-hidden-md" id="phone_receiver{{ $task->id_task }}"
                             data-value="{{ $task->phone_receiver }}">
                             {{ $task->phone_receiver }}</td>
                         <td class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">
                             {{ $task->phone_otp }}</td>
                         <td class="cancopy col-hidden-sm col-hidden-md" id="address{{ $task->id_task }}"
                             data-value="{{ $task->address }}">
                             {{ $task->address }}</td>
                         <td class="cancopy col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg"
                             id="ward{{ $task->id_task }}" data-value="{{ $task->ward }}">{{ $task->ward }}</td>
                         <td class="cancopy col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg"
                             id="district{{ $task->id_task }}" data-value="{{ $task->district }}">{{ $task->district }}
                         </td>
                         <td class="cancopy col-hidden-sm col-hidden-md" id="province{{ $task->id_task }}"
                             data-value="{{ $task->province }}">
                             {{ $task->province }}
                         </td>
                         <td class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">
                             @php
                                 $check = preg_match('/^(https?:\/\/)/', $task->link);
                             @endphp
                             @if ($check)
                                 <a target="_blank" href="{{ $task->link }}">{{ substr($task->link, 0, 10) }}</a>
                             @else
                                 {{ $task->link }}
                             @endif
                         </td>
                         <td class="col-hidden-sm col-hidden-md col-hidden-lg col-hidden-splg">{{ $task->code }}</td>
                         <td class="col-hidden-sm col-hidden-md">{{ number_format($task->wage, 0, ',', '.') }}</td>
                         <td class="col-hidden-sm">{{ $task->status === 0 ? 'Đang làm' : 'Đã hoàn thành' }}</td>
                         <td class="col-hidden-sm">{{ $task->otp }}</td>
                         <td style="text-align:center">
                             @if ($task->status === 0)
                                 <button class="btn btn-success btn-sm" onclick="openModal({{ $task->id }})">
                                     <i class="fa-solid fa-check"></i>
                                 </button>
                             @endif
                             <a href="/user/task/delete/{{ $task->id }}" class="btn btn-danger btn-sm"
                                 onclick="return confirm('Bạn có muốn xóa?')">
                                 <i class="fas fa-trash"></i>
                             </a>
                             @if (!$task->otp)
                                 <button class="btn btn-info btn-sm btn-getOTP" data-value="{{ $task->id }}">
                                     <i class="fa-solid fa-eye"></i>
                                 </button>
                             @endif
                         </td>
                     </tr>
                 @endforeach
             </tbody>
             </thead>
         </table>
     </div>
     <div id="id01" class="modal">
         <form class="modal-content animate" id="form" style="max-width: 500px !important; padding: 10px 15px"
             method="GET">
             <div class="imgcontainer">
                 <span onclick="document.getElementById('id01').style.display='none'" class="close"
                     title="Close Modal"></span>
                 <img src="" alt="" class="avatar">
             </div>
             <div class="container">
                 <h4>Nhập ID đơn hàng của bạn để hoàn thành</h4>
                 <label><b>ID đơn hàng</b></label>
                 <input type="text" class="form-control" placeholder="Nhập ID đơn hàng..." name="id_order" required>
             </div>
             <button class="btn btn-rounded btn-success mt-2" style="">Hoàn thành</button>
             <button class="btn btn-rounded btn-danger mt-2"
                 onclick="document.getElementById('id01').style.display='none'" style="">Đóng</button>
         </form>
     </div>
     <script>
         function openModal(id_task) {
             console.log(id_task);
             let form = document.getElementById('form');
             form.setAttribute('action', '/user/task/complete/' + id_task);
             document.getElementById('id01').style.display = 'block';
         }
         // Get the modal
         var modal1 = document.getElementById('id01');

         // When the user clicks anywhere outside of the modal, close it
         window.onclick = function(event) {
             if (event.target == modal1) {
                 modal1.style.display = "none";
             }
         }
     </script>
 @endsection
