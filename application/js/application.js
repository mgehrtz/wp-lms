jQuery(document).ready(function($){
  setupEventListeners($);
  attemptToFillPreviousAnswers($);
});

function setupEventListeners($){
  // Question Focus
  $('.question-wrapper .question-answer').on('keyup', function(){
    $('body').addClass('dirty-answers');
  });

  // Save Buttons
  $('.question-wrapper .save.button').on('click', function(){
    let answers = {};
    $('.question-wrapper .question-answer').each(function(){
      let el = $(this);
      answers[el.attr('name')] = el.val();
    });
    if(Object.keys(answers).length){
      submitUserAnswers(answers, $);
    }
  });

  // Page Change
  window.addEventListener('beforeunload', function(e){
    if(
      !$('body').hasClass('success-submitting-answers') && 
      $('body').hasClass('dirty-answers')
    ){
      e.preventDefault();
    } 
  });
}

function submitUserAnswers(answerObj, $){
  $('body').addClass('submitting-answers');
  $.ajax({
    url: application_ajax_obj.ajax_url,
    type: 'POST',
    data: {
      _ajax_nonce: application_ajax_obj.nonce,
      post_id: application_ajax_obj.post_id,
      action: "process_application_answers",
      answers: answerObj
    }, 
    dataType: 'JSON',
    success: function(resp){
      $('body').removeClass('submitting-answers');
      $('body').removeClass('dirty-answers');
      $('body').addClass('success-submitting-answers');
      console.log('Answers submitted.');
    },
    error: function(resp){
      $('body').removeClass('submitting-answers');
      $('body').removeClass('dirty-answers');
      $('body').addClass('error-submitting-answers');
      console.warn('Error submitting answers.');
    }
  });
}

function attemptToFillPreviousAnswers($){
  if(window.previous_application_answers == undefined) return;
  for(const [key, value] of Object.entries(window.previous_application_answers)){
    $(`.question-wrapper .question-answer[name=${key}]`).eq(0).val(value);
  }
}