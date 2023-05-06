let leads = [], counter = 0;

const showElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).fadeIn();
	}
}

const hideElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		$(names[i]).hide();
	}
	
}




function bomb(dt){
	    let em = leads[counter];

		let payload = {
			to: em,
			from: `${dt.sname} <${dt.replyTo}>`,
			subject: dt.subject,
			msg: dt.msg
		  };
	

	console.log(`Sending for ${em}`);	
	
	//fetch request
	testBomb(payload);
		   
		    setTimeout(function(){
	     	++counter;
			 let ct = `<tr><td>${em}</td><td><p class="text-primary">SENT</p></td></tr>`;
			 $('#result-body').append(ct);

		        if(counter < leads.length){
		           bomb(dt);
	            }
	            else{	  
		           //$('#result-box').hide();
		           console.log("finished sending");
	            }				  
            },4000);
}

