@extends('dashboard.master')
@section('title')
    مدرسة ليرن | صفحة إنشاء اختبار جديد
@stop
@section('css')
    <style>
        .question-card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            padding: 15px;
        }

        .question-header {
            background-color: #e9ecef;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 10px 15px;
        }

        .badge-question {
            font-size: 0.9rem;
        }
    </style>
@stop
@section('content')
    <main class="page-content">

        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">إنشاء اختبار جديد</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('dash.teacher.quizz.add') }}" method="POST" id="quiz-form">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">عنوان الاختبار</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">مدة الاختبار (دقائق)</label>
                                    <input type="number" class="form-control" name="duration" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">تاريخ البدء</label>
                                    <input type="datetime-local" class="form-control" name="start_time" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">تاريخ الانتهاء</label>
                                    <input type="datetime-local" class="form-control" name="end_time" required>
                                </div>
                            </div>

                            <hr>

                            <!-- حاوية الأسئلة -->
                            <div id="questions-container"></div>

                            <button type="button" class="btn btn-outline-primary col-12 mt-3" id="add-question-btn">➕ إضافة سؤال</button>

                            <hr>

                            <button type="submit" class="btn btn-success col-12">📝 حفظ الاختبار</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </main>
@stop

@section('js')
<script>
    function getQuestionHTML(index) {
      return `
        <div class="card question-card" id="question-${index}">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>السؤال رقم ${index + 1}</h5>
            <button type="button" class="btn btn-danger btn-sm remove-question" data-index="${index}">✖ حذف</button>
          </div>

          <div class="mb-3">
            <label class="form-label">📝 نص السؤال</label>
            <input type="text" class="form-control question-text" name="questions[${index}][text]" required>
          </div>

          <div class="mb-3">
            <label class="form-label">📂 نوع السؤال</label>
            <select class="form-select question-type" name="questions[${index}][type]" data-index="${index}" required>
              <option value="">-- اختر نوع السؤال --</option>
              <option value="msq">اختيار من متعدد</option>
              <option value="tf">صح أو خطأ</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">🎯 عدد العلامات</label>
            <input type="number" class="form-control question-score" name="questions[${index}][grade]" min="1" value="1" required>
          </div>

          <div class="options-box d-none" id="options-${index}">
            <label class="form-label">📋 الخيارات</label>
            <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 1" required>
            <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 2" required>
            <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 3" required>
            <input type="text" class="form-control mb-2" name="questions[${index}][options][]" placeholder="الخيار 4" required>

            <label class="form-label mt-2">✅ رقم الإجابة الصحيحة (1 - 4)</label>
            <input type="number" class="form-control correct-option" name="questions[${index}][correct_option]" min="1" max="4" required>
          </div>

          <div class="true-false-box d-none mt-3" id="true-false-${index}">
            <label class="form-label">✅ الإجابة الصحيحة</label>
            <select class="form-select correct-tf" name="questions[${index}][correct_tf]" required>
              <option value="">-- اختر الإجابة --</option>
              <option value="1">✔️ صح</option>
              <option value="0">❌ خطأ</option>
            </select>
          </div>
        </div>
      `;
    }

    function validateLastQuestion() {
      const lastQuestion = $('#questions-container').children().last();
      if (!lastQuestion.length) return true; // لا يوجد سؤال سابق، مسموح بإضافة سؤال جديد

      const text = lastQuestion.find('.question-text').val().trim();
      if (text === '') return false;

      const type = lastQuestion.find('.question-type').val();
      if (type === '') return false;

      const score = lastQuestion.find('.question-score').val();
      if (score === '' || isNaN(score) || Number(score) < 1) return false;

      if (type === 'msq') {
        let optionsValid = true;
        lastQuestion.find(`#options-${lastQuestion.attr('id').split('-')[1]} input[type="text"]`).each(function() {
          if ($(this).val().trim() === '') optionsValid = false;
        });
        if (!optionsValid) return false;

        const correctOption = lastQuestion.find('.correct-option').val();
        if (correctOption === '' || isNaN(correctOption) || correctOption < 1 || correctOption > 4) return false;

      } else if (type === 'tf') {
        const correctTF = lastQuestion.find('.correct-tf').val();
        if (correctTF === '') return false;
      }

      return true;
    }

    $(document).ready(function () {
      let questionIndex = 0;

      $('#add-question-btn').click(function () {
        if (!validateLastQuestion()) {
          alert('يرجى إكمال السؤال السابق بالكامل قبل إضافة سؤال جديد.');
          return;
        }
        $('#questions-container').append(getQuestionHTML(questionIndex));
        questionIndex++;
      });

      $(document).on('change', '.question-type', function () {
        let index = $(this).data('index');
        let type = $(this).val();

        $(`#options-${index}`).addClass('d-none');
        $(`#true-false-${index}`).addClass('d-none');

        if (type === 'msq') {
          $(`#options-${index}`).removeClass('d-none');
          $(`#options-${index} input[type="text"]`).attr('required', true);
          $(`#options-${index} input.correct-option`).attr('required', true);
          $(`#true-false-${index} select.correct-tf`).attr('required', false);
        } else if (type === 'tf') {
          $(`#true-false-${index}`).removeClass('d-none');
          $(`#true-false-${index} select.correct-tf`).attr('required', true);
          $(`#options-${index} input[type="text"]`).attr('required', false);
          $(`#options-${index} input.correct-option`).attr('required', false);
        } else {
          $(`#options-${index} input[type="text"]`).attr('required', false);
          $(`#options-${index} input.correct-option`).attr('required', false);
          $(`#true-false-${index} select.correct-tf`).attr('required', false);
        }
      });

      $(document).on('click', '.remove-question', function () {
        let index = $(this).data('index');
        $(`#question-${index}`).remove();
      });
    });
</script>
@stop
