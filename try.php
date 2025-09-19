<script>
  // Toggle dyslexia-friendly mode
  document.getElementById('toggle-dyslexia').addEventListener('click', () => {
    document.body.classList.toggle('dyslexia-mode');
  });

  // Text-to-Speech function
  function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.rate = 1;   // normal speed
    utterance.pitch = 1;  // natural tone
    speechSynthesis.speak(utterance);
  }

  // Read entire page content
  document.getElementById('read-all').addEventListener('click', () => {
    let text = document.body.innerText;
    speechSynthesis.cancel(); // stop any previous speech
    speak(text);
  });

  // Add TTS buttons for each course card dynamically
  document.querySelectorAll('.course-card').forEach((card, index) => {
    let btn = document.createElement('button');
    btn.innerText = "🔊 Read Course";
    btn.className = "tts-button";
    btn.onclick = () => {
      let text = card.innerText;
      speechSynthesis.cancel();
      speak(text);
    };
    card.querySelector('.p-6').appendChild(btn);
  });
</script>


<script>
  // Toggle Dyslexia-Friendly Mode
  document.getElementById('toggle-dyslexia').addEventListener('click', () => {
    document.body.classList.toggle('dyslexia-mode');
  });

  // Speak function
  function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.rate = 1; // normal speed
    utterance.pitch = 1; // natural tone
    speechSynthesis.speak(utterance);
  }

  // Read whole page
  document.getElementById('read-all').addEventListener('click', () => {
    let text = document.body.innerText;
    speechSynthesis.cancel();
    speak(text);
  });

  // Add TTS buttons to course cards
  document.querySelectorAll('.course-card').forEach((card, index) => {
    let btn = document.createElement('button');
    btn.innerText = "🔊 Read Course";
    btn.className = "tts-button";
    btn.onclick = () => {
      let text = card.innerText;
      speechSynthesis.cancel();
      speak(text);
    };
    card.querySelector('.p-6').appendChild(btn);
  });
</script>

