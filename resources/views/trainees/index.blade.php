@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>قائمة المتدربين</h2>

        <!-- زر إضافة متدرب جديد -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTraineeModal">
            إضافة متدرب جديد
        </button>

        <!-- عرض Flash Message -->
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('trainees.index') }}" method="GET" class="d-flex mb-3">
            <input type="text" name="search" class="form-control me-2" placeholder="ابحث عن المتدربين..." value="{{ request()->query('search') }}">
            <select name="specialization" class="form-select me-2">
                <option value="">اختار التخصص</option>
                <!-- يمكنك ملء هذه الخيارات ديناميكيًا من التخصصات المتاحة في قاعدة البيانات -->
                @foreach($specializations as $specialization)
                    <option value="{{ $specialization }}" {{ request()->query('specialization') == $specialization ? 'selected' : '' }}>{{ $specialization }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">بحث</button>
        </form>
        <!-- جدول المتدربين -->
<table class="table mt-4">
    <thead>
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>التخصص</th>
            <th>الهاتف</th>
            <th>إجراءات</th>
        </tr>
    </thead>
    @if($trainees->isEmpty())
        <div class="alert alert-warning">
            لا توجد بيانات متدربين لعرضها.
        </div>
    @else
        <tbody>
            @foreach ($trainees as $trainee)
                <tr>
                    <td>{{ $trainee->name }}</td>
                    <td>{{ $trainee->email }}</td>
                    <td>{{ $trainee->specialization }}</td>
                    <td>{{ $trainee->phone }}</td>
                    <td>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewTraineeModal" 
        data-id="{{ $trainee->id }}" 
        data-name="{{ $trainee->name }}" 
        data-email="{{ $trainee->email }}" 
        data-specialization="{{ $trainee->specialization }}" 
        data-phone="{{ $trainee->phone }}">
        عرض
    </button>
                        <!-- زر التعديل -->
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editTraineeModal" 
                            data-id="{{ $trainee->id }}" 
                            data-name="{{ $trainee->name }}" 
                            data-email="{{ $trainee->email }}" 
                            data-specialization="{{ $trainee->specialization }}" 
                            data-phone="{{ $trainee->phone }}">
                            تعديل
                        </button>

                        <!-- زر الحذف مع مودال الحذف -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTraineeModal"
                            data-trainee-id="{{ $trainee->id }}" data-trainee-name="{{ $trainee->name }}">
                            حذف
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    </div>

    <!-- مودال إضافة متدرب جديد -->
    <div class="modal fade" id="addTraineeModal" tabindex="-1" aria-labelledby="addTraineeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTraineeModalLabel">إضافة متدرب جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('trainees.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="specialization" class="form-label">التخصص</label>
                            <input type="text" name="specialization" id="specialization" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال عرض بيانات المتدرب -->
<div class="modal fade" id="viewTraineeModal" tabindex="-1" aria-labelledby="viewTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTraineeModalLabel">عرض بيانات المتدرب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- عرض بيانات المتدرب -->
                <p><strong>الاسم: </strong><span id="view_name"></span></p>
                <p><strong>البريد الإلكتروني: </strong><span id="view_email"></span></p>
                <p><strong>التخصص: </strong><span id="view_specialization"></span></p>
                <p><strong>الهاتف: </strong><span id="view_phone"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="editTraineeModal" tabindex="-1" aria-labelledby="editTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTraineeModalLabel">تعديل بيانات المتدرب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('trainees.update', isset($trainee) ? $trainee->id : '0') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">الاسم</label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="{{ isset($trainee) ? $trainee->name : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="edit_email" class="form-control" value="{{ isset($trainee) ? $trainee->email : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_specialization" class="form-label">التخصص</label>
                        <input type="text" name="specialization" id="edit_specialization" class="form-control" value="{{ isset($trainee) ? $trainee->specialization : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">الهاتف</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control" value="{{ isset($trainee) ? $trainee->phone : '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="deleteTraineeModal" tabindex="-1" aria-labelledby="deleteTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTraineeModalLabel">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من حذف المتدرب <span id="trainee_name"></span>؟
            </div>
            <div class="modal-footer">
                <form id="deleteTraineeForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
 
    var deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#deleteTraineeModal"]');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var traineeId = this.getAttribute('data-trainee-id');
            var traineeName = this.getAttribute('data-trainee-name');
            
      
            document.getElementById('trainee_name').innerText = traineeName;
            
      
            document.getElementById('deleteTraineeForm').action = '/trainees/' + traineeId;
        });
    });
</script>

<script>
  
    const viewTraineeModal = document.getElementById('viewTraineeModal');
    viewTraineeModal.addEventListener('show.bs.modal', (event) => {

        const button = event.relatedTarget;

     
        const name = button.getAttribute('data-name');
        const email = button.getAttribute('data-email');
        const specialization = button.getAttribute('data-specialization');
        const phone = button.getAttribute('data-phone');

     
        document.getElementById('view_name').textContent = name;
        document.getElementById('view_email').textContent = email;
        document.getElementById('view_specialization').textContent = specialization;
        document.getElementById('view_phone').textContent = phone;
    });
</script>

@endsection

    

