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

  // Scale Question Hover Effect
  $('.question-wrapper.scale .numbers-wrapper button').on('mouseenter', function(){
    $('.active').removeClass('active');
    $(this).addClass('active');
    $(this).prevAll().addClass('active');
  }).on('mouseleave', function(){
    $('.active').removeClass('active');
    const targetName = $(this).parent().data('name');
    const selection = $(`.question-wrapper.scale input[name="${targetName}"]`).val();
    const targetEl = $(`.question-wrapper.scale .numbers-wrapper[data-name="${targetName}"] button[data-value="${selection}"]`);
    $(targetEl).addClass('active');
    $(targetEl).prevAll().addClass('active');
  });
  $('.question-wrapper.scale .numbers-wrapper button').on('click', function(){
    const selection = $(this).data('value');
    const targetName = $(this).parent().data('name');
    $(`.question-wrapper input[name="${targetName}"`).val(selection);
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
      setTimeout(function(){
        $('body').removeClass('success-submitting-answers');
      }, 5000);
    },
    error: function(resp){
      $('body').removeClass('submitting-answers');
      $('body').removeClass('dirty-answers');
      $('body').addClass('error-submitting-answers');
      console.warn('Error submitting answers.');
      setTimeout(function(){
        $('body').removeClass('error-submitting-answers');
      }, 5000);
    }
  });
}

function attemptToFillPreviousAnswers($){
  if(window.previous_application_answers == undefined) return;
  for(const [key, value] of Object.entries(window.previous_application_answers)){
    const targetEl = $(`.question-wrapper .question-answer[name=${key}]`).eq(0);
    if($(targetEl).hasClass('scale')){
      targetEl.attr('value', value);
    }
    if(
      $(targetEl).hasClass('textarea') ||
      $(targetEl).hasClass('multipart')
    ){
      targetEl.val(value);
    }
  }
  $('.question-wrapper.scale .question-answer').each(function(){
    const selection = $(this).val();
    const targetEl = $(`.question-wrapper.scale .numbers-wrapper button[data-value="${selection}"]`);
    $(targetEl).addClass('active');
    $(targetEl).prevAll().addClass('active');
  });
}