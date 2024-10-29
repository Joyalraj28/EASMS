$(document).ready(function(){

	$(".megabutton-LunchIn").click(function(){
		$.ajax({
			url:'./Class/Attendancemark.php?f=Lunchout',
			method:'POST',
			data:$("#attent-frm").serialize(),
			error:err=>{
					console.log(err)
					alert("Error");
				},
			success:function(resp){
				console.log(resp)
				alert(resp);

				ShowMessage(resp);
			}
		})

	  });

	
	$(".megabutton-SignOut").click(function(){
		alert("SignOut");
		$.ajax({
			url:'./Class/Attendancemark.php?f=signout',
			method:'POST',
			data:$("#attent-frm").serialize(),
			error:err=>{
					console.log(err)
					alert("Error");
				},
			success:function(resp){
				
				ShowMessage(resp);
			}
		})
	});

	

	$('#attent-frm').submit(function(e){
			e.preventDefault()
			$('.infomessage').empty()
			$('.infofram').empty()
			$.ajax({
				url:'./Class/Attendancemark.php?f=Signin',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err);
	
				},
				success:function(resp){

					console.clear();
					console.log(resp);

					ShowMessage(resp);
					
				}
			})
		});
	});


	function ShowMessage(resp)
	{
		if(resp)
		{  
			
			resp = JSON.parse(resp);
			console.log(resp);

			$(".megabutton-LunchIn").attr("hidden",true);
			$(".megabutton-SignOut").attr("hidden",true);
		
			if(resp.status == 'showbtn')
			{
				//Add Lunch in && sign out buttion
				$(".megabutton-LunchIn").attr("hidden",false);
				$(".megabutton-SignOut").attr("hidden",false);

				// var megabuttionhtml = ''
				// $(".megabutton").prepend(megabuttionhtml)
				
			}
			else if(resp.status == 'leave')
			{}
			else if(resp.status == 'success'){
				//show message
				var _msg = "<div style='width: 400px;' class='alert alert-success' role='alert'><i class='fa fa-info-circle'></i><b style='margin-left: 10px;'><b>Employee attendance mark successfully</b></div>"
				$('.infomessage').prepend(_msg)
				//show employee data
				var empfrm='<div class="infocard"> <div class="imginfo">  <img src="'+resp.message.Avatar+'" alt=""> </div>  <div class="bioinfo" style="display:flex;flex-direction:column;justify-content:center;align-items:start">  <div style="display:flex;"><p style="font-weight:600">Name :</p>  <p>'+resp.message.Fullname+'</p> </div><div style="display:flex;"><p  style="font-weight:600">Designation:</p>  <p>'+resp.message.DesignationName+'</p>  </div></div>'
				$(".infofram").prepend(empfrm)
				
				$(".content").find('input').val('')

			}else if(resp.status == 'incorrect'){

				//show error message
				var _frm = $('.infomessage')
				var _msg = " <div style='width: 400px;' class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i><b style='margin-left: 10px;'>Invalid Employee ID</b></div>"
				_frm.prepend(_msg)
			}

			else if(resp.status == 'error'){

				//show error message
				var _frm = $('.infomessage')
				var _msg = " <div style='width: 400px;' class='alert alert-danger' role='alert'><i class='fa fa-exclamation-triangle'></i><b style='margin-left: 10px;'>"+resp.message+"</b></div>"
				_frm.prepend(_msg)
			}


			
			
		}
	}