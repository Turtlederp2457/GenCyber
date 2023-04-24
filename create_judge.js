const btn = document.getElementById('create_judge_btn');

btn.addEventListener('click', () => {
  const form = document.getElementById('create_judge_form');

  if (form.style.display === 'none') {
    // 👇️ this SHOWS the form
    create_judge_form.style.display = 'block';
  } else {
    // 👇️ this HIDES the form
    create_judge_form.style.display = 'none';
  }
});
