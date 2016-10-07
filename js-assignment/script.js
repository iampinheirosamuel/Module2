(function(){
	var names = ["Yaakov", "John", "Jen","Jason", "Paul","Paula","Laura","Jim"];  
   for (var i =0; i< names.length; i++) {
   	var firstletter = names[i].charAt(0).toLowerCase();
   	if(firstletter==='j' || firstletter==='J'){
       byeSpeaker.speak(names[i]);
   	}else{
   		helloSpeaker.speak(names[i]);
   	}
   }
})();