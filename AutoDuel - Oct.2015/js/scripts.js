function redirect(page){
	window.location='../AutoDuel_Main/pages/'+page;
}

function redirectPage(page){
	window.location=page;
}

function emailFunction(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		window.open('mailto:me@tash-had.com'); 
	}else{
		window.prompt('Press Ctrl+C to Copy', 'me@tash-had.com'); 
	}
}

function printPage(){
	var prtContent = document.getElementById("agendaColumn");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
}

function indexAnim(){	
	$("button").hide();
	$("button").show(600);
	$("span").hide();
	$("span").slideDown(600);
}
function startAnim(){
	$("input").hide();
	$("input").show(1000);
}
function aboutAnim(){
	$("p").hide();
	$("p").show(1000);
}
