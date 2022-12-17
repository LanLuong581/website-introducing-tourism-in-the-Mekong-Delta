
const btn =document.querySelector('.talk');
const content = document.getElementById("content");
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();
recognition.onstart=function(){
    console.log('voice is active');
};
recognition.onresult=function(event){
    console.log(event);
    const current = event.resultIndex;
    const transcript = event.results[current][0].transcript;
    content.value=transcript;
};
// add the listener
btn.addEventListener('click',()=>{
    recognition.start();
});
