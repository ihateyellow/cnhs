$(document).ready(function(){
	
	// display name
	$('.txt-name').text(localStorage.name);

	// FORM LOAD
	var type = 'getAllUser';
	$.post(sAjaxUrl,{ type : type }, function(rs){

		// console
		console.log(rs);

		// append data :: memberlist for chat
		var l = '';
		$('.ulist').html('');
		$.each(rs.users,function(sKey,sVal){
			l += '<li data-icon="user" data-toggle="modal" data-target="#modalViewAccount" data-userid="'+sVal.userid+'" ><a href="#"> '+ sVal.name +' </a></li>';
		});
		$('.ulist').html(l);
		


		// append data :: memberlist for manage account
		var l = '';
		$('.updatelist').html('');
		$.each(rs.users,function(sKey,sVal){
			l += '<li data-icon="edit"><a href="#"  class="li-update-loader" data-userid="'+sVal.userid+'"  data-toggle="modal" data-target="#modalUpdateAccount"> '+ sVal.name +' </a></li>';
		});
		$('.updatelist').html(l);
		
		// refresh all all listview
		$(".lv").listview("refresh"); 
	
	},'JSON');


	// user cache 
	if(localStorage.getItem('id') === null || localStorage.getItem('id') === ''){
		redirect('messenger');
	}else{

		// profile 
		var type = 'getUserData';
		var userid = localStorage.getItem('id')
		$.post(sAjaxUrl,{ type : type , userid : userid },function(rs){

			// console.log
			console.log(rs);
	
			// transmit profile 
			var acc = rs.account[0];
			$('.txt-userid').text(acc.userid);
			$('.txt-userrole').text(acc.userrole);
			$('.txt-username').text(acc.username);
			$('.txt-yearlevel').text(acc.yearlevel);
			$('.txt-gender').text(acc.gender);
			$('.txt-age').text(acc.age);
			$('.txt-address').text(acc.address);
			$('.txt-yearlevel').text(acc.yearlevel);
			$('.txt-section').text(acc.section);
			$('.txt-schoolyear').text(acc.schoolyear);
			$('.txt-contactno').text(acc.contactno);
			$('.txt-datecreation').text(acc.datecreation);
			$('.txt-datemodified').text(acc.datemodified);
		},'JSON');
	
		// account - form privilege for admin
		if(localStorage.role === 'admin'){

			// Yearl Level
			var tYL = "<option>First Year</option><option>Second Year</option><option>Third Year</option><option>Fourth Year</option><option>Faculty</option>";
			$('.l-yearlevel').html(tYL);

			// School Year
			var tSY = "<option>2016-2017</option>";
			$('.l-schoolyear').html(tSY);

			// Role
			var tR = "<option value='admin'>Principal</option><option value='teacher'>Teacher</option><option value='student'>Student</option>";
			$('.l-userrole').html(tR);
		}	

		// account - form privilege for teacher
		if(localStorage.role === 'teacher'){

			// Yearl Level
			var tYL = "<option>First Year</option><option>Second Year</option><option>Third Year</option><option>Fourth Year</option>";
			$('.l-yearlevel').html(tYL);

			// School Year
			var tSY = "<option>2016-2017</option>";
			$('.l-schoolyear').html(tSY);

			// Role
			var tR = "<option value='student'>Student</option>";
			$('.l-userrole').html(tR);
		}	
	}

	// add account
	$('.btn-addaccount').on('click',function(){

		// prepare data 
		var username = $('.i-username').val();
		var password = $('.i-password').val();
		var name = $('.i-name').val();
		var age = $('.i-age').val();
		var gender = $('.i-gender').val();
		var contactno = $('.i-contactno').val();
		var yearlevel = $('.i-yearlevel').val();
		var userrole = $('.i-userrole').val();
		var section = $('.i-section').val();
		var schoolyear = $('.i-schoolyear').val();
		var address = $('.i-address').val();

		// validation 
		if(username.length && password.length && name.length && userrole.length && yearlevel.length && section.length && schoolyear.length){

			// console 
			console.log('add record');

			// ajax add account
			var type = 'addAcount'; 
			btn = $(this);
			$.post(sAjaxUrl, { type : type , username : username , password : password , name : name , age : age , gender : gender , contactno : contactno , yearlevel : yearlevel , userrole : userrole , section : section , schoolyear : schoolyear , address : address },function(rs){

				// console 
				console.log(rs);

				// expression
				if(rs.flag === 1 ){
					bootbox.alert("Added new account");
					location.reload();
				}else{
					bootbox.alert("Username is already in use");
				}

			},'JSON');

		}else{
			bootbox.alert('Parameters should not be empty.')
		}
	});


	// refill form
	$('.updatelist').delegate('.li-update-loader','click',function(){
		
		// initialize
		var li = $(this);
		var userid =  li.attr('data-userid');
		var type = 'getUserData';

		console.log(userid);
		// fetch data of selected li
		$.post(sAjaxUrl, { type : type , userid : userid },function(rs){
			
			// console
			console.log(rs);

			// prepare
			var acc = rs.account[0];

			// transmit to elements
			$('.u-status').val( acc.status );
			$('.u-username').val( acc.username );
			$('.u-name').val( acc.name);
			$('.u-age').val( acc.age );
			$('.u-gender').val( acc.gender );
			$('.u-contactno').val( acc.contactno );
			$('.u-yearlevel').val( acc.yearlevel );
			$('.u-userrole').val( acc.userrole);
			$('.u-section').val( acc.section );
			$('.u-schoolyear').val( acc.schoolyear );
			$('.u-address').val( acc.address );

			$('.btn-updateaccount').attr('data-userid',acc.userid);

		},'JSON');

	});


	$('.btn-updateaccount').on('click',function(){

		// prepare 
		var username = $('.u-username').val();
		var password = $('.u-password').val();
		var name = $('.u-name').val();
		var age = $('.u-age').val();
		var gender = $('.u-gender').val();
		var contactno = $('.u-contactno').val();
		var yearlevel = $('.u-yearlevel').val();
		var userrole = $('.u-userrole').val();
		var section = $('.u-section').val();
		var schoolyear = $('.u-schoolyear').val();
		var address = $('.u-address').val();
		var status = $('.u-status').val();
		var userid = $(this).attr('data-userid');

		// validation 
		if(username.length && password.length && name.length && userrole.length && yearlevel.length && section.length && schoolyear.length){

			// console 
			console.log('update record');

			// ajax add account
			var type = 'updateAccount'; 
			btn = $(this);
			$.post(sAjaxUrl, { type : type , userid : userid , status : status ,  username : username , password : password , name : name , age : age , gender : gender , contactno : contactno , yearlevel : yearlevel , userrole : userrole , section : section , schoolyear : schoolyear , address : address },function(rs){

				// console 
				console.log(rs);

				// expression
				if(rs.flag === 1 ){
					bootbox.alert("Update an account");
					location.reload();
				}

			},'JSON');

		}else{
			alert('Parameters should not be empty.')
		}
	});
	
	// view someone's profile
	$('.ulist').delegate('li','click',function(){
		
		// initialize
		var li = $(this);
		var userid =  li.attr('data-userid');
		var type = 'getUserData';
		
		// fetch data of selected li
		$.post(sAjaxUrl, { type : type , userid : userid },function(rs){
			
			// console
			console.log(rs);

			// prepare
			var acc = rs.account[0];

			// transmit to elements
			$('.v-userid').text( acc.userid );
			$('.v-status').text( acc.status );
			$('.v-username').text( acc.username );
			$('.v-name').text( acc.name);
			$('.v-age').text( acc.age );
			$('.v-gender').text( acc.gender );
			$('.v-contactno').text( acc.contactno );
			$('.v-yearlevel').text( acc.yearlevel );
			$('.v-userrole').text( acc.userrole);
			$('.v-section').text( acc.section );
			$('.v-schoolyear').text( acc.schoolyear );
			$('.v-address').text( acc.address );
			$('.btn-chataccount').attr('data-userid',acc.userid);

		},'JSON');

	});
});