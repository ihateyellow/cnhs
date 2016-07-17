// GLOBAL DECLARATION

// config
var sAjaxUrl = 'http://192.168.254.102/cnhs/server/ajax.php';
var siteUrl = window.location.origin+'/cnhs/';

// FUNCTIONS

// page redirection
function redirect(sUrl){
	window.location.assign(sUrl+'.html');
}

function clearLog(){
	// remove item in local storage / browser
	localStorage.removeItem('id');
	localStorage.removeItem('role');
	localStorage.removeItem('name');
	localStorage.removeItem('username');

}

$(document).ready(function(){

	// form load 
	
	// clear cache
	if($('body').hasClass('cnhs') !== true){
		clearLog();
	}

	// EVENTS

	// login 	
	$('.btn-login').on('click',function(){
		var username = $('.inp-username').val();
		var password = $('.inp-password').val();
		var type = 'login';
		$.post(sAjaxUrl, { type : type , username : username , password : password },function(rs){
			
			// console
			console.log(rs.account);
			if(rs.account.length){

				// transmit fetched data
				var acc = rs.account[0];

				// save to local storage / browser 
				localStorage.setItem('id',acc.userid);
				localStorage.setItem('role',acc.userrole);
				localStorage.setItem('name',acc.name);
				localStorage.setItem('username',acc.username);

				// redirect to another page 
				redirect('account');

			}else{
				bootbox.alert('your account might invalid or deactivated.');
			}

		},'JSON');
	});

	// logout
	$('.btn-logout').on('click',function(){
		//console
		console.log('logout');

		// remove item in local storage / browser
		localStorage.removeItem('id');
		localStorage.removeItem('role');
		localStorage.removeItem('name');
		localStorage.removeItem('username');

		// redirect
		redirect('messenger');

	});



});