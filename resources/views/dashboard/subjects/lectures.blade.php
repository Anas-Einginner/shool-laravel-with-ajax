@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمعلمين
@stop
@section('content')
    <main class="page-content">





        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0"> التصفية</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <input type="text" id="search-title-lecture" class="form-control search-input"
                                    placeholder="عنوان المحاضرة">
                            </div>
                                 <div class="col-md-6 mb-3">
                                <input type="text" id="search-desc-lecture" class="form-control search-input"
                                    placeholder="وصف المحاضرة">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <button type="submit" id="search-btn" class="btn btn-outline-success col-6">بحث</button>
                            <button type="reset" id="clear-btn" class="btn btn-outline-secondary col-6 ">تنظيف</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">جميع محاضرات مادة "{{ $subject->title }}" للمدرس "{{ $subject->teacher->name }}"</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>العنوان</th>
                                        <th>الوصف</th>
                                        <th>رابط المحاضرة</th>
                                        <th>اسم المدرس</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@stop
@section('js')
    <script>
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: {
                url: "{{ route('dash.subject.getdata.lectures') }}",
                data: function(n) {
                    n.id = {{ $subject->id }};
                    n.title = $('#search-title-lecture').val();
                    n.desc = $('#search-desc-lecture').val();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'title',
                    name: 'title',
                    title: 'العنوان',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'desc',
                    name: 'desc',
                    title: 'الوصف',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'link',
                    name: 'link',
                    title: 'رابط المحاضرة',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'teacher',
                    name: 'teacher',
                    title: 'اسم المدرس',
                    orderable: true,
                    searchable: true,
                },
             
            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }
        });




  

    
    </script>




@stop
