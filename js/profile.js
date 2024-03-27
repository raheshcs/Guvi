function logout()
{
    localStorage.removeItem('uid');
    window.location.replace("http://127.0.0.1:5500/index.html");
}
function route()
{
    if(localStorage.getItem('uid')===undefined || localStorage.getItem('uid')==='')
    {
        window.location.replace("http://127.0.0.1:5500/index.html");
    }
    else
    {
        const uid=localStorage.getItem('uid');
        $.ajax({
			url: 'http://localhost:3000/php/profile.php',
			type: 'POST',
			dataType:"json",
			data:{
				Email:uid
			},
			success: function(response) {
                $('#userName').html(response.name);
                $('#Name').html(response.name);
                $('#email').html(response.email);  
                $('#phone').html(response.phone);  
                $('#DOB').html(response.DOB);
                $('#guviid').html(response.id);
                console.log("From :"+response.from);
			},
			error: function(response)
			{
				alert("Something went wrong in front end");
			}

		});
        document.getElementById('hideboard').style.display="none";
    }
}
$(document).ready(function() {
	$('#upd').submit(function(e) {
		e.preventDefault();
        var Name = $('#newName').val();
        var DOB=$('#newDOB').val();
		var Phone=$('#newPhone').val();
        var Email=localStorage.getItem('uid');
		$.ajax({
			url: 'http://localhost:3000/php/update.php',
			type: 'POST',
			dataType:"json",
			data:{
				Name: Name,
				Email:Email,
				DOB:DOB,
				Phone:Phone
			},
			success: function(response) {
                console.log("Success");
                location.reload();
			},
			error: function(response)
			{
				alert("Something went wrong in front end");
			}

		});

	});
});

function display()
{
    document.getElementById('hideboard').style.display="block";
}
function clo()
{
    document.getElementById('hideboard').style.display="none";
}




