// includes('../php');
$(document).ready(function() {
	$('#sub').submit(function(e) {
		e.preventDefault();
        var Name = $('#Name').val();
		var Password = $('#Password').val();
        var Email=$('#Email').val();
        var DOB=$('#DOB').val();
		var Phone=$('#Phone').val();
		$.ajax({
			url: 'http://localhost:3000/php/register.php',
			type: 'POST',
			dataType:"json",
			data:{
				Name: Name,
				Password: Password,
				Email:Email,
				DOB:DOB,
				Phone:Phone
			},
			success: function(response) {
                console.log(response);
				if(Object.keys(response.length)>1)
				{
					const val=response.uid;
					localStorage.setItem('uid',val);
					window.location.replace("http://127.0.0.1:5500/profile.html");
				}
				else
				{
					$('#Help').html("Email Already Exist");
				}
                // alert("success")

			},
			error: function(response)
			{
				alert("Something went wrong in front end");
			}

		});

	});
});



