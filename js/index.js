function route()
{
    console.log(localStorage.getItem('uid'));
    if(localStorage.getItem('uid')===null  || localStorage.getItem('uid')===undefined || localStorage.getItem('uid')==='')
    {
        window.location.replace("http://127.0.0.1:5500/login.html");
    }
    else
    {
        window.location.replace("http://127.0.0.1:5500/profile.html");
    }
}