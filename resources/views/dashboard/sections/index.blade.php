@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة الرئيسية للمستويات
@stop
@section('content')
    <main class="page-content">


        <div class="modal fade" id="add-modal" tabindex="-1" aria-labelledby="stagesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stagesModalLabel">المراحل الدراسية</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body">

                        <div class="container">

                            <form method="post" action="{{ route('dash.section.add')  }}" id="add-form" class="add-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-4">
                                    <label>عدد الشعبة المرغوب بها :</label>
                                    <input type="number" class="form-control" name="count_section">
                                </div>
                                <button class="btn btn-outline-success col-12" type="submit">اضافة</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary col-12" data-bs-dismiss="modal">إغلاق</button>
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
                                <h5 class="mb-0">جميع المستويات</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary col-12" data-bs-toggle="modal" data-bs-target="#add-modal">
                            اضافة الشعب
                        </button>
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
                                <h5 class="mb-0">جميع الشعب</h5>
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
                                        <th>الاسم</th>
                                        <th>الحالة</th>
                                        <th>العمليات</th>
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
                url: '{{ route('dash.section.getdata') }}'
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },

                {
                    data: 'name',
                    name: 'name',
                    title: 'الاسم',
                    orderable: true,
                    searchable: true,
                },


                {
                    data: 'status',
                    name: 'status',
                    title: 'الحالة',
                    orderable: true,
                    searchable: true,
                },

                {
                    data: 'action',
                    name: 'action',
                    title: 'العمليات',

                    orderable: false,
                    searchable: false,
                },

            ],

            language: {
                url: "{{ asset('datatable_custom/i18n/ar.json') }}",
            }


        });




        /*$(document).ready(function() {
            $(document).on('change', '.active-section-sw', function(e) {
              var id = $(this).data('id');
               var status = $(this).data('status');

                e.preventDefault();
                $.ajax({
                    url: "{{ route('dash.section.changestatus') }}",
                    type: "post",
                    data:{
                        'id': id ,
                        'status': status ,
                        '_token': "{{ csrf_token() }}" ,
                    },
                    success: function(res) {
                        // console.log(res.message);
                        toastr.success(res.success)
                        table.draw();
                    },
                });
            })
        });
*/
     

        /*
                    $('.master-checkbox').on('change', function() {
                        var target = $(this).data('target');
                        var checked = $(this).prop('checked');

                        if (!checked) {
                            $(target).find('input[type=checkbox]').prop('disabled', true); // تعطيل التشيك بوكسات
                        } else {
                            $(target).find('input[type=checkbox]').prop('disabled', false); // تمكين التشيك بوكسات
                        }
                    });


                    $('.grade-checkbox').on('change', function() {
                        var checkbox = $(this);
                        // 1 , 0
                        var status = checkbox.is(':checked') ? 1 : 0;

                        var stage = checkbox.data('stage');
                        var tag = checkbox.data('grade');
                        var name = checkbox.data('name');

                        $.ajax({
                            url: "{{ route('dash.grade.add') }}",
                            type: "post",
                            data: {
                                'stage': stage,
                                'tag': tag,
                                'name': name,
                                'status': status,
                                '_token': "{{ csrf_token() }}",
                            },

                            success: function(res) {
                                // console.log(res.message);
                                toastr.success(res.success)
                                table.draw();
                            },
                        });

                    });


                    $.ajax({
                        url: "{{ route('dash.grade.getactive') }}",
                        type: "GET",
                        success: function(res) {
                            var activeTags = res.tags.map(Number);
                            //alert(activeTags);

                            $('.grade-checkbox').not('.master-checkbox').each(function() {
                                var checkbox = $(this);
                                var datagrade = checkbox.data('grade');

                                if (activeTags.includes(datagrade)) {
                                    checkbox.prop('checked', true);
                                    checkbox.prop('disabled', false);
                                }
                            });
                        },
                    });
                    /////////////////////////////////////
                    $.ajax({
                        url: "{{ route('dash.grade.getactive.stage') }}",
                        type: "GET",
                        success: function(res) {
                            var activeTags = res.tags;
                            // alert(activeTags);

                            $('.master-checkbox').each(function() {
                                var checkbox = $(this);
                                var datastag = checkbox.data('tag');

                                if (activeTags.includes(datastag)) {
                                    checkbox.prop('checked', true);
                                    checkbox.prop('disabled', false);
                                }else{
                                    checkbox.prop('checked', false);
                                    var target = $(this).data('target');
                                    $(target).find('input[type=checkbox]').prop('disabled', true); // تعطيل التشيك بوكسات
                                }
                            });
                        },
                    });




                    $(document).ready(function() {
                        $(document).on('click', '.btn-add-section', function(e) {
                            e.preventDefault();
                            var button = $(this);
                            var gradetag = button.data('grade');
                            //alert(gradetag);
                            $('#gradetag').val(gradetag);
                        })
                    });

                    $('.section-checkbox').on('change', function() {
                        var checkbox = $(this);
                        // 1 , 0
                        var status = checkbox.is(':checked') ? 1 : 0;

                        var section = checkbox.data('section');
                        var gradetag = $('#gradetag').val();
                        $.ajax({
                            url: "{{ route('dash.grade.addsection') }}",
                            type: "post",
                            data: {
                                'section': section,
                                'gradetag': gradetag,
                                'status': status,
                                '_token': "{{ csrf_token() }}",
                            },

                            success: function(res) {
                                //  console.log(res.message);
                                toastr.success(res.success)
                                table.draw();
                            },
                        });

                    });

                    $('.master-checkbox').on('change', function() {
                        var checkbox = $(this);
                        // 1 , 0
                        var status = checkbox.is(':checked') ? 1 : 0;
                        var tag = checkbox.data('tag');

                        $.ajax({
                            url: "{{ route('dash.grade.changemaster') }}",
                            type: "post",
                            data: {
                                'tag': tag,
                                'status': status,
                                '_token': "{{ csrf_token() }}",
                            },

                            success: function(res) {
                                //  console.log(res.message);
                                toastr.success(res.success)
                                table.draw();
                            },
                        });

                    });


                    $(document).ready(function() {
                        $(document).on('click', '.btn-add-section', function(e) {
                            e.preventDefault();
                            var button = $(this);
                            var gradeid = button.data('grade-id');
                            $.ajax({
                                url: "{{ route('dash.grade.getactive.section') }}",
                                type: "GET",
                                data: {
                                    'gradeId': gradeid,
                                },
                                success: function(res) {
                                    var activeSection = res.names.map(Number);
                                    //alert(activeTags);

                                    $('.section-checkbox').not('.master-checkbox').each(function() {
                                        var checkbox = $(this);
                                        var datasection = checkbox.data('section');

                                        if (activeSection.includes(datasection)) {
                                            checkbox.prop('checked', true);
                                            checkbox.prop('disabled', false);
                                        } else {
                                            checkbox.prop('checked', false);
                                        }
                                    });
                                },
                            });
                        });

                    });*/
    </script>




@stop
