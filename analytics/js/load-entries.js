jQuery(document).ready(function($){
  const answers = window.application_answers;
  for(const [field, answer] of Object.entries(answers)){
    const el = $(`.forminator-field [name=${field}]`);
    $(el).val(answer.value);
  }
  console.log('Answers filled.');
});